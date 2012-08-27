<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This is the basis for the Admin class that is used throughout PyroCMS.
 * 
 * Code here is run before admin controllers
 * 
 * @package PyroCMS\Core\Controllers
 */
class Admin_Controller extends MY_Controller {

	/**
	 * Admin controllers can have sections, normally an arbitrary string
	 *
	 * @var string 
	 */
	protected $section = NULL;

	/**
	 * Load language, check flashdata, define https, load and setup the data 
	 * for the admin theme
	 */
	public function __construct()
	{
		parent::__construct();

		// Load the Language files ready for output
		$this->lang->load('admin');
		$this->lang->load('buttons');
		
		// Show error and exit if the user does not have sufficient permissions
		if ( ! self::_check_access())
		{
			$this->session->set_flashdata('error', lang('cp_access_denied'));
			redirect();
		}

		// If the setting is enabled redirect request to HTTPS
		if ($this->settings->admin_force_https and strtolower(substr(current_url(), 4, 1)) != 's')
		{
			redirect(str_replace('http:', 'https:', current_url()).'?session='.session_id());
		}

		$this->load->helper('admin_theme');
		
		ci()->admin_theme = $this->theme_m->get_admin();
		
		// Using a bad slug? Weak
		if (empty($this->admin_theme->slug))
		{
			show_error('This site has been set to use an admin theme that does not exist.');
		}

		// make a constant as this is used in a lot of places
		defined('ADMIN_THEME') or define('ADMIN_THEME', $this->admin_theme->slug);
			
		// Set the location of assets
		Asset::add_path('theme', $this->admin_theme->web_path.'/');
		Asset::set_path('theme');
		
		// grab the theme options if there are any
		ci()->theme_options = $this->pyrocache->model('theme_m', 'get_values_by', array(array('theme' => ADMIN_THEME) ));
	
		// Active Admin Section (might be null, but who cares)
		$this->template->active_section = $this->section;
		
		Events::trigger('admin_controller');
		
		// Template configuration
		$this->template
			->enable_parser(FALSE)
			->set('theme_options', $this->theme_options)
			->set_theme(ADMIN_THEME)
			->set_layout('default', 'admin');

		// trigger the run() method in the selected admin theme
		$class = 'Theme_'.ucfirst($this->admin_theme->slug);
		call_user_func(array(new $class, 'run'));
	}

	/**
	 * Checks to see if a user object has access rights to the admin area.
	 *
	 * @return boolean 
	 */
	private function _check_access()
	{
		// These pages get past permission checks
		$ignored_pages = array('admin/login', 'admin/logout', 'admin/help');

		// Check if the current page is to be ignored
		$current_page = $this->uri->segment(1, '') . '/' . $this->uri->segment(2, 'index');

		// Dont need to log in, this is an open page
		if (in_array($current_page, $ignored_pages))
		{
			return TRUE;
		}

		if ( ! $this->current_user)
		{
			// save the location they were trying to get to
			$this->session->set_userdata('admin_redirect', $this->uri->uri_string());
			redirect('admin/login');
		}

		// Admins can go straight in
		if ($this->current_user->group === 'admin')
		{
			return TRUE;
		}

		// Well they at least better have permissions!
		if ($this->current_user)
		{
			// We are looking at the index page. Show it if they have ANY admin access at all
			if ($current_page == 'admin/index' && $this->permissions)
			{
				return TRUE;
			}

			// Check if the current user can view that page
			return array_key_exists($this->module, $this->permissions);
		}

		// god knows what this is... erm...
		return FALSE;
	}

}