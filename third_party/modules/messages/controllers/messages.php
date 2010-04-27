<?php
class Messages extends Public_Controller {

	function __construct()
	{
		parent::Public_Controller();
		
		$this->load->model('messages_m');
		$this->load->helper('bbcode');
		$this->lang->load('messages');
		
		$this->template->enable_parser_body(FALSE);

		// Add a link to the forum CSS into the head
		$this->template->append_metadata(js('bbcode.js', 'forums'));
		$this->template->set_breadcrumb('Home', '/');
		$this->template->set_breadcrumb('Forums', 'forums');
		$this->template->set_breadcrumb('Messages', 'forums/messages');
	}
	

	function view($message_id = 0)
	{
		//If not logged in go to login page
		$this->ion_auth->logged_in() or redirect('users/login');

		//If it's an invalid message, show 404
		($message = $this->messages_m->get($message_id)) || show_404();

		//Redirect to login if this is another users message
		if($this->user->id != $message->to_id)
		{
			$this->session->set_flashdata('error', 'You can not view other user messages.');
			redirect('forums');
		}

		//Get from and to user info
		$from = $this->ion_auth_model->get_user($message->from_id)->row();
		$to = $this->ion_auth_model->get_user($message->to_id)->row();

		//Set template data
		$this->data->message =& $message;
		$this->data->from =& $from;
		$this->data->to =& $to;

		//Set breadcrumbs
		$this->template->set_breadcrumb($message->subject);

		//Show the template
		$this->template->build('messages/view', $this->data);
	}


	function create($to_id)
	{
		//If not logged in go to login page
		$this->ion_auth->logged_in() or redirect('users/login');

		$this->load->library('form_validation');

		$this->form_validation->set_rules('to_id', 'To', 'trim|xss_clean|strip_tags|required');
		$this->form_validation->set_rules('subject', 'Subject', 'trim|xss_clean|strip_tags|required');
		$this->form_validation->set_rules('content', 'Message', 'trim|xss_clean|strip_tags|required');
		
		$message->subject = set_value('subject');
		$message->content = set_value('content');

		// The form has been submitted one way or another
		if($this->input->post('submit') or $this->input->post('preview'))
		{
			if ($this->form_validation->run() === TRUE)
			{
				if( $this->input->post('submit') )
				{
					$message_arr = array(
						'from_id' => $this->user->id,
						'to_id' => $this->input->post('to_id'),
						'subject' => $this->input->post('subject'),
						'content' => $this->input->post('content'),
						'sent' => now(),

					);

					$message = $message_arr;
					$message->id = $this->messages_m->insert($message_arr);
					$message->from = $this->user->first_name . ' ' . $this->user->last_name;

					if($message->id)
					{
						$this->pyro_messages->notify($this->ion_auth_model->get_user($message->to_id)->row()->email, $message);

						redirect('messages');
					}

					else
					{
						show_error("Error sending message.");
					}
				}
				elseif( $this->input->post('preview') )
				{
					$this->data->show_preview = TRUE;
				}
			}
		}
		$this->data->to =& $this->ion_auth_model->get_user($to_id)->row();
		$this->data->message =& $message;

		$this->data->bbcode_buttons = get_bbcode_buttons();

		$this->template->set_partial('bbcode', 'partials/bbcode');
		$this->template->set_breadcrumb('New Message');
		$this->template->build('messages/create', $this->data);
	}
	
	function edit_reply($reply_id = 0)
	{
		$this->ion_auth->logged_in() or redirect('users/login');

		// Get the forum name
		$reply = $this->forum_posts_m->get($reply_id);
		$topic = $this->forum_posts_m->get_topic($reply->parent_id);
		$forum = $this->forums_m->get($reply->forum_id);

		// Chech if there is a forum with that ID
		($topic && $forum) or show_404();
		($this->user->id && $reply->author_id) or show_404();

		// Override with post data if it exists
		$this->input->post('content') and $reply->content = set_value('content');
		$this->input->post('notify') and $reply->notify = set_value('notify');

		// If there was a quote, send it to the view
		$this->data->quote = unserialize($this->session->flashdata('forum_quote'));

		// The form has been submitted one way or another
		if($this->input->post('submit') or $this->input->post('preview'))
		{
			$this->load->library('form_validation');

			$this->form_validation->set_rules('content', 'Message', 'trim|required');
			$this->form_validation->set_rules('notify', 'Subscription notification', 'trim|strip_tags|max_length[1]');

			if ($this->form_validation->run() === TRUE)
			{
				if( $this->input->post('submit') )
				{
					$reply->id = $this->forum_posts_m->update($reply_id, array(
						'content' => $reply->content
					));

					if($reply->id)
					{
						// Add user to notify
						//if($notify) $this->forum_posts_m->AddNotify($topic->id, $this->user->id );

						redirect('forums/posts/view_reply/'.$topic->id);
					}

					else
					{
						show_error("There was a problem adding thid reply.");
					}
				}

				// Preview button was hit, just show em what the post will look like
				elseif( $this->input->post('preview') )
				{
					// Define and Parse Preview
					//$this->data->preview = $this->forum_posts_m->postParse($message, $smileys);

					$this->data->show_preview = TRUE;
				}
			}

			else
			{
				$this->data->messages['error'] = validation_errors();
			}
		}
		$reply->notify = $this->forum_subscriptions_m->is_subscribed($this->user->id, $topic->id);
		$this->data->forum =& $forum;
		$this->data->topic =& $topic;
		$this->data->reply =& $reply;

		$this->template->set_partial('bbcode', 'partials/bbcode');
		$this->template->set_breadcrumb($forum->title, 'forums/view/'.$forum->id);
		$this->template->set_breadcrumb($topic->title, 'forums/topics/view/'.$topic->id);
		$this->template->set_breadcrumb('New Reply');

		$this->template->build('posts/reply_form', $this->data);
	}

	function delete_reply($reply_id)
	{
		$this->ion_auth->logged_in() or redirect('users/login');
		
		$reply = $this->forum_posts_m->get($reply_id);

		// Chech if there is a forum with that ID
		($this->user->id && $reply->author_id) or show_404();

		$this->forum_posts_m->delete($reply_id);

		$this->session->set_flashdata('notice', 'Your reply has been deleted.');
		redirect($_SERVER['HTTP_REFERER']);
	}
}
?>