<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author 		Phil Sturgeon - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Pages Module
 * @category 	Modules
 */
class Pages extends Public_Controller
{
	/**
	 * The default segment
	 * @access private
	 * @var string
	 */
	private $default_segment = 'home';
	
	/**
	 * Constructor method
	 * @access public
	 * @return void
	 */
    public function __construct() 
    {
    	parent::Public_Controller();
        $this->load->model('pages_m');
        $this->load->model('page_layouts_m');
        
        // This basically keeps links to /home always pointing to the actual homepage even when the default_controller is changed
		@include(APPPATH.'config/routes.php'); // simple hack to get the default_controller, could find another way.
		
		// This will be interesting later
		$this->viewing_homepage = $this->uri->segment(1, $this->default_segment) == $this->default_segment;

		if ($this->viewing_homepage AND $this->uri->segment(1) AND $route['default_controller'] != 'pages')
		{
			redirect('');
		}
    }
    

	/**
	 * Catch all requests to this page in one mega-function
	 * @access public
	 * @param string $method The method to call
	 * @return void
	 */
    public function _remap($method)
    {
		$this->load->model('redirects/redirect_m');
		$uri = trim(uri_string(), '/');
		if ($redirect = $this->redirect_m->get_from($uri))
		{
			redirect($redirect->to);
		}

    	// This page has been routed to with pages/view/whatever
    	if ($this->uri->rsegment(1, '').'/'.$method == 'pages/view')
    	{
    		$url_segments = $this->uri->total_rsegments() > 0 ? $this->uri->rsegment_array() : array($this->default_segment);
    		$url_segments = array_slice($url_segments, 2);
    	}
    	
    	// not routed, so use the actual URI segments
    	else
    	{
    		$url_segments = $this->uri->total_segments() > 0 ? $this->uri->segment_array() : array($this->default_segment);
    	}
    	
    	// If it has .rss on the end then parse the RSS feed
        preg_match('/.rss$/', end($url_segments))
			? $this->_rss($url_segments)
        	: $this->_page($url_segments);
    }
    
	/**
	 * Page method
	 * @access public
	 * @param array $url_segments The URL segments
	 * @return void
	 */
    public function _page($url_segments)
    {
    	// Fetch this page from the database via cache
    	$page = $this->cache->model('pages_m', 'get_by_uri', array($url_segments));

		// If page is missing or not live (and not an admin) show 404
		if ( ! $page OR ($page->status == 'draft' AND ( ! isset($this->user->group) OR $this->user->group != 'admin') ))
        {
        	$page = $this->_404($url_segments);
        }

		// If the page is missing, set the 404 status header
        if ( $page->slug == '404')
        {
        	$this->output->set_status_header(404);
        }

		// Nope, it's a page but do they have access?
		elseif ($page->restricted_to)
		{
			$page->restricted_to = (array) explode(',', $page->restricted_to);

			// Are they logged in and an admin or a member of the correct group?
			if ( ! $this->user OR (isset($this->user->group) AND $this->user->group != 'admin' AND ! in_array($this->user->group_id, $page->restricted_to)))
			{
				redirect('users/login/' . implode('/', $url_segments));
			}
		}
		
    	// Not got a meta title? Use slogan for homepage or the normal page title for other pages
        if ($page->meta_title == '')
        {
        	$page->meta_title = $this->viewing_homepage ? $this->settings->site_slogan : $page->title;
        }
        
        // If this page has an RSS feed, show it
    	if ($page->rss_enabled)
	    {
			$this->template->append_metadata('<link rel="alternate" type="application/rss+xml" title="'.$page->meta_title.'" href="'.site_url(uri_string(). '.rss').'" />');
	    }
        
    	// Wrap the page with a page layout, otherwise use the default 'Home' layout
	    if ( ! $page->layout = $this->page_layouts_m->get($page->layout_id))
	    {
	    	// Some pillock deleted the page layout, use the default and pray to god they didnt delete that too
	    	$page->layout = $this->page_layouts_m->get(1);
	    }

		// If a Page Layout has a Theme Layout that exists, use it
		if ( ! empty($page->layout->theme_layout) AND $this->template->layout_exists($page->layout->theme_layout))
		{
			$this->template->set_layout($page->layout->theme_layout);
		}
	    
	    // Convert to an array for nicer Dwoo syntax
		$page_array = (array) $page;
		$page_array['layout'] = (array) $page_array['layout'];

		// Parse it so the content is parsed
		$page_array['body'] = $this->parser->parse_string(str_replace('&quot;', '"', $page->body), $this->data, TRUE);
		
        // Create page output
	    $this->template->title($page->meta_title)
	    
        	->set_metadata('keywords', $page->meta_keywords)
        	->set_metadata('description', $page->meta_description)

			->set('page', $page_array)

			->append_metadata('
				<style type="text/css">
					' . $page->layout->css . '
					' . $page->css . '
				</style>
				<script type="text/javascript">
					' . $page->layout->js . '
					' . $page->js . '
				</script>')

        	->build('page', $this->data);
    }
    
	/**
	 * RSS method
	 * @access public
	 * @param array $url_segments The URL segments
	 * @return void
	 */
    public function _rss($url_segments)
    {
        // Remove the .rss suffix
    	$url_segments += array(preg_replace('/.rss$/', '', array_pop($url_segments)));
    	
    	// Fetch this page from the database via cache
    	$page = $this->cache->model('pages_m', 'get_by_uri', array($url_segments));
    	
    	// If page is missing or not live (and not an admin) show 404
		if (empty($page) OR ($page->status == 'draft' AND $this->user->group !== 'admin') OR ! $page->rss_enabled)
        {
        	// Will try the page then try 404 eventually
        	$this->_page('404');
        	return;
        }
    	
    	$children = $this->cache->model('pages_m', 'get_many_by', array(array(
    		'parent_id' => $page->id,
    		'status' => 'live'
    	)));
    	
		$data->rss->title = ($page->meta_title ? $page->meta_title : $page->title) . ' | '. $this->settings->site_name;
		$data->rss->description = $page->meta_description;
		$data->rss->link = site_url($url_segments);
		$data->rss->creator_email = $this->settings->contact_email;
		
		if ( ! empty($children))
		{
			$this->load->helper(array('date', 'xml'));
			
			foreach($children as &$row)
			{
				$row->link = $row->uri ? $row->uri : $row->slug;
				$row->created_on = standard_date('DATE_RSS', $row->created_on);
				
				$item = array(
					//'author' => $row->author,
					'title' => xml_convert($row->title),
					'link' => $row->link,
					'guid' => $row->link,
					'description'  => $row->meta_description,
					'date' => $row->created_on
				);
						
				$data->rss->items[] = (object) $item;
			} 
		}
		
		$this->load->view('rss', $data);
		
    }
    
	/**
	 * 404 method
	 * @access public
	 * @param array $url_segments The URL segments
	 * @return void
	 */
    public function _404($url_segments)
    {
    	// Try and get an error page. If its been deleted, show nasty 404
        if ( ! $page = $this->cache->model('pages_m', 'get_by_uri', array('404')) )
        {
			show_404();
        }
        
        return $page;
    }
}