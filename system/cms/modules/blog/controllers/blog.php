<?php 

use Pyro\Module\Streams_core\EntryModel;
use Pyro\Module\Blog\BlogsBlogModel;

/**
 * Public Blog module controller
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Blog\Controllers
 */
class Blog extends Public_Controller
{
	public $stream;

	/**
	 * Every time this controller is called should:
	 * - load the blog and blog_categories models.
	 * - load the keywords library.
	 * - load the blog language file.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('blog_m');
		$this->load->model('blog_categories_m');
		$this->load->library(array('keywords/keywords'));
		$this->lang->load('blog');

		$this->load->driver('Streams');

		// We are going to get all the categories so we can
		// easily access them later when processing posts.
		$cates = $this->db->get('blog_categories')->result_array();
		$this->categories = array();
	
		foreach ($cates as $cate)
		{
			$this->categories[$cate['id']] = $cate;
		}
	}

	/**
	 * Index
	 *
	 * List out the blog posts.
	 *
	 * URIs such as `blog/page/x` also route here.
	 */
	public function index()
	{
		// Total posts
		$total = BlogsBlogModel::where('status', '=', 'live')->count();

		// Skip
		if (ci()->input->get('page')) {
			$skip = (ci()->input->get('page')-1)*Settings::get('records_per_page');
		} else {
			$skip = 0;
		}

		// Get the latest blog posts
		$posts = BlogsBlogModel::select('*')
            ->where('status', '=', 'live')
			->orderBy('created_at', 'DESC')
			->take(Settings::get('records_per_page'))
			->skip($skip)
			->get()
            ->asPlugin()
            ->toArray();

		// Create pagination
		$pagination = create_pagination(
			'blog',
			$total,
			Settings::get('records_per_page')
		);

		$pagination['links'] = str_replace('-1', '1', $pagination['links']);

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($posts);

		// Process
		$posts = self::processPosts($posts);

		// Go!
		$this->template
			->title($this->module_details['name'])
			->set_breadcrumb(lang('blog:blog_title'))
			->set_metadata('og:title', $this->module_details['name'], 'og')
			->set_metadata('og:type', 'blog', 'og')
			->set_metadata('og:url', current_url(), 'og')
			->set_metadata('og:description', $meta['description'], 'og')
			->set_metadata('description', $meta['description'])
			->set_metadata('keywords', $meta['keywords'])
			->set('posts', $posts)
			->set('pagination', $pagination['links'])
			->build('posts');
	}

	/**
	 * Lists the posts in a specific category.
	 *
	 * @param string $slug The slug of the category.
	 */
	public function category($slug = '')
	{
		$slug or redirect('blog');

		// Get category data
		$category = $this->blog_categories_m->get_by('slug', $slug) OR show_404();

		// Total posts
		$total = BlogsBlogModel::where('status', '=', 'live')
			->where('category_id', '=', $category->id)
			->count();

		// Skip
		if (ci()->input->get('page')) {
			$skip = (ci()->input->get('page')-1)*Settings::get('records_per_page');
		} else {
			$skip = 0;
		}

		// Get the latest blog posts
		$posts = BlogsBlogModel::select('*')
            ->where('status', '=', 'live')
			->where('category_id', '=', $category->id)
			->orderBy('created_at', 'DESC')
			->take(Settings::get('records_per_page'))
			->skip($skip)
			->get()
			->asPlugin()
			->toArray();

		// Create pagination
		$pagination = create_pagination(
			'blog',
			$total,
			Settings::get('records_per_page')
		);

		$pagination['links'] = str_replace('-1', '1', $pagination['links']);

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($posts);

		// Process
		$posts = self::processPosts($posts);

		// Build the page
		$this->template->title($this->module_details['name'], $category->title)
			->set_metadata('description', $category->title.'. '.$meta['description'])
			->set_metadata('keywords', $category->title)
			->set_breadcrumb(lang('blog:blog_title'), 'blog')
			->set_breadcrumb($category->title)
			->set('pagination', $pagination['links'])
			->set('posts', $posts)
			->set('category', (array) $category)
			->build('posts');
	}

