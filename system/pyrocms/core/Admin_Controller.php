<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Code here is run before admin controllers
class Admin_Controller extends MY_Controller {

	public function Admin_Controller()
	{
		parent::__construct();

		// Load the Language files ready for output
		$this->lang->load('admin');
		$this->lang->load('buttons');

		$this->load->helper('admin_theme');
		
		// Show error and exit if the user does not have sufficient permissions
		if ( ! self::_check_access())
		{
			show_error($this->lang->line('cp_access_denied'));
			exit;
		}
		
		if ( ! $this->admin_theme->slug)
		{
			show_error('This site has been set to use an admin theme that does not exist.');
		}

		// Prepare Asset library
	    $this->asset->set_theme(ADMIN_THEME);
		
		// grab the theme options if there are any
		$this->theme_options = $this->pyrocache->model('themes_m', 'get_values_by', array( array('theme' => ADMIN_THEME) ));
	
		// Template configuration
		$this->template
				->enable_parser(FALSE)
				->set('user', $this->user)
				->set('theme_options', $this->theme_options)
				->set_theme(ADMIN_THEME)
				->set_layout('default', 'admin');

		// trigger the run() method in the selected admin theme
		$class = 'Theme_'.ucfirst($this->admin_theme->slug);
		call_user_func(array(new $class, 'run'));

//	    $this->output->enable_profiler(TRUE);
	}

	private function _check_access()
	{
		// These pages get past permission checks
		$ignored_pages = array('admin/login', 'admin/logout');

		// Check if the current page is to be ignored
		$current_page = $this->uri->segment(1, '') . '/' . $this->uri->segment(2, 'index');

		// Dont need to log in, this is an open page
		if (in_array($current_page, $ignored_pages))
		{
			return TRUE;
		}
		else if ( ! $this->user)
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
			if ($current_page == 'admin/index' && $this->permissions)
			{
				return TRUE;
			}
			else
			{
				// Check if the current user can view that page
				return array_key_exists($this->module, $this->permissions);
			}
		}

		// god knows what this is... erm...
		return FALSE;
	}

}