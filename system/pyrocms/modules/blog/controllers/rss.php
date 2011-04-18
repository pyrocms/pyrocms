<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rss extends Public_Controller
{
	function __construct()
	{
		parent::Public_Controller();	
		$this->load->model('blog_m');
		$this->load->helper('xml');
		$this->load->helper('date');
		$this->lang->load('blog');
	}
	
	function index()
	{
		$posts = $this->pyrocache->model('blog_m', 'get_many_by', array(array(
			'status' => 'live',
			'limit' => $this->settings->item('rss_feed_items'))
		), $this->settings->item('rss_cache'));
		
		$this->_build_feed( $posts );		
		$this->data->rss->feed_name .= $this->lang->line('blog_rss_name_suffix');		
		$this->output->set_header('Content-Type: application/rss+xml');
		$this->load->view('rss', $this->data);
	}
	
	function category( $slug = '')
	{ 
		$this->load->model('categories/categories_m');
		
		if(!$category = $this->categories_m->get_by('slug', $slug))
		{
			redirect('blog/rss/index');
		}
		
		$posts = $this->pyrocache->model('blog_m', 'get_many_by', array(array(
			'status' => 'live',
			'category' => $slug,
			'limit' => $this->settings->item('rss_feed_items') )
		), $this->settings->item('rss_cache'));
		
		$this->_build_feed( $posts );		
		$this->data->rss->feed_name .= ' '. $category->title . $this->lang->line('blog_rss_category_suffix');		
		$this->output->set_header('Content-Type: application/rss+xml');
		$this->load->view('rss', $this->data);
	}
	
	function _build_feed( $posts = array() )
	{
		$this->data->rss->encoding = $this->config->item('charset');
		$this->data->rss->feed_name = $this->settings->item('site_name');
		$this->data->rss->feed_url = base_url();
		$this->data->rss->page_description = sprintf($this->lang->line('blog_rss_posts_title'), $this->settings->item('site_name'));
		$this->data->rss->page_language = 'en-gb';
		$this->data->rss->creator_email = $this->settings->item('contact_email');
		
		if(!empty($posts))
		{        
			foreach($posts as $row)
			{
				//$row->created_on = human_to_unix($row->created_on);
				$row->link = site_url('blog/' .date('Y/m', $row->created_on) .'/'. $row->slug);
				$row->created_on = standard_date('DATE_RSS', $row->created_on);
				
				$item = array(
					//'author' => $row->author,
					'title' => xml_convert($row->title),
					'link' => $row->link,
					'guid' => $row->link,
					'description'  => $row->intro,
					'date' => $row->created_on
				);				
				$this->data->rss->items[] = (object) $item;
			} 
		}	
	}
}
?>
