<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Public_Controller
{
	function __construct()
	{
		parent::Public_Controller();
    $this->load->library('session');
		$this->load->library('user_lib');
		
		$this->load->model('users_m');
		$this->load->helper('user');
		
		$this->lang->load('user');
  }
	
  // AUTHORISATION SECTION -------------------------------------------------------------------------------------
	
  function login()
	{
		// Set the redirect page as soon as they get to login
		if(!$this->session->userdata('redirect_to')):
			$this->session->set_userdata('redirect_to', !empty($_SERVER['HTTP_REFFERER']) ? $_SERVER['HTTP_REFFERER'] : '');
		endif;
		
		// Call validation and set rules
		$this->load->library('validation');
    $rules['email'] = 'callback__check_login';
    $rules['password'] = '';
    $this->validation->set_rules($rules);
    $this->validation->set_fields();
        
    // If the validation worked, or the user is already logged in
    if ($this->validation->run() or $this->user_lib->logged_in()):
    	//$redirect_to = (($this->session->userdata('redirect_to')) ? $this->session->userdata('redirect_to') : '');
			//redirect($redirect_to, 'refresh');
			
			// TODO PJS Add login redirect - sends back to whatever page they were trying to get on
      redirect('');
    endif;
        
    $this->layout->create('login', $this->data);
	}
	
	function logout()
	{
		$this->user_lib->logout();
		$this->session->set_flashdata('success', $this->lang->line('user_logged_out'));
		redirect('');
	}
	
	function register()	
	{		
		$this->load->library('validation');
		
		$rules = array(
			'first_name'		=>	'required|alpha_dash',
			'last_name'			=>	($this->settings->item('require_lastname') ? 'required' : '').'alpha_dash',
			//'user_name'		=>	'required|alpha_numeric_dash|min_length[5]|max_length[20]',
			'password'			=>	'required|min_length[6]|max_length[20]',
			'confirm_password'	=>	'required|matches[password]',
			'email'				=>	'required|valid_email',
			'confirm_email'		=>	'required|valid_email|matches[email]'
		);
		
		$this->validation->set_rules($rules);
		$this->validation->set_fields();
		
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		
		if ($this->validation->run()):

			// Try and create the user
			if($id = $this->user_lib->create($email, $password)):
				
				// Now they have been created, does the admin want activation emails to be sent out?
				if($this->settings->item('activation_email') == 1):
					
					// They do? Ok, send out an email to the user
					if($this->user_lib->registered_email($this->user_lib->user_data)):			
						$this->session->set_flashdata(array('notice'=> $this->lang->line('user_activation_code_sent_notice')));	
						redirect('users/activate/'.$id);
					endif;
				
				// or should we let the admin manually activate them?
				else:
					$this->session->set_flashdata(array('notice'=> $this->lang->line('user_activation_by_admin_notice')));	
					redirect('');
				endif;
			
			// Can't create the user, show why
			else:
				$this->data->error_string = $this->lang->line($this->user_lib->error_code);
			endif;
			
		else:
			// Return the validation error message or user_lib error
			$this->data->error_string = $this->validation->error_string;
		endif;
		
		$this->layout->title($this->lang->line('user_register_title'));
		$this->layout->create('register', $this->data);		
	}

	function activate($id = 0, $code = NULL)
	{
		// Get info from email
		if($this->input->post('email')):
			$this->data->activate_user = $this->users_m->getUser(array('email'=>$this->input->post('email')));
			$id = $this->data->activate_user->id;
		else:
			$this->data->activate_user = $this->users_m->getUser(array('id'=>$id));
		endif;
		
		$code = ($this->input->post('activation_code')) ? $this->input->post('activation_code') : $code;
		
		// If user has supplied both bits of information
		if($id && $code):

			// Try and activate this user
			if($this->user_lib->activate($id, $code)):
	
				if($this->user_lib->activated_email($this->data->activate_user)):
					// Store data for activated page
					$this->session->set_flashdata('activated_email', $this->data->activate_user->email);
					
					redirect('users/activated');
				endif;
				
			else:
				$this->data->error_string = $this->lang->line($this->user_lib->error_code);
			endif;
			
		endif;
		
		$this->layout->title($this->lang->line('user_activate_account_title'));
		$this->layout->add_breadcrumb($this->lang->line('user_activate_label'), 'users/activate');
		$this->layout->create('activate', $this->data);		
	}
	
	function activated()
	{		
		$this->data->activated_email = ($email = $this->session->flashdata('activated_email')) ? $email : '';
		
		$this->layout->title($this->lang->line('user_activated_account_title'));
		$this->layout->create('activated', $this->data);
	}
	
	function reset_pass()
	{
		if($this->input->post('btnSubmit')):			
			
			$new_password = $this->user_lib->reset_password($this->input->post('first_name'), $this->input->post('last_name'), $this->input->post('email'));
			
			if($new_password):
				
				// Prepair data for emailing
				$this->data->full_name = $this->data->user->first_name . ( $this->data->user->last_name != '' ? ' '. $this->data->user->last_name : '' );
				$this->data->email = $this->input->post('email');
				$this->data->ip = $this->input->ip_address();
				$this->data->new_password = $new_password;
				
				$this->user_lib->reset_password_email($this->data, $new_password);

				redirect('users/reset_complete');
			else:
				// Set an error message explaining the reset failed
				$this->data->error_string = $this->lang->line($this->user_lib->error_code);
			endif;
			
		endif;
		
		$this->layout->title($this->lang->line('user_reset_password_title'));
		$this->layout->create('reset_pass', $this->data);
	}

	function reset_complete()
	{
		$this->layout->title($this->lang->line('user_password_reset_title'));
		$this->layout->create('reset_pass_complete', $this->data);
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
	
	// Testing function only, comment out when not using
	/*function temp_create($email = 'demo@example.com', $password = 'password', $first_name = 'Demo', $last_name = 'User') {
        $this->load->helper(array('string', 'date', 'security'));
        $salt = random_string('alnum', '5');
        $this->db->insert('users', array('email'=>$email,
                                         'password'=>dohash($password . $salt),
                                         'salt'=>$salt,
                                         'first_name'=>$first_name,
                                         'last_name'=>$last_name,
                                         'role'=>'admin',
                                         'is_active'=>1,
                                         'created_on'=>now()));
    }*/
}
?>
