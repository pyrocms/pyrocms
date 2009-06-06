<?php
class Forums extends Public_Controller {

	var $data;
	var $userID;

	function Forums()
	{
		parent::Public_Controller();
				
		$this->load->model('forum_model');
		$this->load->model('post_model');

		$this->lang->load('forum');
		$this->config->load('forums');
		
		// Add a link to the forum CSS into the head
		$this->template->extra_head( css('forum.css', 'forum') );
		
		$this->user_id = $this->user_lib->user_data->id;
		
	}
	
	
	function index()
	{
		$this->load->helper('date');
		
		$this->data['category_list'] = array();
		
		// Get list of categories
		foreach($this->forum_model->getCategories() as $category):
			
			$category['forum_list'] = array();
			
			// Get a list of forums in each category
			foreach($this->forum_model->getForumList($category['categoryID']) as $forum):
				
				$forum['topic_count'] = count($this->post_model->getTopicsInForum($forum['forumID']));
				$forum['reply_count'] = count($this->post_model->getRepliesInForum($forum['forumID']));
				$forum['last_post']	  = $this->post_model->getLastPost('forum', $forum['forumID']);
				
				// Convert to unix and see how long ago it was posted
				$timespan = timespan(mysql_to_unix($forum['last_post']['post_date']));
				
				// If its set and doesnt contain the word days in the timespan
				if(isset($forum['last_post']['post_date']) && !strpos($timespan, 'Day')):
					$forum['last_post']['post_date'] = $timespan;
				else:
					$forum['last_post']['post_date'] = $forum['last_post']['post_date'];
				endif;
				
				$category['forum_list'][] = $forum;
			
			endforeach;
			
			$this->data['category_list'][] = $category;
		endforeach;
		
		$this->layout->create('index', $this->data);
	}


	function view_forum($forumID = 0)
	{
		$this->load->helper('date');
	
		$forumID = intval($forumID);
		$forum = $this->forum_model->getForum($forumID);
		// Check if topic exists
		if(!empty($forum)):
		
			$forum['topic_list'] = array();
			
			// Get a list of posts which have no parents (topics) in this forum
			foreach($this->post_model->getTopicsInForum($forumID) as $topic):
				
				$topic['post_count'] = count($this->post_model->getPostsInTopic($topic['postID']));
				$topic['last_post']	 = $this->post_model->getLastPost('topic', $topic['postID']);
				
				// Convert to unix and see how long ago it was posted
				$timespan = timespan(mysql_to_unix($topic['last_post']['post_date']));
				
				// If its set and doesnt contain the word days in the timespan
				if(isset($forum['last_post']['post_date']) && !strpos($timespan, 'Day')):
					$topic['last_post']['post_date'] = $timespan;
				else:
					$topic['last_post']['post_date'] = $topic['last_post']['post_date'];
				endif;
				
				$forum['topic_list'][] = $topic;
			
			endforeach;
			
			$this->data = array_merge($this->data, $forum);
			
			$this->layout->title('Forums > '.$this->data['forum_name']);
			$this->layout->create('view_forum', $this->data);
		
		else:
			
			show_error('The Forum doesn\'t exist!');
			$this->layout->create('message', $this->data);
			
		endif;
	}

}
?>