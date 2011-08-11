<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Code here is run before ALL controllers
class MY_Controller extends CI_Controller {

	// Deprecated: No longer used globally
	protected $data;
	public $module;
	public $controller;
	public $method;

	public function MY_Controller()
	{
		parent::__construct();

		$this->benchmark->mark('my_controller_start');

		// TODO: Remove all this migration check in the next major version after 1.3.0
		// This extra check needs to be done to make the "multisite" changes run before the rest
		// of the controller attempts to run
		if ($this->db->table_exists('schema_version'))
		{
			$this->load->library('migrations');
			$this->migrations->latest();

			if ($this->migrations->error)
			{
				show_error($this->migrations->error);
			}

			redirect(current_url());
		}
		// End migration check

		// No record? Probably DNS'ed but not added to multisite
		if ( ! defined('SITE_REF'))
		{
			show_error('This domain is not set up correctly.');
		}

		// By changing the prefix we are essentially "namespacing" each pyro site
		$this->db->set_dbprefix(SITE_REF.'_');
		$this->load->library('pyrocache');

		// Add the site specific theme folder
		$this->template->add_theme_location(ADDONPATH.'themes/');

		// Migration logic helps to make sure PyroCMS is running the latest changes

		$this->load->library('migrations');
		// $this->migrations->verbose = true;
		$schema_version = $this->migrations->latest();

		if ($this->migrations->error)
		{
			show_error($this->migrations->error);
		}

		// Result of schema version migration
		if (is_numeric($schema_version))
		{
			log_message('debug', 'PyroCMS was migrated to version: ' . $schema_version);
		}
		elseif ($schema_version === FALSE)
		{
			log_message('error', $this->migrations->error);
		}

		// With that done, load settings
		$this->load->library(array('settings/settings'));

		// Lock front-end language
		if ( ! (is_a($this, 'Admin_Controller') && ($site_lang = AUTO_LANGUAGE)))
		{
			$site_public_lang = explode(',', Settings::get('site_public_lang'));

			if (in_array(AUTO_LANGUAGE, $site_public_lang))
			{
				$site_lang = AUTO_LANGUAGE;
			}
			else
			{
				$site_lang = Settings::get('site_lang');
			}
		}

		define('CURRENT_LANGUAGE', $site_lang);

		$langs = $this->config->item('supported_languages');

		$pyro['lang'] = $langs[CURRENT_LANGUAGE];
		$pyro['lang']['code'] = CURRENT_LANGUAGE;

		// Set php locale time
		if (isset($langs[CURRENT_LANGUAGE]['codes']) && sizeof($locale = (array) $langs[CURRENT_LANGUAGE]['codes']) > 1)
		{
			array_unshift($locale, LC_TIME);
			call_user_func_array('setlocale', $locale);
			unset($locale);
		}

		// Reload languages
		if (AUTO_LANGUAGE !== CURRENT_LANGUAGE)
		{
			$this->config->set_item('language', $langs[CURRENT_LANGUAGE]['folder']);
			$this->lang->is_loaded = array();
			$this->lang->load(array('errors', 'main', 'users/user', 'settings/settings'));
		}
		else
		{
			$this->lang->load(array('main', 'users/user'));
		}

		$this->load->library(array('events', 'users/ion_auth'));

		// Use this to define hooks with a nicer syntax
		$this->hooks = & $GLOBALS['EXT'];

		// Create a hook point with access to instance but before custom code
		$this->hooks->_call_hook('post_core_controller_constructor');

		// override ion_auth config.php settings with pyro db settings
		$this->config->set_item('site_title', $this->settings->site_name, 'ion_auth');
		$this->config->set_item('admin_email', $this->settings->contact_email, 'ion_auth');
		$this->config->set_item('email_activation', $this->settings->activation_email, 'ion_auth');

		// Load the user model and get user data
		$this->load->library('users/ion_auth');

		$this->user = $this->ion_auth->get_user();

		// Work out module, controller and method and make them accessable throught the CI instance
		$this->module = $this->router->fetch_module();
		$this->controller = $this->router->fetch_class();
		$this->method = $this->router->fetch_method();

		// Loaded after $this->user is set so that data can be used everywhere
		$this->load->model(array(
			'permissions/permission_m',
			'modules/module_m',
			'pages/pages_m',
			'themes/themes_m'
		));

		// List available module permissions for this user
		$this->permissions = $this->user ? $this->permission_m->get_group($this->user->group_id) : array();

		// Get meta data for the module
		$this->template->module_details = $this->module_details = $this->module_m->get($this->module);

		// If the module is disabled, then show a 404.
		empty($this->module_details['enabled']) AND show_404();

		if ( ! $this->module_details['skip_xss'])
		{
			$_POST = $this->security->xss_clean($_POST);
		}

		$this->load->vars($pyro);

		// Load the admin theme so things like partials and assets are available everywhere
		$this->admin_theme = $this->themes_m->get_admin();
		// Load the current theme so we can set the assets right away
		$this->theme = $this->themes_m->get() or show_error('Theme could not be found, perhaps it is in the wrong location.');

		// make a constant as this is used in a lot of places
		define('ADMIN_THEME', $this->admin_theme->slug);

		// Asset library needs to know where the admin theme directory is
		$this->config->set_item('asset_dir', $this->admin_theme->path.'/');
		$this->config->set_item('asset_url', BASE_URL.$this->admin_theme->web_path.'/');
		// Set the front-end theme directory
		$this->config->set_item('theme_asset_dir', dirname($this->theme->path).'/');
		$this->config->set_item('theme_asset_url', BASE_URL.dirname($this->theme->web_path).'/');

		$this->benchmark->mark('my_controller_end');
	}
}

/**
 * Returns the CI object.
 *
 * Example: ci()->db->get('table');
 *
 * @staticvar	object	$ci
 * @return		object
 */
function ci()
{
	return get_instance();
}