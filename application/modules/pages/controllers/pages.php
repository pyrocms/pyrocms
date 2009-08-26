<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends Public_Controller
{
	private $default_segment = 'home';
	
    function __construct() 
    {
        parent::Public_Controller();
        
        $this->load->model('pages_m');
        
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
        if(!$page = $this->cache->model('pages_m', 'getByURL', array($url_segments)) )
        {
        	show_404();
        }
        
        // Parse any settings, links or url tags
        $this->load->library('parser');
        $page->body = $this->parser->string_parse($page->body);
        
        // Not got a meta title? Use slogan for homepage or the normal page title for other pages
        if($page->meta_title == '')
        {
        	$page->meta_title = $this->viewing_homepage ? $this->settings->item('site_slogan') : $page->title;
        }
        
    	// If the GET variable isbasic exists, do not use a wrapper
	    if($this->input->get('_is_basic'))
	    {
	    	$this->layout->wrapper(FALSE);
	    }

	    // Use whatever wrapper is in the database
	    else
	    {
	    	$this->layout->wrapper('layouts/'.$page->layout_file);
	    }
        
        // Define data elements
        $this->data->page =& $page;
        
        // Create page output
	    $this->layout->title( $page->meta_title )
	    
        	->set_metadata('keywords', $page->meta_keywords)
        	->set_metadata('description', $page->meta_description)
        	
        	->create('index', $this->data);
    }
    
}

?>