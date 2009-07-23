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
		
        // Make sure we have the user module
        if( ! is_module('users') )
        {
        	show_error('The user module is missing.');
        }
        
        else
        {
	        // Load the user model and get user data
	        $this->load->module_model('users', 'users_m');
	        $this->load->module_library('users', 'user_lib');
	        
	        $this->data->user =& $this->user_lib->user_data;
        }
        
        // Work out module, controller and method and make them accessable throught the CI instance
        $this->module 				= str_replace(array('modules/', '/'), '', $this->matchbox->fetch_module());
        $this->controller			= strtolower(get_class($this));
        $s 							= $this->uri->rsegment_array();
        $n 							= array_search($this->controller, $s);
        $this->method 				= $this->uri->rsegment($n+1);
		
		// Get meta data for the module
        $this->module_data 			= $this->modules_m->getModule($this->module);
        
        // Make them available to all layout files
        $this->data->module_data	=& $this->module_data;
        
        $this->data->module 		=& $this->module;
        $this->data->controller 	=& $this->controller;
        $this->data->method 		=& $this->method;
	}
}

include(APPPATH . 'libraries/Public_Controller'.EXT);
include(APPPATH . 'libraries/Admin_Controller'.EXT);