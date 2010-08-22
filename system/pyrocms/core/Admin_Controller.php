<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Code here is run before admin controllers
class Admin_Controller extends MY_Controller
{
	function Admin_Controller()
	{
		parent::__construct();

		// Load the Language files ready for output
	    $this->lang->load('admin');
	    $this->lang->load('buttons');

	    $allow_access = FALSE;

	    // These pages get past permission checks
	    $ignored_pages = array('admin/login', 'admin/logout');

	    // Check if the current page is to be ignored
	    $current_page = $this->uri->segment(1, '') . '/' . $this->uri->segment(2, 'index');
	    $is_ignored_page = in_array($current_page, $ignored_pages);

	    // Check the user is an admin
	    $is_admin = $this->ion_auth->is_admin();

	    // Login: If not logged in and its not an ignored page, force login
	    if( ! $this->user && ! $is_ignored_page)
	    {
			if($current_page != 'admin/index')
			{
				$this->session->set_flashdata('error', lang('cp_must_login'));
			}
	    	redirect('admin/login');
	    }
	    // Logged in or ignored page
	    else
	    {
	    	$allow_access = TRUE;
	    }

	    // We are looking at the index page. Show it if they have ANY admin access at all
	    if( $current_page == 'admin/index' && $this->permissions_m->has_admin_access($this->user->group_id) )
	    {
	    	$allow_access = TRUE;
	    }

	    // Check Perms: Not an admin and this is not a page to ignore
	    elseif( ! $is_admin && ! $is_ignored_page )
	    {
		  	// Check if the current user can view that page
		    $allow_access = $this->permissions_m->check_rule_by_role( $this->user->group_id, array(
				'module' => $this->module,
				'controller' =>$this->controller,
				'method' =>$this->method
			));
	    }

	    // Show error and exit if the user does not have sufficient permissions
	    if( ! $allow_access )
	    {
		  	show_error($this->lang->line('cp_access_denied'));
		    exit;
	    }

	    // Get a list of all modules available to this role
	    if($current_page != 'admin/login')
	    {
	  		$this->data->core_modules = $this->cache->model('modules_m', 'get_modules', array(
	    		array(
					'is_backend_menu' => TRUE,
					'is_backend' => TRUE,
					'group' => $this->user->group,
	    			'lang' => CURRENT_LANGUAGE
				) // This function does NOT need role OR language, that is to give it a unique md5 hash
	    	), $this->config->item('navigation_cache'));

	    	$this->data->addon_modules = $this->cache->model('modules_m', 'get_modules', array(
	    		array(
					'is_core' => FALSE,
					'is_backend' => TRUE,
					'group' => $this->user->group,
	    			'lang' => CURRENT_LANGUAGE
				) // This function does NOT need role OR language, that is to give it a unique md5 hash
	    	), $this->config->item('navigation_cache'));

			// This takes the modules array and creates a keyed array with the slug as the key.
			$modules_keyed = array();
			foreach($this->data->addon_modules as $mod)
			{
				$modules_keyed[$mod['slug']] = $mod;
			}
			$this->data->addon_modules = $modules_keyed;
		}

	    // Template configuration
	    $this->template->set_layout('admin/layout');
	    $this->template->enable_parser(FALSE);

	    $this->template
	    	->append_metadata( css('admin/style.css') )
			->append_metadata( css('jquery/jquery-ui.css') )
			->append_metadata( css('jquery/colorbox.css') )
			->append_metadata( js('jquery/jquery.js') )
	    	->append_metadata( '<script type="text/javascript">jQuery.noConflict();</script>' )
	    	->append_metadata( js('jquery/jquery-ui.min.js') )
	    	->append_metadata( js('jquery/jquery.colorbox.min.js') )
	    	->append_metadata( js('jquery/jquery.livequery.js') )
	    	->append_metadata( js('admin/jquery.uniform.min.js') )
	    	->append_metadata( js('admin/functions.js') )
    		->append_metadata( '<script type="text/javascript">pyro.apppath_uri="'.APPPATH_URI.'";pyro.base_uri="'.BASE_URI.'";</script>' )
			->append_metadata( '<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->' );


	    $this->template->set_partial('header', 'admin/partials/header', FALSE);
	    $this->template->set_partial('navigation', 'admin/partials/navigation', FALSE);
	    $this->template->set_partial('metadata', 'admin/partials/metadata', FALSE);
	    $this->template->set_partial('footer', 'admin/partials/footer', FALSE);

	    //$this->output->enable_profiler(TRUE);
	}
}
