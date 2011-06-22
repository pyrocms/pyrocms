<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*
* Added Awesomeness: Phil Sturgeon
*
* Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
*
* Created:  10.01.2009
*
* Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
* Original Author name has been kept but that does not mean that the method has not been modified.
*
* Requirements: PHP5 or above
*
*/

class Ion_auth
{
	/**
	 * CodeIgniter global
	 *
	 * @var string
	 **/
	protected $ci;

	/**
	 * account status ('not_activated', etc ...)
	 *
	 * @var string
	 **/
	protected $status;

	/**
	 * message (uses lang file)
	 *
	 * @var string
	 **/
	protected $messages;

	/**
	 * error message (uses lang file)
	 *
	 * @var string
	 **/
	protected $errors = array();

	/**
	 * error start delimiter
	 *
	 * @var string
	 **/
	protected $error_start_delimiter;

	/**
	 * error end delimiter
	 *
	 * @var string
	 **/
	protected $error_end_delimiter;

	/**
	 * extra where
	 *
	 * @var array
	 **/
	public $_extra_where = array();

	/**
	 * extra set
	 *
	 * @var array
	 **/
	public $_extra_set = array();

	/**
	 * __construct
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->config('users/ion_auth', TRUE);
		$this->ci->load->library('email');
		$this->ci->load->library('session');
		$this->ci->lang->load('users/ion_auth');
		$this->ci->load->model('users/ion_auth_model');
		$this->ci->load->helper('cookie');

		$this->messages = array();
		$this->errors = array();
		$this->message_start_delimiter = $this->ci->config->item('message_start_delimiter', 'ion_auth');
		$this->message_end_delimiter   = $this->ci->config->item('message_end_delimiter', 'ion_auth');
		$this->error_start_delimiter   = $this->ci->config->item('error_start_delimiter', 'ion_auth');
		$this->error_end_delimiter     = $this->ci->config->item('error_end_delimiter', 'ion_auth');

		//auto-login the user if they are remembered
		if (!$this->logged_in() && get_cookie('identity') && get_cookie('remember_code'))
		{
			$this->ci->ion_auth = $this;
			$this->ci->ion_auth_model->login_remembered_user();
		}
	}

	/**
	 * __call
	 *
	 * Acts as a simple way to call model methods without loads of stupid alias'
	 *
	 **/
	public function __call($method, $arguments)
	{
		if( !method_exists( $this->ci->ion_auth_model, $method) )
		{
			throw new Exception('Undefined method Ion_auth::' . $method . '() called');
		}

		return call_user_func_array( array($this->ci->ion_auth_model, $method), $arguments);
	}

