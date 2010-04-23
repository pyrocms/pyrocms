<?php
class Forums extends Public_Controller {

	function __construct()
	{
		parent::Public_Controller();
			
		$this->load->model('forums_m');
		$this->load->model('forum_categories_m');
		$this->load->model('forum_posts_m');

		$this->lang->load('forum');
		
		// Add a link to the forum CSS into the head
		$this->template->append_metadata( css('forum.css', 'forums') );
		
		// TODO: Review the use of enable_parse_body(FALSE) in forums
		$this->template->enable_parser_body(FALSE);
		
		if($profile = $this->ion_auth->profile())
		{
			$this->userID = $profile->id;
		}
	}
	
	
	function index()
	{
		if( $forum_categories = $this->forum_categories_m->get_all() )
		{
			// Get list of categories
			foreach($forum_categories as &$category)
			{
				$category->forums = $this->forums_m->get_many_by('category_id', $category->id);
				
				// Get a list of forums in each category
				foreach($category->forums as &$forum)
				{
					$forum->topic_count = $this->forum_posts_m->count_topics_in_forum( $forum->id );
					$forum->reply_count = $this->forum_posts_m->count_replies_in_forum( $forum->id );
					$forum->last_post = $this->forum_posts_m->last_forum_post($forum->id);
					if(!empty($forum->last_post))
					{
						$forum->last_post->author = $this->forum_posts_m->author_info($forum->last_post->author_id);
					}
				}
			}
		}
	
		$this->data->forum_categories =& $forum_categories;

		$this->template->build('forum/index', $this->data);
	}


	function view($forum_id = 0)
	{
		// Check if forum exists, if not 404
		($forum = $this->forums_m->get($forum_id)) || show_404();
		
		// Get all topics for this forum
		$forum->topics = $this->forum_posts_m->get_topics_by_forum($forum_id);
		
		// Get a list of posts which have no parents (topics) in this forum
		foreach($forum->topics as &$topic)
		{
			$topic->post_count = $this->forum_posts_m->count_posts_in_topic($topic->id);
			$topic->last_post = $this->forum_posts_m->getLastPostInTopic($topic->id);

			if(!empty($topic->last_post))
			{
				$topic->last_post->author = $this->forum_posts_m->author_info($topic->last_post->author_id);
			}
		}
		
		$this->data->forum =& $forum;
		
		$this->template->build('forum/view', $this->data);
	}

}
?>