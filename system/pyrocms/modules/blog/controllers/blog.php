<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends Public_Controller
{
	function __construct()
	{
		parent::Public_Controller();		
		$this->load->model('blog_m');
		$this->load->model('blog_categories_m');
		$this->load->model('comments/comments_m');        
		$this->load->helper('text');
		$this->lang->load('blog');
	}
	
	// blog/page/x also routes here
	function index()
	{	
		$this->data->pagination = create_pagination('blog/page', $this->blog_m->count_by(array('status' => 'live')), NULL, 3);
		$this->data->blog = $this->blog_m->limit($this->data->pagination['limit'])->get_many_by(array('status' => 'live'));	

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($this->data->blog);

		$this->template
			->title($this->module_details['name'])
			->set_metadata('description', $meta['description'])
			->set_metadata('keywords', $meta['keywords'])
			->build('index', $this->data);
	}
	
	function category($slug = '')
	{	
		$slug OR redirect('blog');
		
		// Get category data
		$category = $this->blog_categories_m->get_by('slug', $slug) OR show_404();
		
		$this->data->category =& $category;
		
		// Count total blog posts and work out how many pages exist
		$this->data->pagination = create_pagination('blog/category/'.$slug, $this->blog_m->count_by(array(
			'category'=>$slug,
			'status' => 'live'
		)), NULL, 4);
		
		// Get the current page of blog posts
		$this->data->blog = $this->blog_m->limit($this->data->pagination['limit'])->get_many_by(array(
			'category'=>$slug,
			'status' => 'live'
		));
		
		// Set meta description based on post titles
		$meta = $this->_posts_metadata($this->data->blog);
		
		// Build the page
		$this->template->title($this->module_details['name'], $category->title )		
			->set_metadata('description', $category->title.'. '.$meta['description'] )
			->set_metadata('keywords', $category->title )
			->set_breadcrumb( lang('blog_blog_title'), 'blog')
			->set_breadcrumb( $category->title )		
			->build( 'category', $this->data );
	}	
	
	function archive($year = NULL, $month = '01')
	{	
		$year OR $year = date('Y');
		$month_date = new DateTime($year.'-'.$month.'-01');
		$this->data->pagination = create_pagination('blog/archive/'.$year.'/'.$month, $this->blog_m->count_by(array('year'=>$year,'month'=>$month)), NULL, 5);
		$this->data->blog = $this->blog_m->limit($this->data->pagination['limit'])->get_many_by(array('year'=> $year,'month'=> $month));
		$this->data->month_year = $month_date->format("F 'y");
		
		// Set meta description based on post titles
		$meta = $this->_posts_metadata($this->data->blog);

		$this->template->title( $this->data->month_year, $this->lang->line('blog_archive_title'), $this->lang->line('blog_blog_title'))		
			->set_metadata('description', $this->data->month_year.'. '.$meta['description'])
			->set_metadata('keywords', $this->data->month_year.', '.$meta['keywords'])
			->set_breadcrumb($this->lang->line('blog_blog_title'), 'blog')
			->set_breadcrumb($this->lang->line('blog_archive_title').': '.$month_date->format("F 'y"))
			->build('archive', $this->data);
	}
	
	// Public: View an post
	function view($slug = '')
	{	
		if (!$slug or !$post = $this->blog_m->get_by('slug', $slug))
		{
			redirect('blog');
		}
		
		if($post->status != 'live' && !$this->ion_auth->is_admin())
		{
			redirect('blog');
		}
		
		// IF this post uses a category, grab it
		if($post->category_id > 0)
		{
			$post->category = $this->blog_categories_m->get( $post->category_id );
		}
		
		// Set some defaults
		else
		{
			$post->category->id = 0;
			$post->category->slug = '';
			$post->category->title = '';
		}
		
		$this->session->set_flashdata(array('referrer'=>$this->uri->uri_string));	
		
		$this->data->post =& $post;

		$this->template->title($post->title, $this->lang->line('blog_blog_title'))
			->set_metadata('description', $this->data->post->intro)
			->set_metadata('keywords', $this->data->post->category->title.' '.$this->data->post->title)	
			->set_breadcrumb($this->lang->line('blog_blog_title'), 'blog');
		
		if($post->category_id > 0)
		{
			$this->template->set_breadcrumb($post->category->title, 'blog/category/'.$post->category->slug);
		}
		
		$this->template->set_breadcrumb($post->title, 'blog/'.date('Y/m', $post->created_on).'/'.$post->slug);
		$this->template->build('view', $this->data);
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