	/**
	 * Activate user.
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function activate($id, $code=false)
	{
		if ($this->ci->ion_auth_model->activate($id, $code))
		{
			$this->set_message('activate_successful');
			return TRUE;
		}

		$this->set_error('activate_unsuccessful');
		return FALSE;
	}

	/**
	 * Deactivate user.
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function deactivate($id)
	{
		if ($this->ci->ion_auth_model->deactivate($id))
		{
			$this->set_message('deactivate_successful');
			return TRUE;
		}

		$this->set_error('deactivate_unsuccessful');
		return FALSE;
	}

	/**
	 * Change password.
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function change_password($identity, $old, $new)
	{
	if ($this->ci->ion_auth_model->change_password($identity, $old, $new))
	{
		$this->set_message('password_change_successful');
		return TRUE;
	}

		$this->set_error('password_change_unsuccessful');
	return FALSE;
	}

	/**
	 * forgotten password feature
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function forgotten_password($identity)    //changed $email to $identity
	{
		if ( $this->ci->ion_auth_model->forgotten_password($identity) )   //changed
		{
			// Get user information
			$user = $this->get_user_by_identity($identity);  //changed to get_user_by_identity from email

			$data = array(
				'identity'		=> $user->{$this->ci->config->item('identity', 'ion_auth')},
				'forgotten_password_code' => $user->forgotten_password_code
			);

			$message = $this->ci->load->view($this->ci->config->item('email_templates', 'ion_auth').$this->ci->config->item('email_forgot_password', 'ion_auth'), $data, true);
			$this->ci->email->clear();
			$config['mailtype'] = "html";
			$this->ci->email->initialize($config);
			$this->ci->email->set_newline("\r\n");
			$this->ci->email->from($this->ci->settings->get('server_email'), $this->ci->settings->get('site_name'));
			$this->ci->email->reply_to($this->ci->settings->get('contact_email'));
			$this->ci->email->to($user->email);
			$this->ci->email->subject($this->ci->settings->get('site_name') . ' - Forgotten Password Verification');
			$this->ci->email->message($message);

			if ($this->ci->email->send())
			{
				$this->set_message('forgot_password_successful');
				return TRUE;
			}
			else
			{
				$this->set_error('forgot_password_unsuccessful');
				return FALSE;
			}
		}
		else
		{
			$this->set_error('forgot_password_unsuccessful');
			return FALSE;
		}
	}

	/**
	 * forgotten_password_complete
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function forgotten_password_complete($code)
	{
	    $identity     = $this->ci->config->item('identity', 'ion_auth');
	    $profile      = $this->ci->ion_auth_model->profile($code, true); //pass the code to profile

	    if (!is_object($profile))
	    {
		$this->set_error('password_change_unsuccessful');
		return FALSE;
	    }

		$new_password = $this->ci->ion_auth_model->forgotten_password_complete($code, $profile->salt);

		if ($new_password)
		{
			$data = array(
				'identity'     => $profile->{$identity},
				'new_password' => $new_password
			);

			$message = $this->ci->load->view($this->ci->config->item('email_templates', 'ion_auth').$this->ci->config->item('email_forgot_password_complete', 'ion_auth'), $data, true);

			$this->ci->email->clear();
			$config['mailtype'] = "html";
			$this->ci->email->initialize($config);
			$this->ci->email->set_newline("\r\n");
			$this->ci->email->from($this->ci->settings->get('server_email'), $this->ci->settings->get('site_name'));
			$this->ci->email->reply_to($this->ci->settings->get('contact_email'));
			$this->ci->email->to($profile->email);
			$this->ci->email->subject($this->ci->settings->get('site_name') . ' - New Password');
			$this->ci->email->message($message);

			if ($this->ci->email->send())
			{
				$this->set_message('password_change_successful');
				return TRUE;
			}
			else
			{
				$this->set_error('password_change_unsuccessful');
				return FALSE;
			}
		}

		$this->set_error('password_change_unsuccessful');
		return FALSE;
	}

	/**
	 * register
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function register($username, $password, $email, $additional_data, $group_name = false) //need to test email activation
	{
	    $email_activation = $this->ci->config->item('email_activation', 'ion_auth');

		if ( ! $email_activation)
		{
			$id = $this->ci->ion_auth_model->register($username, $password, $email, $additional_data, $group_name);
			if ($id !== FALSE)
			{
				$this->set_message('account_creation_successful');
				return $id;
			}
			else
			{
				$this->set_error('account_creation_unsuccessful');
				return FALSE;
			}
		}
		else
		{
			$id = $this->ci->ion_auth_model->register($username, $password, $email, $additional_data, $group_name);

			if ( ! $id)
			{
				$this->set_error('account_creation_unsuccessful');
				return FALSE;
			}

			$deactivate = $this->ci->ion_auth_model->deactivate($id);

			if ( ! $deactivate)
			{
				$this->set_error('deactivate_unsuccessful');
				return FALSE;
			}

			$activation_code = $this->ci->ion_auth_model->activation_code;
			$identity        = $this->ci->config->item('identity', 'ion_auth');
		$user            = $this->ci->ion_auth_model->get_user($id)->row();

			$data = array(
				'identity'   => $user->{$identity},
				 'id'         => $user->id,
			 'email'      => $email,
			 'activation' => $activation_code,
			);

			$message = $this->ci->load->view($this->ci->config->item('email_templates', 'ion_auth').$this->ci->config->item('email_activate', 'ion_auth'), $data, true);

			$this->ci->email->clear();
			$config['mailtype'] = "html";
			$this->ci->email->initialize($config);
			$this->ci->email->set_newline("\r\n");
			$this->ci->email->from($this->ci->settings->get('server_email'), $this->ci->settings->get('site_name'));
			$this->ci->email->reply_to($this->ci->settings->get('contact_email'));
			$this->ci->email->to($email);
			$this->ci->email->subject($this->ci->settings->get('site_name') . ' - Account Activation');
			$this->ci->email->message($message);

			if ($this->ci->email->send() == TRUE)
			{
				$this->set_message('activation_email_successful');
				return $id;
			}

			$this->set_error('activation_email_unsuccessful');
			return FALSE;
		}
	}

	/**
	 * login
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function login($identity, $password, $remember=false)
	{
		if ($this->ci->ion_auth_model->login($identity, $password, $remember))
		{
			$this->set_message('login_successful');
			return TRUE;
		}

		$this->set_error('login_unsuccessful');
		return FALSE;
	}

	/**
	 * logout
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function logout()
	{
	    $identity = $this->ci->config->item('identity', 'ion_auth');
	    $this->ci->session->unset_userdata($identity);
	    $this->ci->session->unset_userdata('group');
	    $this->ci->session->unset_userdata('id');
	    $this->ci->session->unset_userdata('user_id');

	    //delete the remember me cookies if they exist
	    if (get_cookie('identity'))
	    {
		delete_cookie('identity');
	    }
		if (get_cookie('remember_code'))
	    {
		delete_cookie('remember_code');
	    }

		$this->ci->session->sess_destroy();

		$this->set_message('logout_successful');
		return TRUE;
	}

	/**
	 * logged_in
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function logged_in()
	{
		$identity = $this->ci->config->item('identity', 'ion_auth');

		return (bool) $this->ci->session->userdata($identity);
	}

	/**
	 * is_admin
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function is_admin()
	{
	    $admin_group = $this->ci->config->item('admin_group', 'ion_auth');
	    $user_group  = $this->ci->session->userdata('group');

	    return $user_group == $admin_group;
	}

	/**
	 * is_group
	 *
	 * @return bool
	 * @author Phil Sturgeon
	 **/
	public function is_group($check_group)
	{
	    $user_group = $this->ci->session->userdata('group');

	    if(is_array($check_group))
	    {
		return in_array($user_group, $check_group);
	    }

	    return $user_group == $check_group;
	}

