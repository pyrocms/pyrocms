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
		
		// Hook point
		$GLOBALS['EXT']->_call_hook('post_core_controller_constructor');
		
        // Load the user model and get user data
        $this->load->model('users/users_m');
        $this->load->library('users/user_lib');
        
        $this->data->user =& $this->user_lib->user_data;
        
        // Work out module, controller and method and make them accessable throught the CI instance
        $this->module 				= $this->router->fetch_module();
        $this->controller			= $this->router->fetch_class();
        $this->method 				= $this->router->fetch_method();
		
		// Get meta data for the module
        $this->module_data 			= $this->modules_m->get($this->module);
        
        // Make them available to all layout files
        $this->data->module_data	=& $this->module_data;
        
        $this->data->module 		=& $this->module;
        $this->data->controller 	=& $this->controller;
        $this->data->method 		=& $this->method;
        
        $global['base_url']			= BASE_URL;
        $global['base_uri'] 		= BASE_URI;
        $global['application_uri'] 	= APPPATH_URI;
        $global['current_language'] = CURRENT_LANGUAGE;
        
        $this->load->vars('global', $global);
        
        $this->benchmark->mark('my_controller_end');
	}
}