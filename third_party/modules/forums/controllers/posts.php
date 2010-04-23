<?php
class Posts extends Public_Controller {

	function __construct()
	{
		parent::Public_Controller();
		
		$this->load->model('forums_m');
		$this->load->model('forum_posts_m');

		$this->lang->load('forum');
		
		//$this->load->helper('bbcode');
		
		// Add a link to the forum CSS into the head
		$this->template->append_metadata( css('forum.css', 'forums') );
		$this->template->set_partial('breadcrumbs', 'partials/breadcrumbs');
		$this->template->set_breadcrumb('Home', '/');
		$this->template->set_breadcrumb('Forum Home', 'forums');
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
		($quote = $this->forum_posts_m->getPost($post_id)) || show_404();

		// Send the message object through
		$this->session->set_flashdata('forum_quote', serialize($quote));
		
		$topic->id = $quote->parent_id > 0 ? $quote->parent_id : $quote->id;
		
		// Redirect to the normal reply form. It will pick the quote up
		redirect('forums/posts/new_reply/'.$topic->id);
	}

	
	function new_reply($topic_id = 0)
	{
		if(!$this->ion_auth->logged_in())
		{
			redirect('users/login');
		}
		
		//$this->load->helpers(array('smiley', 'bbcode'));

		// Get the forum name
		$topic = $this->forum_posts_m->getTopic($topic_id);
		$forum = $this->forums_m->get(@$topic->forum_id);
		
		// Chech if there is a forum with that ID
		if(!$topic or !$forum)
		{
			show_404();
		}

		// If there was a quote, send it to the view
		$this->data->quote = unserialize($this->session->flashdata('forum_quote'));

		// We'll assume there was no preview, unless told otherwise later
		$this->data->show_preview = FALSE;
		
		// The form has been submitted one way or another
		if($this->input->post('submit') or $this->input->post('preview'))
		{
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('text', 'Message', 'trim|strip_tags|required');
			$this->form_validation->set_rules('notify', 'Subscription notification', 'trim|strip_tags|max_length[1]');

			if ($this->form_validation->run() === TRUE)
			{
				if( $this->input->post('submit') )
				{
					$reply->title = set_value('title');
					$reply->text = set_value('text');
					
					if($reply->id = $this->forum_posts_m->new_reply($this->ion_auth->profile()->id, $reply, $topic))
					{
						// Add user to notify
						//if($notify) $this->forum_posts_m->AddNotify($topic->id, $this->user_lib->user_data->id );
						
						redirect('forums/posts/view_reply/'.$topic->id);
					}
					
					else
					{
						show_error("Error Message:  Error accured while adding topic");
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
				$this->data->validation_errors = $this->form_validation->error_string();
			}
		}
		
		$this->data->forum =& $forum;
		$this->data->topic =& $topic;
		
		// Set this for later
		$this->template->set_breadcrumb($forum->title, 'forums/view/'.$topic->forum_id); 
		$this->template->set_breadcrumb($topic->title, 'forums/topics/view/'.$topic->id);
		$this->template->set_breadcrumb('New Reply');
		$this->template->build('posts/new_reply', $this->data);
	}

}
?>