	/**
	 * Lists the posts in a specific year/month.
	 *
	 * @param null|string $year  The year to show the posts for.
	 * @param string      $month The month to show the posts for.
	 */
	public function archive($year = null, $month = '01')
	{
		$year or $year = date('Y');
		$month_date = new DateTime($year.'-'.$month.'-01');

		// Total posts
		$total = BlogsBlogModel::where('status', '=', 'live')
			->whereYear('created_at', '=', $year)
			->whereMonth('created_at', '=', $month)
			->count();

		// Skip
		if (ci()->input->get('page')) {
			$skip = (ci()->input->get('page')-1)*Settings::get('records_per_page');
		} else {
			$skip = 0;
		}

		// Get the latest blog posts
		$posts = BlogsBlogModel::select('*')
            ->where('status', '=', 'live')
			->whereYear('created_at', '=', $year)
			->whereMonth('created_at', '=', $month)
			->orderBy('created_at', 'DESC')
			->take(Settings::get('records_per_page'))
			->skip($skip)
			->get()
			->asPlugin()
			->toArray();

		// Create pagination
		$pagination = create_pagination(
			'blog',
			$total,
			Settings::get('records_per_page')
		);

		$pagination['links'] = str_replace('-1', '1', $pagination['links']);

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($posts);

		// Process
		$posts = self::processPosts($posts);

		$this->template
			->title($month_year, lang('blog:archive_title'), lang('blog:blog_title'))
			->set_metadata('description', $month_year.'. '.$meta['description'])
			->set_metadata('keywords', $month_year.', '.$meta['keywords'])
			->set_breadcrumb(lang('blog:blog_title'), 'blog')
			->set_breadcrumb(lang('blog:archive_title').': '.format_date($month_date->format('U'), lang('blog:archive_date_format')))
			->set('pagination', $pagination['links'])
			->set('posts', $posts)
			->set('month_year', $month_year)
			->build('archive');
	}

	/**
	 * View a post
	 *
	 * @param string $slug The slug of the blog post.
	 */
	public function view($slug = '')
	{
		// We need a slug to make this work.
		if ( ! $slug)
		{
			redirect('blog');
		}

		// Get the latest blog posts
		$post = BlogsBlogModel::select('*')->where('slug', '=', $slug)
			->first()
			->asPlugin()
			->toArray();

        if (! is_object(ci()->current_user) or ! ci()->current_user->isSuperUser()) {
            if (! $post or $post['status']['key'] !== 'live') {
                redirect('blog');
            }
        }

		$this->_single_view($post);
	}

	/**
	 * Preview a post
	 *
	 * @param string $hash the preview_hash of post
	 */
	public function preview($hash = '')
	{
		if ( ! $hash)
		{
			redirect('blog');
		}

		$params = array(
			'stream'		=> 'blog',
			'namespace'		=> 'blogs',
			'limit'			=> 1,
			'order_by'		=> "created_at",
			'where'			=> "`preview_hash` = '{$hash}'"
		);
		$data = $this->streams->entries->get_entries($params);
		$post = (isset($data['entries'][0])) ? $data['entries'][0] : null;

		if ( ! $post)
		{
			redirect('blog');
		}

		if ($post['status'] === 'live')
		{
			redirect('blog/'.date('Y/m', strtotime($post['created_at'])).'/'.$post['slug']);
		}

		// Set index nofollow to attempt to avoid search engine indexing
		$this->template->set_metadata('index', 'nofollow');

		$this->_single_view($post);
	}

	/**
	 * Tagged Posts
	 *
	 * Displays blog posts tagged with a
	 * tag (pulled from the URI)
	 *
	 * @param string $tag
	 */
	public function tagged($tag = '')
	{
		// decode encoded cyrillic characters
		$tag = rawurldecode($tag) or redirect('blog');

		// Total posts
		$total = BlogsBlogModel::where('status', '=', 'live')
			->where('keywords', 'LIKE', '%'.$tag.'%')
			->count();

		// Skip
		if (ci()->input->get('page')) {
			$skip = (ci()->input->get('page')-1)*Settings::get('records_per_page');
		} else {
			$skip = 0;
		}

		// Get the latest blog posts
		$posts = BlogsBlogModel::select('*')
            ->where('status', '=', 'live')
			->where('keywords', 'LIKE', '%'.$tag.'%')
			->orderBy('created_at', 'DESC')
			->take(Settings::get('records_per_page'))
			->skip($skip)
			->get()
			->asPlugin()
			->toArray();

		// Create pagination
		$pagination = create_pagination(
			'blog',
			$total,
			Settings::get('records_per_page')
		);

		$pagination['links'] = str_replace('-1', '1', $pagination['links']);

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($posts);

		// Process
		$posts = self::processPosts($posts);

		$name = str_replace('-', ' ', $tag);

		// Build the page
		$this->template
			->title($this->module_details['name'], lang('blog:tagged_label').': '.$name)
			->set_metadata('description', lang('blog:tagged_label').': '.$name.'. '.$meta['description'])
			->set_metadata('keywords', $name)
			->set_breadcrumb(lang('blog:blog_title'), 'blog')
			->set_breadcrumb(lang('blog:tagged_label').': '.$name)
			->set('pagination', $pagination['links'])
			->set('posts', $posts)
			->set('tag', $tag)
			->build('posts');
	}

