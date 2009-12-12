<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends Public_Controller
{
	private $default_segment = 'home';
	
    function __construct() 
    {
        parent::Public_Controller();
        
        $this->load->model('pages_m');
        $this->load->model('page_layouts_m');
        
        // This basically keeps links to /home always pointing to the actual homepage even when the default_controller is changed
		@include(APPPATH.'/config/routes.php'); // simple hack to get the default_controller, could find another way.
		
		// This will be interesting later
		$this->viewing_homepage = $this->uri->segment(1, $this->default_segment) == $this->default_segment;
		
		$different_default = $route['default_controller'] != 'pages';
		
		if($this->viewing_homepage && $different_default)
		{
			redirect('');
		}
    }
    

    // Catch all requests to this page in one mega-function
    function _remap()
    {
    	// If no segments have been given, use the default route
    	$url_segments = $this->uri->total_segments() > 0 ? $this->uri->segment_array() : array($this->default_segment);

    	// Try and load the page from cache or directly, if not, 404
        if(!$page = $this->cache->model('pages_m', 'get_by_path', array($url_segments)) )
        {
        	show_404();
        }
        
        // Not got a meta title? Use slogan for homepage or the normal page title for other pages
        if($page->meta_title == '')
        {
        	$page->meta_title = $this->viewing_homepage ? $this->settings->item('site_slogan') : $page->title;
        }
        
        // Define data elements
        $this->data->page =& $page;
        
    	// If the GET variable isbasic exists, do not use a wrapper
	    $page->layout = $this->page_layouts_m->get($page->layout_id);
        
	    // Parse the layout string and output
	    $page->layout->body = $this->parser->string_parse(stripslashes($page->layout->body), $this->data, TRUE);
        
        // Create page output
	    $this->template->title( $page->meta_title )
	    
        	->set_metadata('keywords', $page->meta_keywords)
        	->set_metadata('description', $page->meta_description)
        	
        	->build('index', $this->data);
    }
    
}

?>