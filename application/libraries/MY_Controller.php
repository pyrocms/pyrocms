<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Code here is run before ALL controllers
class MY_Controller extends Controller
{
	var $module;
	var $controller;
	var $method;
	
	function MY_Controller()
	{
		parent::Controller();
		
		$this->benchmark->mark('my_controller_start');

		$this->hooks =& $GLOBALS['EXT'];

		// Hook point
		$this->hooks->_call_hook('post_core_controller_constructor');
		
        // Load the user model and get user data
        $this->load->model('users/users_m');
        $this->load->library('users/ion_auth');

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
			$_POST = $this->input->xss_clean($_POST);
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
        
        $this->load->vars('pyro', $pyro); 
        
        $this->benchmark->mark('my_controller_end');
	}
}