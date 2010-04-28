<?php
class Topics extends Public_Controller {

	function Topics()
	{
		parent::Public_Controller();
		
		$this->load->model('forums_m');
		$this->load->model('forum_posts_m');
		$this->load->model('forum_subscriptions_m');
		$this->load->helper('bbcode');
		$this->load->helper('smiley');
		$this->lang->load('forums');
		
		//$this->load->helper('bbcode');
		$this->template->enable_parser_body(FALSE);
		
		$this->template->append_metadata(js('bbcode.js', 'forums'));

		$this->template->set_breadcrumb('Home', '/');
		$this->template->set_breadcrumb('Forums', 'forums');
	}
	
	function view($topic_id = 0, $offset = 0)
	{
		// Update view counter
		$this->forum_posts_m->add_topic_view($topic_id);
		
		// Pagination junk
		$this->load->library('pagination');
		$per_page = '10';
		if($offset < $per_page) $offset = 0;
		$config['base_url'] = site_url('forums/topics/view/'.$topic_id);
		$config['total_rows'] = $this->forum_posts_m->count_posts_in_topic($topic_id);
		$config['per_page'] = $per_page;
		$config['uri_segment'] = 5;
		$this->pagination->initialize($config); 
		// End Pagination

		// Which topic in which forum are we looking at?
		($topic = $this->forum_posts_m->get($topic_id)) or show_404();
		($forum = $this->forums_m->get($topic->forum_id)) or show_404();
	
		// Get a list of posts which have no parents (topics) in this forum
		$topic->posts = $this->forum_posts_m->get_posts_by_topic($topic_id, $offset, $per_page);
		foreach($topic->posts as &$post)
		{
			$post->author = $this->forum_posts_m->author_info($post->author_id);
			$post->author->post_count =  $this->forum_posts_m->count_user_posts($post->author_id);
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
			$this->form_validation->set_rules('content', 'Message', 'trim|required');

			if ($this->form_validation->run() === TRUE)
			{
				if( $this->input->post('submit') )
				{
					$topic->title = set_value('title');
					$topic->content = htmlspecialchars_decode(set_value('content'), ENT_QUOTES);
					
					if($topic->id = $this->forum_posts_m->new_topic($this->user->id, $topic, $forum))
					{
						// Add user to notify
						if($this->input->post('notify') == 1)
						{
							$this->forum_subscriptions_m->add($this->user->id, $topic->id);
						}
						else
						{
							$this->forum_subscriptions_m->delete_by(array('user_id' => $this->user->id, 'topic_id' => $topic->id));
						}
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

		$this->data->bbcode_buttons = get_bbcode_buttons('content');

		$this->template->set_partial('bbcode', 'partials/bbcode');

		$this->template->set_breadcrumb($forum->title, 'forums/view/'.$forum->id);
		$this->template->set_breadcrumb('New Topic');
		$this->template->build('posts/new_topic', $this->data);
	}

	function stick($topic_id)
	{
		$this->ion_auth->logged_in() or redirect('users/login');

		$this->ion_auth->is_admin() or show_404();

		if($this->forum_posts_m->update($topic_id, array('sticky' => 1)))
		{
			$this->session->set_flashdata('success', 'Topic has been made sticky.');
		}
		else
		{
			$this->session->set_flashdata('error', 'Topic could not be made sticky.');

		}
		redirect('forums/topics/view/' . $topic_id);
	}

	function unstick($topic_id)
	{
		$this->ion_auth->logged_in() or redirect('users/login');

		$this->ion_auth->is_admin() or show_404();

		if($this->forum_posts_m->update($topic_id, array('sticky' => 0)))
		{
			$this->session->set_flashdata('success', 'Topic has been unstuck.');
		}
		else
		{
			$this->session->set_flashdata('error', 'Topic could not be unstuck.');

		}
		redirect('forums/topics/view/' . $topic_id);
	}

}
?>