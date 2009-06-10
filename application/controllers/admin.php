<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	function __construct()
	{
  	parent::Admin_Controller();
		$this->load->module_library('users', 'user_lib');
		$this->load->module_language('users', 'user');
		$this->load->module_helper('users', 'user');
		
		// start adding the language handling
		$this->lang->load('admin');
		// end adding the language handling
  }

    // Admin: Control Panel
    function index()
		{
			$this->load->model('modules_m');
      $this->data->modules = $this->modules_m->getModules();
			
			// start adding the language handling
				$this->lang->load('modules');
				
				// layout
				$this->data->confirmLabel = $this->lang->line('confirm');
				$this->data->noLabel = $this->lang->line('yes');
				$this->data->yesLabel = $this->lang->line('no');
				
				// cpanel			
				$this->data->cpTitle = $this->lang->line('cp_title');
				$this->data->cpWelcome = sprintf($this->lang->line('cp_welcome'), $this->settings->item('site_name'));
				$this->data->modulesTitle = $this->lang->line('mod_title');
				$this->data->nameLabel = $this->lang->line('name_label');
				$this->data->descLabel = $this->lang->line('desc_label');
				$this->data->versionLabel = $this->lang->line('version_label');
				
				// result messages
				$this->data->closeMessage = $this->lang->line('close_message');
				$this->data->generalErrorLabel = $this->lang->line('general_error_label');
				$this->data->requiredErrorLabel = $this->lang->line('required_error_label');
				$this->data->noteLabel = $this->lang->line('note_label');
				$this->data->successLabel = $this->lang->line('success_label');
				
				// breadcrumbs
				$this->data->breadcrumbHomeTitle = $this->lang->line('breadcrumb_home_title');
								
				// header
				$this->data->cpToHome = $this->lang->line('cp_to_home');
				$this->data->cpViewFrontend = $this->lang->line('cp_view_frontend');
				$this->data->cpLoggedInAs = sprintf($this->lang->line('cp_logged_in_as'), $this->data->user->first_name.' '.$this->data->user->last_name);
				$this->data->cpLogout = sprintf($this->lang->line('cp_logout'), anchor('edit-profile', $this->lang->line('cp_edit_profile_label')), anchor('admin/logout', $this->lang->line('cp_logout_label')));
				
				// inner_header
					// seems not required yet
				
				// table_buttons
				$this->data->saveLabel = $this->lang->line('save_label');
				$this->data->cancelLabel = $this->lang->line('cancel_label');
				$this->data->deleteLabel = $this->lang->line('delete_label');
				$this->data->activateLabel = $this->lang->line('activate_label');
				$this->data->publishLabel = $this->lang->line('publish_label');
				$this->data->uploadLabel = $this->lang->line('upload_label');

				//$this->data-> = $this->lang->line('');
				
      
			$this->layout->title($this->lang->line('cp_title'));
			// end adding the language handling
			  
    	$this->layout->create('admin/cpanel', $this->data);
    }
     
    // Admin: Log in
    function login()
	{
		// Call validation and set rules
		$this->load->library('validation');
        $rules['email'] = 'callback__check_login';
        $rules['password'] = '';
        $this->validation->set_rules($rules);
        $this->validation->set_fields();
        
        // If the validation worked, or the user is already logged in
        if ($this->validation->run() or $this->user_lib->logged_in()):
        	redirect('admin');
        endif;
				
				// start adding the language handling
				$this->data->loginTitle = $this->lang->line('login_title');
				$this->data->loginError = $this->lang->line('login_error');
				$this->data->closeMessage = $this->lang->line('close_message');
				$this->data->forgetPasswordLabel = $this->lang->line('forget_password_label');
				$this->data->emailLabel = $this->lang->line('email_label');
				$this->data->passwordLabel = $this->lang->line('password_label');
				$this->data->loginLabel = $this->lang->line('login_label');
				// end adding the language handling
        
        $this->layout->wrap_mode(FALSE);
        $this->layout->create('admin/login', $this->data);
		
	}
	
	function logout() {
		$this->user_lib->logout();
		redirect('admin/login');
	}
	
	
	// Callback From: login()
    function _check_login($email) {
		
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