<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Code here is run before the site manager controllers
class Sites_Controller extends MX_Controller {

	public $module_details;
	public $module;
	public $controller;
	public $method;

	public function __construct()
	{
		parent::__construct();
		
		// First off set the db prefix
		$this->db->set_dbprefix('core_');

		// If we're on the MSM then we turn the session table off.
		$this->config->set_item('sess_use_database', false);
		
		// If using a URL not defined as a site, set this to stop the world ending
		defined('SITE_REF') or define('SITE_REF', 'core');
		
		// make sure they've ran the installer before trying to view our shiny panel
		$this->db->table_exists('sites') or redirect('installer');
		
		defined('ADMIN_THEME') or define('ADMIN_THEME', 'msm');

		defined('MSMPATH') or redirect('404');

		// define folders that we need to create for each new site
		ci()->locations = $this->locations = array(
			APPPATH.'cache'	=> array(
				'simplepie'
			),
			'addons' => array(
				'modules',
				'widgets',
				'themes',
			),
			'uploads'	=> array(),
		);
		
		// Since we don't need to lock the lang with a setting like /admin and
		// the front-end we just define CURRENT_LANGUAGE exactly the same as AUTO_LANGUAGE
		defined('CURRENT_LANGUAGE') OR define('CURRENT_LANGUAGE', AUTO_LANGUAGE);
		
		// Load the Language files ready for output
		$this->lang->load(array('admin', 'buttons', 'global', 'sites/sites', 'users/user'));
		
		// Load all the required classes
		$this->load->model(array('sites_m', 'user_m', 'settings_m'));
		
		$this->load->library(array('session', 'form_validation', 'settings/settings'));
		$this->load->dbforge();
		
		// Work out module, controller and method and make them accessable throught the CI instance
		ci()->module = $this->module = $this->router->fetch_module();
		ci()->controller = $this->controller = $this->router->fetch_class();
		ci()->method = $this->method = $this->router->fetch_method();
		ci()->module_details = $this->module_details = array('slug' => 'sites');

		// Load helpers
		$this->load->helper('admin_theme');
		$this->load->helper('file');
		$this->load->helper('number');
		$this->load->helper('date');
		$this->load->helper('cookie');
		
		// Load ion_auth config so our user's settings (password length, etc) are in sync
		$this->load->config('users/ion_auth');

		// Set the theme as a path for Asset library
		Asset::add_path('theme', MSMPATH.'themes/'.ADMIN_THEME.'/');
		Asset::set_path('theme');
		
		// check to make sure they're logged in
		if ( $this->method !== 'login' AND ! $this->user_m->logged_in())
		{
			redirect('sites/login');
		}

		$this->template->add_theme_location(MSMPATH.'themes/');
		
		// Template configuration
		$this->template
			->append_css('theme::common.css')
			->append_js('jquery/jquery.cooki.js')
			->enable_parser(false)
			->set('super_username', $this->session->userdata('super_username'))
			->set_theme(ADMIN_THEME)
			->set_layout('default', 'admin');
	}
}