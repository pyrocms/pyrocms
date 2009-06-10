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
		
			// start adding the language handling
			$this->lang->load('admin');
			
				
				// layout
				$this->data->confirmLabel = $this->lang->line('confirm');
				$this->data->noLabel = $this->lang->line('yes');
				$this->data->yesLabel = $this->lang->line('no');
				
				
				// result messages
				$this->data->closeMessage = $this->lang->line('close_message');
				$this->data->generalErrorLabel = $this->lang->line('general_error_label');
				$this->data->requiredErrorLabel = $this->lang->line('required_error_label');
				$this->data->noteLabel = $this->lang->line('note_label');
				$this->data->successLabel = $this->lang->line('success_label');
				
				// breadcrumbs
				$this->data->breadcrumbHomeTitle = $this->lang->line('breadcrumb_home_title');
								
				// header
				$this->data->cpToHome = $this->lang->line('cp_to_home');
				$this->data->cpViewFrontend = $this->lang->line('cp_view_frontend');
				$this->data->cpLoggedInAs = sprintf($this->lang->line('cp_logged_in_as'), $this->data->user->first_name.' '.$this->data->user->last_name);
				$this->data->cpLogout = sprintf($this->lang->line('cp_logout'), anchor('edit-profile', $this->lang->line('cp_edit_profile_label')), anchor('admin/logout', $this->lang->line('cp_logout_label')));
				
				// inner_header
					// seems not required yet
				
				// table_buttons
				$this->data->saveLabel = $this->lang->line('save_label');
				$this->data->cancelLabel = $this->lang->line('cancel_label');
				$this->data->deleteLabel = $this->lang->line('delete_label');
				$this->data->activateLabel = $this->lang->line('activate_label');
				$this->data->publishLabel = $this->lang->line('publish_label');
				$this->data->uploadLabel = $this->lang->line('upload_label');

				//$this->data-> = $this->lang->line('');
				
			// end adding the language handling
        
        $this->data->toolbar = $this->modules_m->getModuleToolbar($this->module);
        
        $this->layout->layout_file = 'admin/layout.php';
    	
        //$this->output->enable_profiler(TRUE);
    }
    
}