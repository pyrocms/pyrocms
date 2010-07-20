<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User controller for the users module (frontend)
 * 
 * @author 		Phil Sturgeon - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Users module
 * @category	Modules
 */
class Users extends Public_Controller
{
	/**
	 * Array containing the validation rules
	 * @access private
	 * @var array
	 */
	private $validation_rules 	= array();
	
	/**
	 * Constructor method
	 *
	 * @access public
	 * @return void
	 */
	function __construct()
	{
		// Call the parent's constructor method
		parent::__construct();
		
		// Load the required classes
		$this->load->model('users_m');
		$this->load->helper('user');
		$this->lang->load('user');
		$this->load->library('form_validation');
	}

	/**
	 * Let's login, shall we?
	 * @access public
	 * @return void
	 */
	public function login()
	{
		// Get the user data
		$user_data = (object) array(
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password')
		);
		
		// Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'email',
				'label' => lang('user_email_label'),
				'rules' => 'required|trim|callback__check_login'
			),
			array(
				'field' => 'password',
				'label' => lang('user_password_label'),
				'rules' => 'required|min_length[6]|max_length[20]'
			),
		);

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);
		
		// Set the redirect page as soon as they get to login
		if(!$this->session->userdata('redirect_to'))
		{
			$uri = parse_url($this->input->server('HTTP_REFERER'), PHP_URL_PATH);

			// If iwe aren't being redirected from the userl ogin page
			$root_uri = BASE_URI == '/' ? '' : BASE_URI;
			strpos($uri, '/users/login') !== FALSE || $this->session->set_userdata('redirect_to', str_replace($root_uri, '', $uri));
		}
		
	    // If the validation worked, or the user is already logged in
	    if ($this->form_validation->run() or $this->ion_auth->logged_in())
	    {
	    	$redirect_to = $this->session->userdata('redirect_to')
				? $this->session->userdata('redirect_to')
				: ''; // Home

			$this->session->unset_userdata('redirect_to');

			// Call post login hook
			$this->hooks->_call_hook('post_user_login');

			// Redirect the user
			redirect($redirect_to);
	    }

		// Render the view
		$this->data->user_data =& $user_data;
	    $this->template->build('login', $this->data);
	}

	/**
	 * Method to log the user out of the system
	 * @access public
	 * @return void
	 */
	public function logout()
	{
		$this->ion_auth->logout();
		$this->session->set_flashdata('success', lang('user_logged_out'));
		redirect('');
	}

	/**
	 * Method to register a new user
	 * @access public
	 * @return void
	 */
	public function register()
	{
		// Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'first_name',
				'label' => lang('user_first_name'),
				'rules' => 'required|alpha_dash'
			),
			array(
				'field' => 'last_name',
				'label' => lang('user_last_name'),
				'rules' => ($this->settings->item('require_lastname') ? 'required|' : '').'surname'
			),
			array(
				'field' => 'password',
				'label' => lang('user_password'),
				'rules' => 'required|min_length[6]|max_length[20]'
			),
			array(
				'field' => 'confirm_password',
				'label' => lang('user_confirm_password'),
				'rules' => 'required|matches[password]'
			),
			array(
				'field' => 'email',
				'label' => lang('user_email'),
				'rules' => 'required|valid_email|callback__email_check'
			),
			array(
				'field' => 'confirm_email',
				'label' => lang('user_confirm_email'),
				'rules' => 'required|valid_email|matches[email]'
			),
			array(
				'field' => 'username',
				'label' => lang('user_username'),
				'rules' => 'required|alphanumeric|maxlength[20]|callback__username_check'
			),
			array(
				'field' => 'display_name',
				'label' => lang('user_display_name'),
				'rules' => 'required|alphanumeric|maxlength[50]'
			),
		);

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);

		$email 				= $this->input->post('email');
		$password 			= $this->input->post('password');
		$username 			= $this->input->post('username');
		$user_data_array 	= array(
			'first_name' => $this->input->post('first_name'),
			'last_name'  => $this->input->post('last_name'),
			'display_name'  => $this->input->post('display_name'),
		);
		
		// Convert the array to an object
		$user_data						= new stdClass();
		$user_data->first_name 			= $user_data_array['first_name'];
		$user_data->last_name			= $user_data_array['last_name'];
		$user_data->display_name		= $user_data_array['display_name'];
		$user_data->username			= $username;
		$user_data->email				= $email;
		$user_data->password 			= $password;
		$user_data->confirm_email 		= $this->input->post('confirm_email');

		if ($this->form_validation->run())
		{
			// Try to create the user
			if($id = $this->ion_auth->register($username, $password, $email, $user_data_array))
			{
				$this->session->set_flashdata(array('notice'=> $this->ion_auth->messages()));
				redirect('users/activate/'.$id);
			}

			// Can't create the user, show why
			else
			{
				$this->data->error_string = $this->ion_auth->errors();
			}
		}

		else
		{
			// Return the validation error
			$this->data->error_string = $this->form_validation->error_string();
		}

		$this->data->user_data =& $user_data;
		$this->template->title( lang('user_register_title') );
		$this->template->build('register', $this->data);
	}

	/**
	 * Activate a user
	 * @param int $id The ID of the user
	 * @param str $code The activation code
	 * @return void
	 */
	public function activate($id = 0, $code = NULL)
	{
		// Get info from email
		if($this->input->post('email'))
		{
			$this->data->activate_user = $this->ion_auth->get_user_by_email($this->input->post('email'));
			$id = $this->data->activate_user->id;
		}

		else
		{
			$this->data->activate_user = $this->ion_auth->get_user($id);
		}

		$code = ($this->input->post('activation_code')) ? $this->input->post('activation_code') : $code;

		// If user has supplied both bits of information
		if($id && $code) {
			// Try to activate this user
			if($this->ion_auth->activate($id, $code)) {

				$this->session->set_flashdata('activated_email', $this->ion_auth->messages());

				// Call post activation hook
				$this->hooks->_call_hook('post_user_activation');

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

	/**
	 * Activated page
	 * @access public
	 * @return void
	 */
	public function activated()
	{
		//if they are logged in redirect them to the home page
		if ($this->ion_auth->logged_in())
		{
			redirect(base_url());
		}
		
		$this->data->activated_email = ($email = $this->session->flashdata('activated_email')) ? $email : '';

		$this->template->title($this->lang->line('user_activated_account_title'));
		$this->template->build('activated', $this->data);
	}

	/**
	 * Reset a user's password
	 * @access public
	 * @return void
	 */
	public function reset_pass($code = '')
	{
		if($this->input->post('btnSubmit'))
		{
			$new_password = $this->ion_auth->forgotten_password($this->input->post('email'));

			if($new_password)
			{
				redirect('users/reset_complete');
			}

			else
			{
				// Set an error message explaining the reset failed
				$this->data->error_string = $this->ion_auth->errors();
			}
		}

		$this->template->title($this->lang->line('user_reset_password_title'));
		$this->template->build('reset_pass', $this->data);
	}

	/**
	 * Password reset is finished
	 * @access public
	 * @return void
	 */
	public function reset_complete()
	{
		$this->template->title($this->lang->line('user_password_reset_title'));
		$this->template->build('reset_pass_complete', $this->data);
	}

	/**
	 * Callback method used during login
	 * @access public
	 * @param str $email The Email address 
	 * @return bool
	 */
	public function _check_login($email)
	{
		$remember = FALSE;
		if ($this->input->post('remember') == 1) 
		{
			$remember = TRUE;	
		}
		
		if ($this->ion_auth->login($email, $this->input->post('password'), $remember))
		{
			return TRUE;
		}
		
		$this->form_validation->set_message('_check_login', $this->ion_auth->errors());
		return FALSE;
	}
	

	
	/**
	 * Username check
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function _username_check($username)
	{
	    if ($this->ion_auth->username_check($username))
	    {
	        $this->form_validation->set_message('_username_check', $this->lang->line('user_error_username'));
	        return FALSE;
	    }
	    else
	    {
	        return TRUE;
	    }
	}
	
	/**
	 * Email check
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function _email_check($email)
	{
	    if ($this->ion_auth->email_check($email))
	    {
	        $this->form_validation->set_message('_email_check', $this->lang->line('user_error_email'));
	        return FALSE;
	    }
	    else
	    {
	        return TRUE;
	    }
	}
}