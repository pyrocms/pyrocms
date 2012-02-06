<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends Public_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('blog_m');
		$this->load->model('blog_categories_m');
		$this->load->model('comments/comments_m');
		$this->load->library(array('keywords/keywords'));
		$this->lang->load('blog');
	}

	// blog/page/x also routes here
	public function index()
	{
		$this->data->pagination = create_pagination('blog/page', $this->blog_m->count_by(array('status' => 'live')), NULL, 3);
		$this->data->blog = $this->blog_m->limit($this->data->pagination['limit'])->get_many_by(array('status' => 'live'));

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($this->data->blog);
		
		foreach ($this->data->blog AS &$post)
		{
			$post->keywords = Keywords::get_links($post->keywords, 'blog/tagged');
		}

		$this->template
			->title($this->module_details['name'])
			->set_breadcrumb( lang('blog_blog_title'))
			->set_metadata('description', $meta['description'])
			->set_metadata('keywords', $meta['keywords'])
			->build('index', $this->data);
	}

	public function category($slug = '')
	{
		$slug OR redirect('blog');

		// Get category data
		$category = $this->blog_categories_m->get_by('slug', $slug) OR show_404();

		// Count total blog posts and work out how many pages exist
		$pagination = create_pagination('blog/category/'.$slug, $this->blog_m->count_by(array(
			'category'=> $slug,
			'status' => 'live'
		)), NULL, 4);

		// Get the current page of blog posts
		$blog = $this->blog_m->limit($pagination['limit'])->get_many_by(array(
			'category'=> $slug,
			'status' => 'live'
		));

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($blog);
		
		foreach ($blog AS &$post)
		{
			$post->keywords = Keywords::get_links($post->keywords, 'blog/tagged');
		}

		// Build the page
		$this->template->title($this->module_details['name'], $category->title )
			->set_metadata('description', $category->title.'. '.$meta['description'] )
			->set_metadata('keywords', $category->title )
			->set_breadcrumb( lang('blog_blog_title'), 'blog')
			->set_breadcrumb( $category->title )
			->set('blog', $blog)
			->set('category', $category)
			->set('pagination', $pagination)
			->build('category', $this->data );
	}

	public function archive($year = NULL, $month = NULL)
	{
		// Redirect to current year. 
		$year OR $year = redirect('blog/archive/' .date('Y'));
		
		// If month is passed
		if( $month ) {
			$month_date = new DateTime($year.'-'.$month.'-01');
			$this->data->pagination = create_pagination('blog/archive/'.$year.'/'.$month, $this->blog_m->count_by(array('year'=>$year,'month'=>$month)), NULL, 5);
			$this->data->blog = $this->blog_m->limit($this->data->pagination['limit'])->get_many_by(array('year'=> $year,'month'=> $month));
			$this->data->month_year = format_date($month_date->format('U'), lang('blog_archive_date_format'));
			$month_date = format_date($month_date->format('U'), lang('blog_archive_date_format'));
		} else {
		// Else display by year
			$month_date = $year;
			$this->data->month_year = $year;
			$this->data->pagination = create_pagination('blog/archive/'.$year, $this->blog_m->count_by(array('year'=>$year)), NULL, 5);
			$this->data->blog = $this->blog_m->limit($this->data->pagination['limit'])->get_many_by(array('year'=> $year));
		}
		// Set meta description based on post titles
		$meta = $this->_posts_metadata($this->data->blog);
		
		foreach ($this->data->blog AS &$post)
		{
			$post->keywords = Keywords::get_links($post->keywords, 'blog/tagged');
		}

		$this->template->title( $this->data->month_year, $this->lang->line('blog_archive_title'), $this->lang->line('blog_blog_title'))
			->set_metadata('description', $this->data->month_year.'. '.$meta['description'])
			->set_metadata('keywords', $this->data->month_year.', '.$meta['keywords'])
			->set_breadcrumb($this->lang->line('blog_blog_title'), 'blog')
			->set_breadcrumb($this->lang->line('blog_archive_title').': '.$month_date)
			->build('archive', $this->data);
	}

	// Public: View a post
	public function view($slug = '')
	{
		if ( ! $slug or ! $post = $this->blog_m->get_by('slug', $slug))
		{
			redirect('blog');
		}

		if ($post->status != 'live' && ! $this->ion_auth->is_admin())
		{
			redirect('blog');
		}
		
		// if it uses markdown then display the parsed version
		if ($post->type == 'markdown')
		{
			$post->body = $post->parsed;
		}

		// IF this post uses a category, grab it
		if ($post->category_id && ($category = $this->blog_categories_m->get($post->category_id)))
		{
			$post->category = $category;
		}

		// Set some defaults
		else
		{
			$post->category->id		= 0;
			$post->category->slug	= '';
			$post->category->title	= '';
		}

		$this->session->set_flashdata(array('referrer' => $this->uri->uri_string));

		$this->template->title($post->title, lang('blog_blog_title'))
			->set_metadata('description', $post->intro)
			->set_metadata('keywords', implode(', ', Keywords::get_array($post->keywords)))
			->set_breadcrumb(lang('blog_blog_title'), 'blog');

		if ($post->category->id > 0)
		{
			$this->template->set_breadcrumb($post->category->title, 'blog/category/'.$post->category->slug);
		}
		
		$post->keywords = Keywords::get_links($post->keywords, 'blog/tagged');

		$this->template
			->set_breadcrumb($post->title)
			->set('post', $post)
			->build('view', $this->data);
	}
	
	public function tagged($tag = '')
	{
		$tag OR redirect('blog');

		// Count total blog posts and work out how many pages exist
		$pagination = create_pagination('blog/tagged/'.$tag, $this->blog_m->count_tagged_by($tag, array(
			'status' => 'live'
		)), NULL, 4);

		// Get the current page of blog posts
		$blog = $this->blog_m->limit($pagination['limit'])->get_tagged_by($tag, array(
			'status' => 'live'
		));
		
		foreach ($blog AS &$post)
		{
			$post->keywords = Keywords::get_links($post->keywords, 'blog/tagged');
		}

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($blog);
		
		$name = str_replace('-', ' ', $tag);

		// Build the page
		$this->template->title($this->module_details['name'], lang('blog_tagged_label').': '.$name )
			->set_metadata('description', lang('blog_tagged_label').': '.$name.'. '.$meta['description'] )
			->set_metadata('keywords', $name )
			->set_breadcrumb( lang('blog_blog_title'), 'blog')
			->set_breadcrumb( lang('blog_tagged_label').': '.$name )
			->set('blog', $blog)
			->set('tag', $tag)
			->set('pagination', $pagination)
			->build('tagged', $this->data );
	}
	
	public function search()
	{		
		// Get query data
		$query = $this->input->post('b_keywords');
		
		$query OR redirect('blog');
		
		// Construct search data
		$post_data = array(
			'status'	=>	'live',
			'keywords'	=>	$query
			);

		$this->data->blog = $this->blog_m->search($post_data);		
		
		// Set meta data
		$meta = $this->_posts_metadata($this->data->blog);
		
		foreach ($this->data->blog AS &$post)
		{
			$post->keywords = Keywords::get_links($post->keywords, 'blog/tagged');
		}
		
		// Build search page
		$this->template
			->title($this->module_details['name'], lang( 'blog_search_results_label' ) .': ' .$query)
			->set_breadcrumb( lang('blog_blog_title'), 'blog')
			->set_breadcrumb( lang( 'blog_search_results_label' ) .': ' .$query)
			->set_metadata('description', $meta['description'])
			->set_metadata('keywords', $meta['keywords'])
			->set('blog', $this->data->blog)
			->build('search', $this->data);
	}

	// Private methods not used for display
	private function _posts_metadata(&$posts = array())
	{
		$keywords = array();
		$description = array();

		// Loop through posts and use titles for meta description
		if(!empty($posts))
		{
			foreach($posts as &$post)
			{
				if($post->category_title)
				{
					$keywords[$post->category_id] = $post->category_title .', '. $post->category_slug;
				}
				$description[] = $post->title;
			}
		}

		return array(
			'keywords' => implode(', ', $keywords),
			'description' => implode(', ', $description)
		);
	}
}
