<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Public Blog module controller
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Blog\Controllers
 */
class Blog extends Public_Controller
{
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
		// Get our comment count whil we're at it.
		$this->row_m->sql['select'][] = "(SELECT COUNT(id) FROM ".
				$this->db->protect_identifiers('comments', true)." WHERE module='blog'
				AND is_active='1' AND entry_key='blog:post' AND entry_plural='blog:posts'
				AND entry_id=".$this->db->protect_identifiers('blog.id', true).") as `comment_count`";

		// Get the latest blog posts
		$params = array(
			'stream'		=> 'blog',
			'namespace'		=> 'blogs',
			'limit'			=> Settings::get('records_per_page'),
			'where'			=> "`status` = 'live'",
			'paginate'		=> 'yes',
			'pag_base'		=> site_url('blog/page'),
			'pag_segment'   => 3
		);
		$posts = $this->streams->entries->get_entries($params);

		// Process posts
		foreach ($posts['entries'] as &$post)
		{
			$this->_process_post($post);
		}

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($posts['entries']);

		$this->template
			->title($this->module_details['name'])
			->set_breadcrumb(lang('blog:blog_title'))
			->set_metadata('og:title', $this->module_details['name'], 'og')
			->set_metadata('og:type', 'blog', 'og')
			->set_metadata('og:url', current_url(), 'og')
			->set_metadata('og:description', $meta['description'], 'og')
			->set_metadata('description', $meta['description'])
			->set_metadata('keywords', $meta['keywords'])
			->set('pagination', $posts['pagination'])
			->set('posts', $posts['entries'])
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

		// Get the blog posts
		$params = array(
			'stream'		=> 'blog',
			'namespace'		=> 'blogs',
			'limit'			=> Settings::get('records_per_page'),
			'where'			=> "`status` = 'live' AND `category_id` = '{$category->id}'",
			'paginate'		=> 'yes',
			'pag_segment'	=> 4
		);
		$posts = $this->streams->entries->get_entries($params);

		// Process posts
		foreach ($posts['entries'] as &$post)
		{
			$this->_process_post($post);
		}

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($posts['entries']);

		// Build the page
		$this->template->title($this->module_details['name'], $category->title)
			->set_metadata('description', $category->title.'. '.$meta['description'])
			->set_metadata('keywords', $category->title)
			->set_breadcrumb(lang('blog:blog_title'), 'blog')
			->set_breadcrumb($category->title)
			->set('pagination', $posts['pagination'])
			->set('posts', $posts['entries'])
			->set('category', (array)$category)
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

		// Get the blog posts
		$params = array(
			'stream'		=> 'blog',
			'namespace'		=> 'blogs',
			'limit'			=> Settings::get('records_per_page'),
			'where'			=> "`status` = 'live'",
			'year'			=> $year,
			'month'			=> $month,
			'paginate'		=> 'yes',
			'pag_segment'	=> 5
		);
		$posts = $this->streams->entries->get_entries($params);

		$month_year = format_date($month_date->format('U'), lang('blog:archive_date_format'));

		foreach ($posts['entries'] as &$post)
		{
			$this->_process_post($post);
		}

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($posts['entries']);

		$this->template
			->title($month_year, lang('blog:archive_title'), lang('blog:blog_title'))
			->set_metadata('description', $month_year.'. '.$meta['description'])
			->set_metadata('keywords', $month_year.', '.$meta['keywords'])
			->set_breadcrumb(lang('blog:blog_title'), 'blog')
			->set_breadcrumb(lang('blog:archive_title').': '.format_date($month_date->format('U'), lang('blog:archive_date_format')))
			->set('pagination', $posts['pagination'])
			->set('posts', $posts['entries'])
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

		$params = array(
			'stream'		=> 'blog',
			'namespace'		=> 'blogs',
			'limit'			=> 1,
			'where'			=> "`slug` = '{$slug}'"
		);
		$data = $this->streams->entries->get_entries($params);
		$post = (isset($data['entries'][0])) ? $data['entries'][0] : null;

		if ( ! $post or ($post['status'] !== 'live' and ! $this->ion_auth->is_admin()))
		{
			redirect('blog');
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
			redirect('blog/'.date('Y/m', $post['created_on']).'/'.$post['slug']);
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

		// Here we need to add some custom joins into the
		// row query. This shouldn't be in the controller, but
		// we need to figure out where this sort of stuff should go.
		// Maybe the entire blog moduel should be replaced with stream
		// calls with items like this. Otherwise, this currently works.
		$this->row_m->sql['join'][] = 'JOIN '.$this->db->protect_identifiers('keywords_applied', true).' ON '.
			$this->db->protect_identifiers('keywords_applied.hash', true).' = '.
			$this->db->protect_identifiers('blog.keywords', true);

		$this->row_m->sql['join'][] = 'JOIN '.$this->db->protect_identifiers('keywords', true).' ON '.
			$this->db->protect_identifiers('keywords.id', true).' = '.
			$this->db->protect_identifiers('keywords_applied.keyword_id', true);	

		$this->row_m->sql['where'][] = $this->db->protect_identifiers('keywords.name', true)." = '".str_replace('-', ' ', $tag)."'";

		// Get the blog posts
		$params = array(
			'stream'		=> 'blog',
			'namespace'		=> 'blogs',
			'limit'			=> Settings::get('records_per_page'),
			'where'			=> "`status` = 'live'",
			'paginate'		=> 'yes',
			'pag_segment'	=> 4
		);
		$posts = $this->streams->entries->get_entries($params);

		// Process posts
		foreach ($posts['entries'] as &$post)
		{
			$this->_process_post($post);
		}

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($posts['entries']);

		$name = str_replace('-', ' ', $tag);

		// Build the page
		$this->template
			->title($this->module_details['name'], lang('blog:tagged_label').': '.$name)
			->set_metadata('description', lang('blog:tagged_label').': '.$name.'. '.$meta['description'])
			->set_metadata('keywords', $name)
			->set_breadcrumb(lang('blog:blog_title'), 'blog')
			->set_breadcrumb(lang('blog:tagged_label').': '.$name)
			->set('pagination', $posts['pagination'])
			->set('posts', $posts['entries'])
			->set('tag', $tag)
			->build('posts');
	}

	/**
	 * Process Post
	 *
	 * Process data that was not part of the 
	 * initial streams call.
	 *
	 * @return 	void
	 */
	private function _process_post(&$post)
	{
		$this->load->helper('text');

		// Keywords array
		$keywords = Keywords::get($post['keywords']);
		$formatted_keywords = array();
		$keywords_arr = array();

		foreach ($keywords as $key)
		{
			$formatted_keywords[] 	= array('keyword' => $key->name);
			$keywords_arr[] 		= $key->name;

		}
		$post['keywords'] = $formatted_keywords;
		$post['keywords_arr'] = $keywords_arr;

		// Full URL for convenience.
		$post['url'] = site_url('blog/'.date('Y/m', $post['created_on']).'/'.$post['slug']);
	
		// What is the preview? If there is a field called intro,
		// we will use that, otherwise we will cut down the blog post itself.
		$post['preview'] = (isset($post['intro'])) ? $post['intro'] : $post['body'];

		// Category
		if ($post['category_id'] > 0 and isset($this->categories[$post['category_id']]))
		{
			$post['category'] = $this->categories[$post['category_id']];
		}
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
				if (isset($post['category']) and ! in_array($post['category']['title'], $keywords))
				{
					$keywords[] = $post['category']['title'];
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
		// if it uses markdown then display the parsed version
		if ($post['type'] === 'markdown')
		{
			$post['body'] = $post['parsed'];
		}

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

		$this->_process_post($post);

		// Add in OG keywords
		foreach ($post['keywords_arr'] as $keyword)
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
				$post['comments_enabled'] === 'always' or
					($post['comments_enabled'] !== 'no' and time() < strtotime('+'.$post['comments_enabled'], $post['created_on']))
			));
		}

		$this->template
			->title($post['title'], lang('blog:blog_title'))
			->set_metadata('og:type', 'article', 'og')
			->set_metadata('og:url', current_url(), 'og')
			->set_metadata('og:title', $post['title'], 'og')
			->set_metadata('og:site_name', Settings::get('site_name'), 'og')
			->set_metadata('og:description', $post['preview'], 'og')
			->set_metadata('article:published_time', date(DATE_ISO8601, $post['created_on']), 'og')
			->set_metadata('article:modified_time', date(DATE_ISO8601, $post['updated_on']), 'og')
			->set_metadata('description', $post['preview'])
			->set_metadata('keywords', implode(', ', $post['keywords_arr']))
			->set_breadcrumb($post['title'])
			->set('post', array($post))
			->build('view');
	}
}
