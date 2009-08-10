<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	function __construct()
	{
  		parent::Admin_Controller();
		$this->load->module_library('users', 'user_lib');
		$this->load->module_language('users', 'user');
		$this->load->module_helper('users', 'user');
 	}

 	// Admin: Control Panel
 	function index()
	{
		$this->load->model('modules_m');
 		$this->data->modules = $this->modules_m->getModules();
			  
		$this->layout->create('admin/cpanel', $this->data);
	}
     
	// Admin: Log in
	function login()
	{
		// Call validation and set rules
		$this->load->library('validation');
	    $rules['email'] = 'required|callback__check_login';
	    $rules['password'] = 'required';
	    $this->validation->set_rules($rules);
	    $this->validation->set_fields();
	        
	    // If the validation worked, or the user is already logged in
	    if ($this->validation->run() or $this->user_lib->logged_in())
	    {
	    	redirect('admin');
		}
				
	    $this->layout->wrapper(FALSE);
	    $this->layout->create('admin/login', $this->data);		
	}
	
	function logout()
	{
		$this->user_lib->logout();
		redirect('admin/login');
	}	
	
	// Callback From: login()
	function _check_login($email)
	{		
   		if ($this->user_lib->login($email, $this->input->post('password')))
	   	{
	     	return TRUE;
	    }
	    else
	    {
	   		$this->validation->set_message('_check_login', $this->lang->line($this->user_lib->error_code));
	    	return FALSE;
	    }
	}    
}
?>