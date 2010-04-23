<?php
class Topics extends Public_Controller {

	function Topics()
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
	
	function view($topic_id = 0, $offset = 0)
	{
		// Load all needed files
		//$this->load->helpers(array('smiley', 'bbcode', 'date'));
		$this->load->library('pagination');
		
		// Update view counter
		$this->forum_posts_m->increaseViewcount($topic_id);
		
		// Pagination junk
		$per_page = '10';
		if($offset < $per_page) $offset = 0;
		$config['base_url'] = site_url('forums/topics/view/'.$topic_id);
		$config['total_rows'] = $this->forum_posts_m->count_posts_in_topic($topic_id);
		$config['per_page'] = $per_page;
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config); 
		// End Pagination

		// Which topic in which forum are we looking at?
		$topic = $this->forum_posts_m->get($topic_id);
		$forum = $this->forums_m->get($topic->forum_id);
		
		// Check if topic exists, if not show 404
		if(!$topic or !$forum)
		{
			show_404();
		}
	
		// Get a list of posts which have no parents (topics) in this forum
		$topic->posts = $this->forum_posts_m->get_posts_by_topic($topic_id, $offset, $per_page);
		foreach($topic->posts as &$post)
		{
			$post->author = $this->forum_posts_m->author_info($post->author_id);
		}
		$this->data->topic =& $topic;
		$this->data->forum =& $forum;
		
		$this->data->pagination->offset = $offset;
		$this->data->pagination->links = $this->pagination->create_links();
		
		// Create page
		$this->template->title($topic->title);
		$this->template->set_breadcrumb($forum->title, 'forums/view/'.$forum->id);
		$this->template->set_breadcrumb($topic->title);
		$this->template->build('posts/view', $this->data);
	}


	function new_topic($forum_id = 0)
	{
		if(!$this->ion_auth->logged_in())
		{
			redirect('users/login');
		}
		
		//$this->load->helpers(array('smiley', 'bbcode'));

		// Get the forum name
		$forum = $this->forums_m->get($forum_id);
		
		// Chech if there is a forum with that ID
		if(!$forum)
		{
			show_404();
		}
		
		// Default this to a nope
		$this->data->show_preview = FALSE;
		
		if($this->input->post('submit') or $this->input->post('preview'))
		{
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('title', 'Title', 'trim|strip_tags|required|max_length[100]');
			$this->form_validation->set_rules('text', 'Message', 'trim|strip_tags|required');

			if ($this->form_validation->run() === TRUE)
			{
				if( $this->input->post('submit') )
				{
					$topic->title = set_value('title');
					$topic->text = set_value('text');
					
					if($topic->id = $this->forum_posts_m->new_topic($this->ion_auth->profile()->id, $topic, $forum))
					{
						// Add user to notify
						//if($notify) $this->forum_posts_m->AddNotify($topic->id, $this->user_lib->user_data->id );
						
						redirect('forums/topics/view/'.$topic->id);
					}
					
					else
					{
						show_error("Error Message:  Error Accured While Adding Topic");
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
		$this->template->set_breadcrumb($forum->title, 'forums/view/'.$forum->id);
		$this->template->set_breadcrumb('New Topic');
		$this->template->build('posts/new_topic', $this->data);
	}


	function unsubscribe($topic_id = 0)
	{
		$this->freakauth_light->check();

		$topic_id = intval($topic_id);
		if($this->forum_posts_m->unSubscribe($topic_id, $this->userID))
		{
			$this->template->error('You Were Successfully un-subscribed!');
		} else {
			$this->template->error('You are not subscribed to this topic.');
		}
		
		if(!empty($this->template->error_string)) $this->template->build('message', $this->data);
	}

}
?>