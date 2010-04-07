<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Public_Controller
{
	function __construct()
	{
		parent::Public_Controller();

		$this->load->library('ion_auth');
		
		$this->load->model('users_m');
		$this->load->helper('user');
		
		$this->lang->load('user');
	}
	
	// AUTHORISATION SECTION -------------------------------------------------------------------------------------
	
	function login()
	{
		// Set the redirect page as soon as they get to login
		if(!$this->session->userdata('redirect_to')) {
			$this->session->set_userdata('redirect_to', $this->input->server('HTTP_REFFERER'));
		}
		
		// Call validation and set rules
		$this->load->library('validation');
	    $rules['email'] = 'callback__check_login';
	    $rules['password'] = '';
	    $this->validation->set_rules($rules);
	    $this->validation->set_fields();
	        
	    // If the validation worked, or the user is already logged in
	    if ($this->validation->run() or $this->ion_auth->logged_in())
	    {
	    	//$redirect_to = (($this->session->userdata('redirect_to')) ? $this->session->userdata('redirect_to') : '');
			//redirect($redirect_to, 'refresh');
				
			// TODO PJS Add login redirect - sends back to whatever page they were trying to get on
	        redirect('');
	    }
	        
	    $this->template->build('login', $this->data);
	}
	
	function logout()
	{
		$this->ion_auth->logout();
		$this->session->set_flashdata('success', $this->lang->line('user_logged_out'));
		redirect('');
	}
	
	function register()	
	{		
		$this->load->library('validation');
		
		$rules = array(
			'first_name'		=>	'required|alpha_dash',
			'last_name'			=>	($this->settings->item('require_lastname') ? 'required' : '').'alpha_dash',
			'password'			=>	'required|min_length[6]|max_length[20]',
			'confirm_password'	=>	'required|matches[password]',
			'email'				=>	'required|valid_email',
			'confirm_email'		=>	'required|valid_email|matches[email]'
		);
		
		$this->validation->set_rules($rules);
		$this->validation->set_fields();
		
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$user_data = array('first_name' => $this->input->post('first_name'),
						   'last_name'  => $this->input->post('last_name'),
						  );
		
		if ($this->validation->run()) {
			// Try to create the user
			if($id = $this->ion_auth->register($email, $password, $email, $user_data)) {
				$this->session->set_flashdata(array('notice'=> $this->ion_auth->messages()));	
				redirect('users/activate/'.$id);			
			}
			else { // Can't create the user, show why
				$this->data->error_string = $this->ion_auth->errors();
			}
		}
		else {
			// Return the validation error message or user_lib error
			$this->data->error_string = $this->validation->error_string;
		}
		
		$this->template->title($this->lang->line('user_register_title'));
		$this->template->build('register', $this->data);		
	}

	function activate($id = 0, $code = NULL)
	{
		// Get info from email
		if($this->input->post('email')):
			$this->data->activate_user = $this->ion_auth->get_user_by_email($this->input->post('email'));
			$id = $this->data->activate_user->id;
		else:
			$this->data->activate_user = $this->ion_auth->get_user($id);
		endif;
		
		$code = ($this->input->post('activation_code')) ? $this->input->post('activation_code') : $code;
		
		// If user has supplied both bits of information
		if($id && $code) {
			// Try to activate this user
			if($this->ion_auth->activate($id, $code)) {
	
				$this->session->set_flashdata('activated_email', $this->ion_auth->messages());
				redirect('users/activated');
			}	
			else {
				$this->data->error_string = $this->ion_auth->errors();
			}
		}
		
		$this->template->title($this->lang->line('user_activate_account_title'));
		$this->template->set_breadcrumb($this->lang->line('user_activate_label'), 'users/activate');
		$this->template->build('activate', $this->data);		
	}
	
	function activated()
	{		
		$this->data->activated_email = ($email = $this->session->flashdata('activated_email')) ? $email : '';
		
		$this->template->title($this->lang->line('user_activated_account_title'));
		$this->template->build('activated', $this->data);
	}
	
	function reset_pass()
	{
		if($this->input->post('btnSubmit')) {	
			$new_password = $this->ion_auth->forgotten_password($this->input->post('email'));
			
			if($new_password) {
				redirect('users/reset_complete');
			}
			else {
				// Set an error message explaining the reset failed
				$this->data->error_string = $this->ion_auth->errors();
			}
		}
		
		$this->template->title($this->lang->line('user_reset_password_title'));
		$this->template->build('reset_pass', $this->data);
	}

	function reset_complete()
	{
		$this->template->title($this->lang->line('user_password_reset_title'));
		$this->template->build('reset_pass_complete', $this->data);
	}

	// Callback From: login()
  function _check_login($email)
	{		
    if ($this->ion_auth->login($email, $this->input->post('password')))
    {
    	return TRUE;
    }
    else
    {
    	$this->validation->set_message('_check_login', $this->ion_auth->errors());
        return FALSE;
    }
  }
}
?>
