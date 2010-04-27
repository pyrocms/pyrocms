<?php
class Posts extends Public_Controller {

	function __construct()
	{
		parent::Public_Controller();
		
		$this->load->model('forums_m');
		$this->load->model('forum_posts_m');
		$this->load->model('forum_subscriptions_m');
		$this->load->helper('bbcode');
		$this->load->library('pyro_forums');
		$this->lang->load('forums');
		
		//$this->load->helper('bbcode');
		$this->template->enable_parser_body(FALSE);

		// Add a link to the forum CSS into the head
		$this->template->append_metadata(js('bbcode.js', 'forums'));
		$this->template->set_breadcrumb('Home', '/');
		$this->template->set_breadcrumb('Forums', 'forums');
	}
	

	function view_reply($reply_id = 0)
	{
		($reply = $this->forum_posts_m->get_reply($reply_id)) || show_404();
		
		// This is a reply
		if($reply->parent_id > 0)
		{
			redirect('forums/topics/view/'.$reply->parent_id.'#'.$reply_id);
		}
		
		// This is a new topic
		else
		{
			redirect('forums/topics/view/'.$reply_id);
		}
	}


	function quote_reply($post_id)
	{
		($quote = $this->forum_posts_m->get_post($post_id)) || show_404();

		// Send the message object through
		$this->session->set_flashdata('forum_quote', serialize($quote));
		
		$topic->id = $quote->parent_id > 0 ? $quote->parent_id : $quote->id;
		
		// Redirect to the normal reply form. It will pick the quote up
		redirect('forums/posts/new_reply/'.$topic->id);
	}


	function new_reply($topic_id = 0)
	{
		$this->ion_auth->logged_in() or redirect('users/login');

		// Get the forum name
		$topic = $this->forum_posts_m->get_topic($topic_id);
		$forum = $this->forums_m->get(@$topic->forum_id);

		// Chech if there is a forum with that ID
		($topic and $forum) or show_404();

		if($this->session->flashdata('forum_quote'))
		{
			$quote = unserialize($this->session->flashdata('forum_quote'));
			$reply->content = '[quote]'.$quote->content.'[/quote]';
		}

		else
		{
			$reply->content = set_value('content');
		}
		$reply->notify = $this->forum_subscriptions_m->is_subscribed($this->user->id, $topic_id);

		// The form has been submitted one way or another
		if($this->input->post('submit') or $this->input->post('preview'))
		{
			$this->load->library('form_validation');

			$this->form_validation->set_rules('content', 'Message', 'trim|strip_tags|required');
			$this->form_validation->set_rules('notify', 'Subscription notification', 'trim|strip_tags|max_length[1]');

			if ($this->form_validation->run() === TRUE)
			{
				if( $this->input->post('submit') )
				{

					$reply->id = $this->forum_posts_m->new_reply($this->user->id, $reply, $topic);


					if($reply->id)
					{
						$reply->title = $topic->title;
						$reply->topic_id = $topic->id;
						$recipients = $this->pyro_forums->get_recipients($topic_id);

						$this->pyro_forums->notify_reply($recipients, $reply);

						// Add user to notify
						if($this->input->post('notify') == 1)
						{
							$this->forum_subscriptions_m->add($this->user->id, $topic->id);
						}
						else
						{
							$this->forum_subscriptions_m->delete_by(array('user_id' => $this->user->id, 'topic_id' => $topic->id));
						}

						redirect('forums/posts/view_reply/'.$reply->id);
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

		$this->data->quote =& $quote;
		$this->data->reply =& $reply;
		$this->data->forum =& $forum;
		$this->data->topic =& $topic;

		$this->data->bbcode_buttons = get_bbcode_buttons('content');

		$this->template->set_partial('bbcode', 'partials/bbcode');
		$this->template->set_breadcrumb($forum->title, 'forums/view/'.$topic->forum_id);
		$this->template->set_breadcrumb($topic->title, 'forums/topics/view/'.$topic->id);
		$this->template->set_breadcrumb('New Reply');
		$this->template->build('posts/reply_form', $this->data);
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