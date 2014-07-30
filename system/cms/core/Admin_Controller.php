<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Pyro\Module\Addons\ThemeOptionModel;

/**
 * This is the basis for the Admin class that is used throughout PyroCMS.
 * 
 * Code here is run before admin controllers
 * 
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @package PyroCMS\Core\Controllers
 */
class Admin_Controller extends MY_Controller
{
	/**
	 * Admin controllers can have sections, normally an arbitrary string
	 *
	 * @var string 
	 */
	protected $section = null;

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
		if ( ! self::checkAccess()) {
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect();
		}

		// If the setting is enabled redirect request to HTTPS
		if (Settings::get('admin_force_https') and strtolower(substr(current_url(), 4, 1)) != 's') {
			redirect(str_replace('http:', 'https:', current_url()).'?session='.session_id());
		}

		$this->load->helper('admin_theme');
		
		$theme = $this->themeManager->locate(Settings::get('admin_theme'));

		// Using a bad slug? Weak
		if (is_null($theme)) {
			show_error('This site has been set to use an admin theme that does not exist.');
		}

		$this->theme = ci()->theme = $theme;

		// make a constant as this is used in a lot of places
		defined('ADMIN_THEME') or define('ADMIN_THEME', $this->theme->model->slug);
			
		// Set the location of assets
		Asset::add_path('theme', $this->theme->web_path.'/');
		Asset::set_path('theme');
		
		$this->registerWidgetLocations();

		// Active Admin Section (might be null, but who cares)
		$this->template->active_section = $this->section;
		
		Events::trigger('admin_controller');

		// -------------------------------------
		// Build Admin Navigation
		// -------------------------------------
		// We'll get all of the backend modules
		// from the DB and run their module items.
		// -------------------------------------

		if (is_logged_in())
		{
			// Here's our menu array.
			$menu_items = array();

			// This array controls the order of the admin items.
			$this->template->menu_order = array('lang:cp:nav_content', 'lang:cp:nav_structure', 'lang:cp:nav_data', 'lang:cp:nav_users', 'lang:cp:nav_settings', 'lang:global:profile');

			$modules = $this->moduleManager->getAllEnabled(array(
				'is_backend' => true,
			));

			foreach ($modules as $module) {

				// Only enabled ones
				if (! module_enabled($module['slug'])) continue;

				// If we do not have an admin_menu function, we use the
				// regular way of checking out the details.php data.
				if ($module['menu'] and ($this->current_user->hasAccess($module['slug'].'.*'))) {

					// Legacy module routing. This is just a rough
					// re-route and modules should change using their 
					// upgrade() details.php functions.
					if ($module['menu'] == 'utilities') $module['menu'] = 'data';
					if ($module['menu'] == 'design') $module['menu'] = 'structure';

					$menu_items['lang:cp:nav_'.$module['menu']][$module['name']] = 'admin/'.$module['slug'];
				}

				// If a module has an admin_menu function, then
				// we simply run that and allow it to manipulate the
				// menu array.
				if (method_exists($module['module'], 'admin_menu')) {
					$module['module']->admin_menu($menu_items);
				}
			}

			// We always have our 
			// edit profile links and such.
			$menu_items['lang:global:profile'] = array(
				'lang:cp:edit_profile_label' => 'edit-profile',
				'lang:cp:logout_label'		 => 'admin/logout'
			);

			// Trigger an event so modules can mess with the
			// menu items array via the events structure. 
			$event_output = Events::trigger('admin_menu', $menu_items, 'array');

			// If we get an array, we assume they have altered the menu items
			// and are returning them to us to use.
            if (isset($event_output[0]) and is_array($event_output[0])) {
				$menu_items = $event_output[0];
			}

			// Order the menu items. We go by our menu_order array.
			$ordered_menu = array();

			foreach ($this->template->menu_order as $order) {
				if (isset($menu_items[$order])) {
					$ordered_menu[lang_label($order)] = $menu_items[$order];
					unset($menu_items[$order]);
				}
			}

			// Any stragglers?
			if ($menu_items) {
				$translated_menu_items = array();

				// translate any additional top level menu keys so the array_merge works
				foreach ($menu_items as $key => $menu_item)
				{
					$translated_menu_items[lang_label($key)] = $menu_item;
				}

				$ordered_menu = array_merge_recursive($ordered_menu, $translated_menu_items);
			}

			// And there we go! These are the admin menu items.
			$this->template->menu_items = $ordered_menu;
		}

		// ------------------------------
		
		// Template configuration
		$this->template
			->enable_parser(false)
			->set('theme_options', (object) $this->theme->model->getOptionValues())
			->set_theme(ADMIN_THEME)
			->set_layout('default', 'admin');

		// trigger the run() method in the selected admin theme
		$class = 'Theme_'.ucfirst($this->theme->model->slug);
		call_user_func(array(new $class, 'run'));
	}

	/**
	 * Checks to see if a user object has access rights to the admin area.
	 *
	 * @return boolean 
	 */
	private function checkAccess()
	{
		// These pages get past permission checks
		$ignored_pages = array('admin/login', 'admin/logout', 'admin/help');

		// Check if the current page is to be ignored
		$current_page = $this->uri->segment(1, '') . '/' . $this->uri->segment(2, 'index');

		// Dont need to log in, this is an open page
		if (in_array($current_page, $ignored_pages)) {
			return true;
		}

		if ( ! $this->current_user) {
			
			// save the location they were trying to get to
			$this->session->set_userdata('admin_redirect', $this->uri->uri_string());
			redirect('admin/login');

		// Well they at least better have permissions!
		} if ($this->current_user) {
			
			if ($this->current_user->isSuperUser()) {
				return true;

			// We are looking at the index page. Show it if they have ANY admin access at all
			} elseif ($this->current_user->is_blocked) {
                $this->sentry->logout($this->current_user);
                throw new \Exception('Your account has been blocked.');
            } elseif ($current_page === 'admin/index' && $this->current_user->hasAccess('admin.general')){
				return true;
			}

			// Check if the current user can view that page
			return $this->current_user->hasAccess("{$this->module}.*");
		}

		// god knows what this is... erm...
		return false;
	}

	/**
	 * Let the Frontend know where Widgets are hiding
	 */
	protected function registerWidgetLocations()
	{
		$this->widgetManager->setLocations(array(
		   SHARED_ADDONPATH.'themes/'.ADMIN_THEME.'/widgets/',
		   APPPATH.'themes/'.ADMIN_THEME.'/widgets/',
		   ADDONPATH.'themes/'.ADMIN_THEME.'/widgets/',
		   APPPATH.'widgets/',
		   ADDONPATH.'widgets/',
		   SHARED_ADDONPATH.'widgets/',
		));
	}

}