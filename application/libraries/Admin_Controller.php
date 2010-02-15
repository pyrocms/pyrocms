<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Code here is run before admin controllers
class Admin_Controller extends MY_Controller
{
	function Admin_Controller()
	{
		parent::__construct();
		
		// Load the Language files ready for output
	    $this->lang->load('admin');
 
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
	    if( in_array($current_page, array('admin/', 'admin/index')) && $this->permissions_m->has_admin_access($this->data->user->role) )
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
		  	show_error($this->lang->line('cp_access_denied'));
		    exit;
	    }
		
	    // TODO: PJS I do not think this cache is working. Got bored and went to the pub...
	    // Get a list of all modules available to this role
	    if($current_page != 'admin/login')
	    {
	  		$this->data->core_modules = $this->cache->model('modules_m', 'getModules', array(
	    		array(
					'is_backend_menu' => TRUE,
					'role' => @$this->data->user->role,
	    			'lang' => CURRENT_LANGUAGE
				) // This function does NOT need role OR language, that is to give it a unique md5 hash
	    	), $this->config->item('navigation_cache'));

	    	$this->data->third_party_modules = $this->cache->model('modules_m', 'getModules', array(
	    		array(
					'is_core' => FALSE,
					'is_backend' => TRUE,
					'role' => @$this->data->user->role,
	    			'lang' => CURRENT_LANGUAGE
				) // This function does NOT need role OR language, that is to give it a unique md5 hash
	    	), $this->config->item('navigation_cache'));
		}

	    // Template configuration
	    $this->template->set_layout('admin/layout');
	    $this->template->enable_parser(FALSE);
	    
	    $this->template->append_metadata( js('jquery/jquery.js') )
	    	->append_metadata( js('jquery/jquery-ui.min.js') )
	    	->append_metadata( '<script type="text/javascript">jQuery.noConflict();</script>' )
	    	->append_metadata( js('jquery/jquery.livequery.js') )
	    	->append_metadata( js('jquery/jquery.fancybox.js') )
	    	->append_metadata( css('jquery/jquery.fancybox.css') )
	    	->append_metadata( js('jquery/jquery.dimensions.js') )
	    	->append_metadata( js('jquery/jquery.imgareaselect.js') )
	    	->append_metadata( js('jquery/tabs.pack.js') )
	    	->append_metadata( js('admin.js') )
	    	->append_metadata( css('admin/admin.css') );
	    
	    $this->template->set_partial('header', 'admin/partials/header', FALSE);
	    $this->template->set_partial('metadata', 'admin/partials/metadata', FALSE);
	    $this->template->set_partial('footer', 'admin/partials/footer', FALSE);
	    
	    //$this->output->enable_profiler(TRUE);
	}    
}