	/**
	 * Profile
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function profile()
	{
	    $session  = $this->ci->config->item('identity', 'ion_auth');
	    $identity = $this->ci->session->userdata($session);

	    return $this->ci->ion_auth_model->profile($identity);
	}

	/**
	 * Get Users
	 *
	 * @return object Users
	 * @author Ben Edmunds
	 **/
	public function get_users($group_name=false, $limit=NULL, $offset=NULL)
	{
		return $this->ci->ion_auth_model->get_users($group_name, $limit, $offset)->result();
	}

	/**
	 * Get Number of Users
	 *
	 * @return int Number of Users
	 * @author Sven Lueckenbach
	 **/
	public function get_users_count($group_name=false)
	{
		return $this->ci->ion_auth_model->get_users_count($group_name);
	}

	/**
	 * Get Users Array
	 *
	 * @return array Users
	 * @author Ben Edmunds
	 **/
	public function get_users_array($group_name=false, $limit=NULL, $offset=NULL)
	{
		return $this->ci->ion_auth_model->get_users($group_name, $limit, $offset)->result_array();
	}

	/**
	 * Get Newest Users
	 *
	 * @return object Users
	 * @author Ben Edmunds
	 **/
	public function get_newest_users($limit = 10)
	{
	    return $this->ci->ion_auth_model->get_newest_users($limit)->result();
	}

	/**
	 * Get Newest Users Array
	 *
	 * @return object Users
	 * @author Ben Edmunds
	 **/
	public function get_newest_users_array($limit = 10)
	{
	    return $this->ci->ion_auth_model->get_newest_users($limit)->result_array();
	}

	/**
	 * Get Active Users
	 *
	 * @return object Users
	 * @author Ben Edmunds
	 **/
	public function get_active_users($group_name = false)
	{
	    return $this->ci->ion_auth_model->get_active_users($group_name)->result();
	}

	/**
	 * Get Active Users Array
	 *
	 * @return object Users
	 * @author Ben Edmunds
	 **/
	public function get_active_users_array($group_name = false)
	{
	    return $this->ci->ion_auth_model->get_active_users($group_name)->result_array();
	}

	/**
	 * Get In-Active Users
	 *
	 * @return object Users
	 * @author Ben Edmunds
	 **/
	public function get_inactive_users($group_name = false)
	{
	    return $this->ci->ion_auth_model->get_inactive_users($group_name)->result();
	}

	/**
	 * Get In-Active Users Array
	 *
	 * @return object Users
	 * @author Ben Edmunds
	 **/
	public function get_inactive_users_array($group_name = false)
	{
	    return $this->ci->ion_auth_model->get_inactive_users($group_name)->result_array();
	}

	/**
	 * Get User
	 *
	 * @return object User
	 * @author Ben Edmunds
	 **/
	public function get_user($id=false)
	{
	    return $this->ci->ion_auth_model->get_user($id)->row();
	}

