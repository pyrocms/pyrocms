<?php
class Forums extends Public_Controller {

	function __construct()
	{
		parent::Public_Controller();
			
		$this->load->model('forums_m');
		$this->load->model('forum_categories_m');
		$this->load->model('forum_posts_m');

		$this->lang->load('forums');
		$this->load->config('forums');

		$this->template->enable_parser_body(FALSE);

		$this->template->set_breadcrumb('Home', '/');
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
		$this->template->set_breadcrumb('Forums');
		$this->template->build('forum/index', $this->data);
	}


	function view($forum_id = 0, $offset = 0)
	{
		// Check if forum exists, if not 404
		($forum = $this->forums_m->get($forum_id)) || show_404();

		// Pagination junk
		$this->load->library('pagination');
		$per_page = '25';
		if($offset < $per_page) $offset = 0;
		$config['base_url'] = site_url('forums/view/'.$forum_id);
		$config['total_rows'] = $this->forum_posts_m->count_topics_in_forum($forum_id);
		$config['per_page'] = $per_page;
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		// End Pagination

		// Get all topics for this forum
		$forum->topics = $this->forum_posts_m->get_topics_by_forum($forum_id, $offset, $per_page);
		
		// Get a list of posts which have no parents (topics) in this forum
		foreach($forum->topics as &$topic)
		{
			$topic->post_count = $this->forum_posts_m->count_posts_in_topic($topic->id);
			$topic->last_post = $this->forum_posts_m->last_topic_post($topic->id);

			if(!empty($topic->last_post))
			{
				$topic->last_post->author = $this->forum_posts_m->author_info($topic->last_post->author_id);
			}
		}
		
		$this->data->forum =& $forum;
		$this->data->pagination->offset = $offset;
		$this->data->pagination->links = $this->pagination->create_links();

		$this->template->set_breadcrumb('Forums', 'forums');
		$this->template->set_breadcrumb($forum->title);
		$this->template->build('forum/view', $this->data);
	}

	function unsubscribe($user_id, $topic_id)
	{
		$this->load->model('forum_subscriptions_m');
		$topic = $this->forum_posts_m->get($topic_id);
		$this->forum_subscriptions_m->delete_by(array('user_id' => $user_id, 'topic_id' => $topic_id));
		$this->data->topic =& $topic;
		$this->template->build('posts/unsubscribe', $this->data);
	}

}
?>