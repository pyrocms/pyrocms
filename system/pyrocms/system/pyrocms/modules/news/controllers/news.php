<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class News extends Public_Controller
{
	public $limit = 10; // TODO: PS - Make me a settings option
	
	function __construct()
	{
		parent::Public_Controller();		
		$this->load->model('news_m');
		$this->load->model('news_categories_m');
		$this->load->model('comments/comments_m');        
		$this->load->helper('text');
		$this->lang->load('news');
	}
	
	// news/page/x also routes here
	function index()
	{	
		$this->data->pagination = create_pagination('news/page', $this->news_m->count_by(array('status' => 'live')), $this->limit, 3);	
		$this->data->news = $this->news_m->limit($this->data->pagination['limit'])->get_many_by(array('status' => 'live'));	

		// Set meta description based on article titles
		$meta = $this->_articles_metadata($this->data->news);

		$this->template->title($this->module_details['name'])
						->set_metadata('description', $meta['description'])
						->set_metadata('keywords', $meta['keywords'])
						->build('index', $this->data);
	}
	
	function category($slug = '')
	{	
		if(!$slug) redirect('news');
		
		// Get category data
		$category = $this->news_categories_m->get_by('slug', $slug);
		
		if(!$category) show_404();
		
		$this->data->category =& $category;
		
		// Count total news articles and work out how many pages exist
		$this->data->pagination = create_pagination('news/category/'.$slug, $this->news_m->count_by(array(
			'category'=>$slug,
			'status' => 'live'
		)), $this->limit, 4);
		
		// Get the current page of news articles
		$this->data->news = $this->news_m->limit($this->data->pagination['limit'])->get_many_by(array(
			'category'=>$slug,
			'status' => 'live'
		));
		
		// Set meta description based on article titles
		$meta = $this->_articles_metadata($this->data->news);
		
		// Build the page
		$this->template->title($this->module_details['name'], $category->title )		
			->set_metadata('description', $category->title.'. '.$meta['description'] )
			->set_metadata('keywords', $category->title )
			->set_breadcrumb( lang('news_news_title'), 'news')
			->set_breadcrumb( $category->title )		
			->build( 'category', $this->data );
	}	
	
	function archive($year = NULL, $month = '01')
	{	
		if(!$year) $year = date('Y');		
		$month_date = new DateTime($year.'-'.$month.'-01');
		$this->data->pagination = create_pagination('news/archive/'.$year.'/'.$month, $this->news_m->count_by(array('year'=>$year,'month'=>$month)), $this->limit, 5);
		$this->data->news = $this->news_m->limit($this->data->pagination['limit'])->get_many_by(array('year'=> $year,'month'=> $month));
		$this->data->month_year = $month_date->format("F 'y");
		
		// Set meta description based on article titles
		$meta = $this->_articles_metadata($this->data->news);

		$this->template->title( $this->data->month_year, $this->lang->line('news_archive_title'), $this->lang->line('news_news_title'))		
			->set_metadata('description', $this->data->month_year.'. '.$meta['description'])
			->set_metadata('keywords', $this->data->month_year.', '.$meta['keywords'])
			->set_breadcrumb($this->lang->line('news_news_title'), 'news')
			->set_breadcrumb($this->lang->line('news_archive_title').': '.$month_date->format("F 'y"))
			->build('archive', $this->data);
	}
	
	// Public: View an article
	function view($slug = '')
	{	
		if (!$slug or !$article = $this->news_m->get_by('slug', $slug))
		{
			redirect('news');
		}
		
		if($article->status != 'live' && !$this->ion_auth->is_admin())
		{
			redirect('news');
		}
		
		// IF this article uses a category, grab it
		if($article->category_id > 0)
		{
			$article->category = $this->news_categories_m->get( $article->category_id );
		}
		
		// Set some defaults
		else
		{
			$article->category->id = 0;
			$article->category->slug = '';
			$article->category->title = '';
		}
		
		$this->session->set_flashdata(array('referrer'=>$this->uri->uri_string));	
		
		$this->data->article =& $article;

		$this->template->title($article->title, $this->lang->line('news_news_title'))
			->set_metadata('description', $this->data->article->intro)
			->set_metadata('keywords', $this->data->article->category->title.' '.$this->data->article->title)	
			->set_breadcrumb($this->lang->line('news_news_title'), 'news');
		
		if($article->category_id > 0)
		{
			$this->template->set_breadcrumb($article->category->title, 'news/category/'.$article->category->slug);
		}
		
		$this->template->set_breadcrumb($article->title, 'news/'.date('Y/m', $article->created_on).'/'.$article->slug);
		$this->template->build('view', $this->data);
	}	
	
	// Private methods not used for display
	private function _articles_metadata(&$articles = array())
	{
		$keywords = array();
		$description = array();
		
		// Loop through articles and use titles for meta description
		if(!empty($articles))
		{
			foreach($articles as &$article)
			{
				if($article->category_title)
				{
					$keywords[$article->category_id] = $article->category_title .', '. $article->category_slug;
				}
				$description[] = $article->title; 
			}
		}
		
		return array(
			'keywords' => implode(', ', $keywords),
			'description' => implode(', ', $description)
		);
	}
}