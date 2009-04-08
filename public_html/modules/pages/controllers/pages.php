<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends Public_Controller {

    function __construct() {
        parent::Public_Controller();
        $this->load->model('pages_m');
    }

    function _remap() {
    	// This basically keeps links to /home always pointing to the actual homepage even when the default_controller is changed
		@include(APPPATH.'/config/routes.php'); // simple hack to get the default_controller, could find another way.
		
		$slug = $this->uri->segment(1, NULL);

		// The default route is set to a different module than pages. Send them to there if they come looking for the homepage
		if(!empty($route) && $slug == 'home' && $route['default_controller'] != 'pages')
		{
			redirect('');
		}
		
		// Default route = pages
		else
		{
			// Show the requested page with all segments available
			call_user_func_array(array($this, 'index'), $this->uri->segment_array());
		}
    }
    
    
    function index($slug = 'home') {
    	
        $this->load->helper('typography');
        
        // No data, and its not the home page
        if(!$this->data->page = $this->pages_m->getPage(array("slug" => $slug, 'parse'=>true))):
        	show_404();
        endif;
        
        // // Parse any settings, links r ==or url tags
        $this->load->library('data_parser');
        //$this->data->page->body = $this->data_parser->parse($this->data->page->body);
        
        // This is the homepage, show the site slogan
        if($slug == 'home')
        {
	        $this->layout->title( $this->settings->item('site_slogan') );
        }
        
        // Use the page title for the title
        else
        {
	        $this->layout->title( $this->data->page->title );
        }
        
        $this->layout->create('index', $this->data);
    }
    
}

?>