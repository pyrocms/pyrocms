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
		@include(APPPATH.'config/routes.php'); // simple hack to get the default_controller, could find another way.
		
		// This will be interesting later
		$this->viewing_homepage = $this->uri->segment(1, $this->default_segment) == $this->default_segment;
		
		$different_default = $route['default_controller'] != 'pages';
		
		if($this->viewing_homepage && $different_default)
		{
			redirect('');
		}
    }
    

    // Catch all requests to this page in one mega-function
    function _remap($method)
    {
    	// This page has been routed to with pages/view/whatever
    	if($this->uri->rsegment(1, '').'/'.$method == 'pages/view')
    	{
    		$url_segments = $this->uri->total_rsegments() > 0 ? $this->uri->rsegment_array() : array($this->default_segment);
    		$url_segments = array_slice($url_segments, 2);
    	}
    	
    	// not routed, so use the actual URI segments
    	else
    	{
    		$url_segments = $this->uri->total_segments() > 0 ? $this->uri->segment_array() : array($this->default_segment);
    	}
    	
    	// Fetch this page from the database via cache
    	$page = $this->cache->model('pages_m', 'get_by_path', array($url_segments));
    	
    	// If page is missing or not live (and not an admin) show 404
		if( !$page || ($page->status == 'draft' && !$this->user_lib->check_role('admin')) )
        {
        	// Try and get an error page. If its been deleted, show nasty 404
        	if(!$page = $this->cache->model('pages_m', 'get_by_path', array('404')) )
	        {
				log_message('error', '404 Page Not Found --> '.implode('/', $url_segments));
				
				$EXP = new CI_Exceptions;
				echo $EXP->show_error('', '', 'error_404', 404);
				exit;
	        }
        }
        
        // 404 page? Set the right status
        if($page->slug == '404')
        {
			$this->output->set_status_header(404);
        }
	        
        // Not got a meta title? Use slogan for homepage or the normal page title for other pages
        if($page->meta_title == '')
        {
        	$page->meta_title = $this->viewing_homepage ? $this->settings->item('site_slogan') : $page->title;
        }
        
    	// If the GET variable isbasic exists, do not use a wrapper
	    if(!$page->layout = $this->page_layouts_m->get($page->layout_id))
	    {
	    	// Some pillock deleted the page layout, use the default and pray to god they didnt delete that too
	    	$page->layout = $this->page_layouts_m->get(1);
	    }
	    
        // Parser does not need ALL information for this bit, and I hate the Dwoo object syntax
        $page_array = array('page' => (array) $page);
        
	    // Parse the layout string and output
	    $page->layout->body = $this->parser->string_parse(stripslashes($page->layout->body), $page_array, TRUE);
	    
	    // Define data elements
        $this->data->page =& $page;
        $this->data->page->layout = $page->layout;
	    
        // Create page output
	    $this->template->title( $page->meta_title )
	    
        	->set_metadata('keywords', $page->meta_keywords)
        	->set_metadata('description', $page->meta_description)
        	
        	->build('index', $this->data);
    }
    
}

?>