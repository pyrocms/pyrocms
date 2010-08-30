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

	    // Show error and exit if the user does not have sufficient permissions
	    if( ! self::_check_access() )
	    {
		  	show_error($this->lang->line('cp_access_denied'));
		    exit;
	    }

	    // Get a list of all modules available to this user / group
		if ($this->user)
		{
			$this->template->core_modules = $this->cache->model('module_m', 'get_all', array(
				array(
					'is_backend_menu' => TRUE,
					'is_backend' => TRUE,
					'group' => $this->user->group,
					'lang' => CURRENT_LANGUAGE
				) // This function does NOT need role OR language, that is to give it a unique md5 hash
			), $this->config->item('navigation_cache'));

			$addon_modules = $this->cache->model('module_m', 'get_all', array(
				array(
					'is_core' => FALSE,
					'is_backend' => TRUE,
					'group' => $this->user->group,
					'lang' => CURRENT_LANGUAGE
				) // This function does NOT need role OR language, that is to give it a unique md5 hash
			), $this->config->item('navigation_cache'));

			// This takes the modules array and creates a keyed array with the slug as the key.
			$modules_keyed = array();
			foreach($addon_modules as $mod)
			{
				$modules_keyed[$mod['slug']] = $mod;
			}
			$this->template->addon_modules = $modules_keyed;
		}

	    // Template configuration
	    $this->template->set_layout('admin/layout');
	    $this->template->enable_parser(FALSE);

	    $this->template
	    	->append_metadata( css('admin/style.css') )
			->append_metadata( css('jquery/jquery-ui.css') )
			->append_metadata( css('jquery/colorbox.css') )
	    	->append_metadata( '<script type="text/javascript">jQuery.noConflict();</script>' )
	    	->append_metadata( js('jquery/jquery-ui-1.8.4.min.js') )
	    	->append_metadata( js('jquery/jquery.colorbox.min.js') )
	    	->append_metadata( js('jquery/jquery.livequery.js') )
	    	->append_metadata( js('admin/jquery.uniform.min.js') )
	    	->append_metadata( js('admin/functions.js') )
    		->append_metadata( '<script type="text/javascript">pyro.apppath_uri="'.APPPATH_URI.'";pyro.base_uri="'.BASE_URI.'";</script>' );


	    $this->template->set_partial('header', 'admin/partials/header', FALSE);
	    $this->template->set_partial('navigation', 'admin/partials/navigation', FALSE);
	    $this->template->set_partial('metadata', 'admin/partials/metadata', FALSE);
	    $this->template->set_partial('footer', 'admin/partials/footer', FALSE);

//	    $this->output->enable_profiler(TRUE);
	}

	private function _check_access()
	{
	    // These pages get past permission checks
	    $ignored_pages = array('admin/login', 'admin/logout');

	    // Check if the current page is to be ignored
	    $current_page = $this->uri->segment(1, '') . '/' . $this->uri->segment(2, 'index');

	    // Dont need to log in, this is an open page
		if(in_array($current_page, $ignored_pages))
		{
			return TRUE;
		}

		else if (!$this->user)
		{
			redirect('admin/login');
		}

		// Admins can go straight in
		else if ($this->user->group === 'admin')
		{
			return TRUE;
		}

		// Well they at least better have permissions!
		else if ($this->user)
		{
			// We are looking at the index page. Show it if they have ANY admin access at all
			if($current_page == 'admin/index' && $this->permissions)
			{
				return TRUE;
			}

			else
			{
				// Check if the current user can view that page
				 return in_array($this->module, $this->permissions);
			}
		}

		// god knows what this is... erm...
		return FALSE;
	}
}