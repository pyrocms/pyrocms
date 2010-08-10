<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Code here is run before ALL controllers
class MY_Controller extends Controller
{
	public $module;
	public $controller;
	public $method;

	function MY_Controller()
	{
		parent::Controller();
		$this->benchmark->mark('my_controller_start');

		// Use this to define hooks with a nicer syntax
		$this->hooks =& $GLOBALS['EXT'];

		// Create a hook point with access to instance but before custom code
		$this->hooks->_call_hook('post_core_controller_constructor');

        // Load the user model and get user data
        $this->load->model('users/users_m');
        $this->load->library('users/ion_auth');

		// Set the addons folder as a package
		$this->load->add_package_path(ADDONPATH);

        $this->config->set_item('site_title', $this->settings->item('site_name'), 'ion_auth');
        $this->config->set_item('admin_email', $this->settings->item('contact_email'), 'ion_auth');

		$this->data->user = $this->user = $this->ion_auth->get_user();

        // Work out module, controller and method and make them accessable throught the CI instance
        $this->module 				= $this->router->fetch_module();
        $this->controller			= $this->router->fetch_class();
        $this->method 				= $this->router->fetch_method();

        $this->data->module 		=& $this->module;
        $this->data->controller 	=& $this->controller;
        $this->data->method 		=& $this->method;

		// Loaded after $this->user is set so that data can be used everywhere
		$this->load->model(array(
			'permissions/permissions_m',
			'modules/modules_m',
			'pages/pages_m'
		));

		// Get meta data for the module
        $this->module_data 			= $this->modules_m->get($this->module);

		// If the module is disabled, then show a 404.
		$this->module_data['enabled'] == 1 or show_404();

		if(!$this->module_data['skip_xss'])
		{
			// TODO Re-enable this somehows
			//$_POST = $this->security->xss_clean($_POST);
		}

        // Make them available to all layout files
        $this->data->module_data	=& $this->module_data;

		// Simple Pyro variables
        $pyro['base_url']			= BASE_URL;
        $pyro['base_uri'] 			= BASE_URI;
        $pyro['application_uri'] 	= APPPATH_URI;
        $pyro['lang']				= CURRENT_LANGUAGE;

		// Mega Pyro arrays
        $pyro['user'] 	= (array) $this->user;
        $pyro['server'] = (array) $_SERVER;

        $this->load->vars($pyro);
        $this->load->vars('pyro', $pyro); // DEPRECATED - This is for backwards support only.

        $this->benchmark->mark('my_controller_end');
	}

	protected function is_ajax()
	{
		return ($this->input->server('HTTP_X_REQUESTED_WITH') == 'XMLHttpRequest') ? TRUE : FALSE;
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
    static $ci;
    isset($ci) OR $ci =& get_instance();
    return $ci;
}