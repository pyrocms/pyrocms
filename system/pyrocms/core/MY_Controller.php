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

		// Migrate DB to the latest version
		$this->load->library('migrations');
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

		// Use this to define hooks with a nicer syntax
		$this->hooks = & $GLOBALS['EXT'];

		// Create a hook point with access to instance but before custom code
		$this->hooks->_call_hook('post_core_controller_constructor');

		$this->config->set_item('site_title', $this->settings->site_name, 'ion_auth');
		$this->config->set_item('admin_email', $this->settings->contact_email, 'ion_auth');

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
			'pages/pages_m'
		));

		// List available module permissions for this user
		$this->permissions = $this->user ? $this->permission_m->get_group($this->user->group_id) : array();

		// Get meta data for the module
		$this->template->module_details = $this->module_details = $this->module_m->get($this->module);

		// If the module is disabled, then show a 404.
		empty($this->module_details['enabled']) AND show_404();

		if (!$this->module_details['skip_xss'])
		{
			$_POST = $this->security->xss_clean($_POST);
		}

		$langs = $this->config->item('supported_languages');

		$pyro['lang'] = $langs[CURRENT_LANGUAGE];
		$pyro['lang']['code'] = CURRENT_LANGUAGE;

		$this->load->vars($pyro);

		$this->benchmark->mark('my_controller_end');
	}

	protected function is_ajax()
	{
		return $this->input->server('HTTP_X_REQUESTED_WITH') == 'XMLHttpRequest';
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
