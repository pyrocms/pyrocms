<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Code here is run before ALL controllers
class MY_Controller extends Controller {
	
	var $module;
	var $controller;
	var $method;
	
	function MY_Controller() {
		
		parent::Controller();
		
        // Make sure we have the user module
        if( ! is_module('users') )
        {
        	show_error('The user module is missing.');
        }
        
        else
        {
	        // Load the user model and get user data
	        $this->load->module_model('users', 'users_m');
	        $this->load->module_library('users', 'user_lib');
	        
	        $this->data->user =& $this->user_lib->user_data;
        }
        
        
        // Work out module, controller and method and make them accessable throught the CI instance
        $this->module 				= str_replace(array('modules/', '/'), '', $this->matchbox->fetch_module());
        $this->controller			= strtolower(get_class($this));
        $s 							= $this->uri->rsegment_array();
        $n 							= array_search($this->controller, $s);
        $this->method 				= $this->uri->rsegment($n+1);
		
		// Get meta data for the module
        $this->module_data 			= $this->modules_m->getModule($this->module);
        
        // Make them available to all layout files
        $this->data->module_data	=& $this->module_data;
        
        $this->data->module 		=& $this->module;
        $this->data->controller 	=& $this->controller;
        $this->data->method 		=& $this->method;
	}
}

// Code here is run before frontend controllers
class Public_Controller extends MY_Controller {
    
	function Public_Controller() {
        
		parent::MY_Controller();
        
        // Check the frontend hasnt been disabled by an admin
        if(!$this->settings->item('frontend_enabled'))
        {
        	show_error($this->settings->item('unavailable_message'));
        }
        
        // -- Navigation menu -----------------------------------
        $this->load->module_model('pages', 'pages_m');
        $this->load->module_model('navigation', 'navigation_m');
        
        // Get Navigation Groups
		$this->data->groups = $this->navigation_m->getGroups();
		
		// Go through all the groups 
    	foreach($this->data->groups as $group)
    	{
	    	$group_links = $this->navigation_m->getLinks(array(
    			'group'=>$group->id,
    			'order'=>'position, title'
    		));
    		
    		$has_current_link = false;

    		// Loop through all links and add a "current_link" property to show if it is active
    		if( !empty($group_links) )
    		{
	    		foreach($group_links as &$link)
	    		{
	    			$full_match = site_url($this->uri->uri_string()) == $link->url;
	    			$segment1_match = site_url($this->uri->rsegment(1, '')) == $link->url;
	    			
	    			// Either the whole URI matches, or the first segment matches
	    			if($link->current_link = $full_match || $segment1_match)
	    			{
	    				$has_current_link = true;
	    			}
	    		}
	    		
	    		// Assign it 
	    		$this->data->navigation[$group->abbrev] = (array) $group_links;
    		}
    		
    		// No current link, set the first in the group
    		if(!$has_current_link)
    		{
    			$group_links[0]->current_link = TRUE;
    		}
    		
    	}

        // Set the theme view folder
        $this->data->theme_view_folder = '../themes/'.$this->settings->item('default_theme').'/views/';
        $this->layout->layout_file = $this->data->theme_view_folder.'layout.php';
        
    }

}




// Code here is run before admin controllers
class Admin_Controller extends MY_Controller {
    
	function Admin_Controller() {
        
		parent::MY_Controller();
        
        $allow_access = FALSE;
        	
        // These pages get past permission checks
        $ignored_pages = array('admin/login', 'admin/logout');

        // Check if the current page is to be ignored
        $current_page = $this->uri->segment(1, '') . '/' . $this->uri->segment(2, '');
        $is_ignored_page = in_array($current_page, $ignored_pages);
        
        // Check the user is an admin
        $is_admin = $this->user_lib->check_role('admin');
        
        // Login: If not logged in and its not an ignored page, force login
        if( ! $this->data->user && ! $is_ignored_page)
        {
        	redirect('admin/login');
        }
        
        // Logged in or ignored page
        else
        {
        	$allow_access = TRUE;
        }
        
        // We are looking at the index page. Show it if they have ANY admin access at all
        if( in_array($current_page, array('admin/', 'admin/index')) && $this->permissions_m->hasAdminAccess($this->data->user->role) )
        {
        	$allow_access = TRUE;
        }
        
        // Check Perms: Not an admin and this is not a page to ignore
        elseif( ! $is_admin && ! $is_ignored_page )
        {
	        // Check if the current user can view that page
	        $location = array( 'module'=>$this->module, 'controller'=>$this->controller, 'method'=>$this->method );
	        $allow_access = $this->permissions_m->checkRuleByRole( $this->data->user->role, $location );
        }
        
        // Show error and exit if the user does not have sufficient permissions
        if( ! $allow_access )
        {
	        show_error('You do not have sufficient permissions to view this page.');
	        exit;
        }
        
        $this->data->toolbar = $this->modules_m->getModuleToolbar($this->module);
        
        $this->layout->layout_file = 'admin/layout.php';
    	//$this->output->enable_profiler(TRUE);
    }
    
}

?>