	/**
	 * Posts Metadata
	 *
	 * @param array $posts
	 *
	 * @return array keywords and description
	 */
	private function _posts_metadata(&$posts = array())
	{
		$keywords = array();
		$description = array();

		// Loop through posts and use titles for meta description
		if ( ! empty($posts))
		{
			foreach ($posts as &$post)
			{
				if (isset($post['category_id']['title']) and ! in_array($post['category_id']['title'], $keywords))
				{
					$keywords[] = $post['category_id']['title'];
				}

				$description[] = $post['title'];
			}
		}

		return array(
			'keywords' => implode(', ', $keywords),
			'description' => implode(', ', $description)
		);
	}

	/**
	 * Single View
	 *
	 * Generate a page for viewing a single
	 * blog post.
	 *
	 * @access 	private
	 * @param 	array $post The post to view
	 * @return 	void
	 */
	private function _single_view($post)
	{
		$this->session->set_flashdata(array('referrer' => $this->uri->uri_string()));

		$this->template->set_breadcrumb(lang('blog:blog_title'), 'blog');

		if ($post['category_id'] > 0)
		{
			// Get the category. We'll just do it ourselves
			// since we need an array.
			if ($category = $this->db->limit(1)->where('id', $post['category_id'])->get('blog_categories')->row_array())
			{
				$this->template->set_breadcrumb($category['title'], 'blog/category/'.$category['slug']);

				// Set category OG metadata			
				$this->template->set_metadata('article:section', $category['title'], 'og');

				// Add to $post
				$post['category'] = $category;
			}
		}

		$post = self::processPosts(array($post));
		$post = $post[0];

		// Add in OG keywords
        foreach (explode(',', $post['keywords']) as $keyword)
		{
			$this->template->set_metadata('article:tag', $keyword, 'og');
		}

		// If comments are enabled, go fetch them all
		if (Settings::get('enable_comments'))
		{
			// Load Comments so we can work out what to do with them
			$this->load->library('comments/comments', array(
				'entry_id' => $post['id'],
				'entry_title' => $post['title'],
				'module' => 'blog',
				'singular' => 'blog:post',
				'plural' => 'blog:posts',
			));

			// Comments enabled can be 'no', 'always', or a strtotime compatable difference string, so "2 weeks"
			$this->template->set('form_display', (
				$post['comments_enabled']['key'] === 'always' or
					($post['comments_enabled']['key'] !== 'no' and time() < strtotime('+'.$post['comments_enabled']['key'], strtotime($post['created_at'])))
			));
		}

		$this->template
			->title($post['title'], lang('blog:blog_title'))
			->set_metadata('og:type', 'article', 'og')
			->set_metadata('og:url', current_url(), 'og')
			->set_metadata('og:title', $post['title'], 'og')
			->set_metadata('og:site_name', Settings::get('site_name'), 'og')
			->set_metadata('og:description', $post['intro'], 'og')
			->set_metadata('article:published_time', date(DATE_ISO8601, strtotime($post['created_at'])), 'og')
			->set_metadata('article:modified_time', date(DATE_ISO8601, strtotime($post['updated_at'])), 'og')
			->set_metadata('description', strip_tags($post['intro']))
			->set_metadata('keywords', $post['keywords'])
			->set_breadcrumb($post['title'])
			->set('post', array($post))
			->build('view');
	}

	/**
	 * Process posts
	 * @param  array $posts by reference
	 * @return void        
	 */
	protected static function processPosts($posts)
	{
		foreach ($posts as &$post) {
			$post['url'] = site_url('blog/'.date('Y/m', strtotime($post['created_at'])).'/'.$post['slug']);
		}

		return $posts;
	}
}
