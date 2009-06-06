<?php
class Topics extends Controller {

	var $data;
	var $userID;

	function Topics()
	{
		parent::Controller();
		
		$this->load->module_model('account', 'usermodel');

		$this->load->model('forum_model');
		$this->load->model('post_model');

		$this->lang->load('forum');
		$this->config->load('forums');
		
		// Add a link to the forum CSS into the head
		$this->template->extra_head( css_asset('forum.css', 'forum') );
		
		$this->userID = getUserProperty('id');
		
		$this->data = array(
			'userID' =>$this->userID,
			// we need this so that there would not be a Notice: Undefined variable: message
			'message'	=> '',
		);
		
		if(isAdmin()):
			$this->template->navigation(array(
				'Manage Categories' => 'forums/admin/categories',
				'Manage Forums' => 'forums/admin/forums'
			));
		endif;
		
	}
	
	
	function index()
	{
		redirect('forums');
	}


	function view_topic($topicID = 0, $offset = 0)
	{
		// Load all needed files
		$this->load->helpers(array('smiley', 'bbcode', 'date'));
		$this->load->library('pagination');
	
		$topicID = intval($topicID);
		// Page`s
		$per_page = '10';

		if($offset < $per_page) $offset = 0;
		// we need the offset for the view_reply thing
		$this->data['offset'] = $offset;

		$topic_data = $this->post_model->getTopicData($topicID);
		// Check if topic exists
		if(!empty($topic_data))
		{
			$topic = array(
				'topicID'		=>	$topicID,
				'topic_name' 	=>	'',
				'post_list'		=> 	array()
			);
			
			// Get a list of posts which have no parents (topics) in this forum
			foreach($this->post_model->getPostsInTopic($topicID, $offset, $per_page) as $post):	
				if(empty($topic['topic_name'])):
					$topic['topic_name'] = $post['post_title'];
				endif;

				$post['post_text'] = $this->post_model->postParse($post['post_text'], $post['smileys']);
				$author = $this->usermodel->getUserById($post['authorID']);
				$post['author']	= $author->row_array();
				
				$topic['post_list'][] = $post;
			endforeach;

			// Pages
			$config['base_url'] = site_url('forums/topics/view_topic/'.$topicID);
			$config['total_rows'] = count($this->post_model->getTotalPostsInTopic($topicID));
			$config['per_page'] = $per_page;
			$config['uri_segment'] = 4;

			$this->pagination->initialize($config); 
			// End Pages
			
			$forum = $this->forum_model->getForum($post['forumID']);
			
			$this->data = array_merge($this->data, $forum, $topic);
			
			// Update view counter
			$this->post_model->increaseViewcount($topicID);

			// Create page
			$this->template->title($this->data['topic_name']);
			$this->template->crumb($this->data['forum_name'], 'forums/view_forum/'.$post['forumID']);
			$this->template->crumb($this->data['topic_name']);
			$this->template->create('view_topic', $this->data);
			
		} else {
			$this->template->error("The topic doesn`t exist!");
			$this->template->create('message', $this->data);
		}
	}


	function new_topic($forumID = 0)
	{
		$this->freakauth_light->check();
		$this->load->helpers(array('smiley', 'bbcode'));

		$forumID = intval($forumID);

		$topic = array(
			'userID'	=>	$this->userID,
			'title'		=>	'',
			'message'	=>	'',
			'notify'		=>	0,
			'smileys'		=>	1
		);

		// Get the forum name
		$forum = $this->forum_model->getForum($forumID);
		// Chech if there is a forum with that ID
		if(!empty($forum))
		{
			// Set this for later
			$this->template->crumb($forum['forum_name'], 'forums/view_forum/'.$forumID); 
			
			$this->data = array_merge($this->data, $forum, $topic);
			if(!empty($_POST['submit'])) {
			
				$forumID = intval($this->input->post('forumID'));
				$title = trim($this->input->post('title'));
				$title = strip_tags($title);
				$message = trim($this->input->post('message'));
				$message = strip_tags($message);
				$smileys = intval($this->input->post('smileys'));
				if($smileys != 1) $smileys = 0;
				$notify = intval($this->input->post('notify'));
				
				if($notify != 1) $notify = 0;
				// If empty title or message field display error
				if(empty($title)) $this->template->error("Error Message:  Your Title field is empty.");
				if(empty($message)) $this->template->error("Error Message:  Your Message field is empty.");
				// Ok if we havo no errors, continue
				if(empty($this->data['error_msg']) && $forumID > 0)
				{
					if($this->post_model->postTopic($this->userID, $forumID, $title, $message, $smileys))
					{
						// Get New topic ID
						$last_data = $this->post_model->getLastPost('user', $this->userID);
						// Add user to notify
						if($notify) $this->post_model->AddNotify($last_data['postID'], $this->userID);
						
						redirect('forums/topics/view_topic/'.$last_data['postID']);
					} else {
						$this->template->title('Forums > '. $this->data['forum_name']);
						$this->template->error("Error Message:  Error Accured While Adding Topic");
					}
				}
			} else if(!empty($_POST['preview'])) {
				// Get Title and Message
				$title = trim($this->input->post('title'));
				$title = strip_tags($title);
				$message = trim($this->input->post('message'));
				$message = strip_tags($message);
				$smileys = intval($this->input->post('smileys'));
				if($smileys != 1) $smileys = 0;
				$notify = intval($this->input->post('notify'));
				if($notify != 1) $notify = 0;
				// If empty title or message field display error
				if(empty($title)) $this->template->error("Error Message:  Your Title field is empty");
				if(empty($message)) $this->template->error("Error Message:  Your Message field is empty.");
				
				// Define data
				$this->data['title'] = $title;
				$this->data['message'] = $message;
				$this->data['smileys'] = $smileys;
				$this->data['notify'] = $notify;
				// Define and Parse Preview
				$this->data['preview'] = $this->post_model->postParse($message, $smileys);
				// Load View
				$this->template->title('Forums > '. $this->data['forum_name']);
				$this->template->create('new_topic', $this->data);
			} else {
				$this->template->title('Forums > '. $this->data['forum_name']);
				$this->template->create('new_topic', $this->data);
			}
		} else {
			$this->template->error('The forum doesn`t exist!');			
		}

		// we need to check if we allready have created view
		$output = $this->output->get_output();
		if(!empty($this->template->error_string) && empty($output)) $this->template->create('message', $this->data);
	}


	function unsubscribe($topicID = 0)
	{
		$this->freakauth_light->check();

		$topicID = intval($topicID);
		if($this->post_model->unSubscribe($topicID, $this->userID))
		{
			$this->template->error('You Were Successfully un-subscribed!');
		} else {
			$this->template->error('You are not subscribed to this topic.');
		}
		
		if(!empty($this->template->error_string)) $this->template->create('message', $this->data);
	}

}
?>