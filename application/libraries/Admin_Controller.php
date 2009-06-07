<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Code here is run before admin controllers
class Admin_Controller extends MY_Controller
{
	function Admin_Controller()
	{
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

        // TODO: PJS I do not think this cache is working. Got bored and went to the pub...
        // Get a list of all modules available to this role
        if($current_page != 'admin/login')
        {
	        $this->data->admin_modules = $this->cache->model('modules_m', 'getModules', array(
	        	array('is_backend'=>true, 'role' => @$this->data->user->role) // This function does NOT need role, that is to keep caching seperate
	        ));
		}
        
        $this->data->toolbar = $this->modules_m->getModuleToolbar($this->module);
        
        $this->layout->layout_file = 'admin/layout.php';
    	
        //$this->output->enable_profiler(TRUE);
    }
    
}