	/**
	 * Get User by Email
	 *
	 * @return object User
	 * @author Ben Edmunds
	 **/
	public function get_user_by_email($email)
	{
	    return $this->ci->ion_auth_model->get_user_by_email($email)->row();
	}

	/**
	 * Get Users by Email
	 *
	 * @return object Users
	 * @author Ben Edmunds
	 **/
	public function get_users_by_email($email)
	{
		return $this->ci->ion_auth_model->get_users_by_email($email)->result();
	}

	/**
	 * Get User by Username
	 *
	 * @return object User
	 * @author Kevin Smith
	 **/
	public function get_user_by_username($username)
	{
		return $this->ci->ion_auth_model->get_user_by_username($username)->row();
	}

	/**
	 * Get Users by Username
	 *
	 * @return object Users
	 * @author Kevin Smith
	 **/
	public function get_users_by_username($username)
	{
		return $this->ci->ion_auth_model->get_users_by_username($username)->result();
	}

	/**
	 * Get User by Identity
	 *                              //copied from above ^
	 * @return object User
	 * @author jondavidjohn
	 **/
	public function get_user_by_identity($identity)
	{
		return $this->ci->ion_auth_model->get_user_by_identity($identity)->row();
	}

	/**
	 * Get User as Array
	 *
	 * @return array User
	 * @author Ben Edmunds
	 **/
	public function get_user_array($id=false)
	{
	    return $this->ci->ion_auth_model->get_user($id)->row_array();
	}


	/**
	 * update_user
	 *
	 * @return void
	 * @author Phil Sturgeon
	 **/
	public function update_user($id, $data)
	{
		 if ($this->ci->ion_auth_model->update_user($id, $data))
		 {
			$this->set_message('update_successful');
			return TRUE;
		 }

		$this->set_error('update_unsuccessful');
		return FALSE;
	}


	/**
	 * delete_user
	 *
	 * @return void
	 * @author Phil Sturgeon
	 **/
	public function delete_user($id)
	{
		 if ($this->ci->ion_auth_model->delete_user($id))
		 {
			$this->set_message('delete_successful');
			return TRUE;
		 }

		$this->set_error('delete_unsuccessful');
		return FALSE;
	}


	/**
	 * extra_where
	 *
	 * Crazy function that allows extra where field to be used for user fetching/unique checking etc.
	 * Basically this allows users to be unique based on one other thing than the identifier which is helpful
	 * for sites using multiple domains on a single database.
	 *
	 * @return void
	 * @author Phil Sturgeon
	 **/
	public function extra_where()
	{
		$where =& func_get_args();

		$this->_extra_where = count($where) == 1 ? $where[0] : array($where[0] => $where[1]);
	}

	/**
	 * extra_set
	 *
	 * Set your extra field for registration
	 *
	 * @return void
	 * @author Phil Sturgeon
	 **/
	public function extra_set()
	{
		$set =& func_get_args();

		$this->_extra_set = count($set) == 1 ? $set[0] : array($set[0] => $set[1]);
	}

	/**
	 * set_message_delimiters
	 *
	 * Set the message delimiters
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/
	public function set_message_delimiters($start_delimiter, $end_delimiter)
	{
		$this->message_start_delimiter = $start_delimiter;
		$this->message_end_delimiter   = $end_delimiter;

		return TRUE;
	}

	/**
	 * set_error_delimiters
	 *
	 * Set the error delimiters
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/
	public function set_error_delimiters($start_delimiter, $end_delimiter)
	{
		$this->error_start_delimiter = $start_delimiter;
		$this->error_end_delimiter   = $end_delimiter;

		return TRUE;
	}

	/**
	 * set_message
	 *
	 * Set a message
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/
	public function set_message($message)
	{
		$this->messages[] = $message;

		return $message;
	}

	/**
	 * messages
	 *
	 * Get the messages
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/
	public function messages()
	{
		$_output = '';
		foreach ($this->messages as $message)
		{
			$_output .= $this->message_start_delimiter . $this->ci->lang->line($message) . $this->message_end_delimiter;
		}

		return $_output;
	}

	/**
	 * set_error
	 *
	 * Set an error message
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/
	public function set_error($error)
	{
		$this->errors[] = $error;

		return $error;
	}

	/**
	 * errors
	 *
	 * Get the error message
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/
	public function errors()
	{
		$_output = '';
		foreach ($this->errors as $error)
		{
			$_output .= $this->error_start_delimiter . $this->ci->lang->line($error) . $this->error_end_delimiter;
		}

		return $_output;
	}

}
