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
	 **/
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->config('users/ion_auth', true);
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
		if ( ! method_exists( $this->ci->ion_auth_model, $method))
		{
			throw new Exception('Undefined method Ion_auth::' . $method . '() called');
		}

		return call_user_func_array(array($this->ci->ion_auth_model, $method), $arguments);
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
			return true;
		}

		$this->set_error('activate_unsuccessful');
		return false;
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
			return true;
		}

		$this->set_error('deactivate_unsuccessful');
		return false;
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
		return true;
	}

		$this->set_error('password_change_unsuccessful');
	return false;
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

			// Add in some extra details
			$data['subject']	= Settings::get('site_name') . ' - Forgotten Password Verification';
			$data['slug'] 		= 'forgotten_password';
			$data['to'] 		= $user->email;
			$data['from'] 		= Settings::get('server_email');
			$data['name']		= Settings::get('site_name');
			$data['reply-to']	= Settings::get('contact_email');
			$data['user']		= $user;
			
			// send the email using the template event found in system/cms/templates/
			$results = Events::trigger('email', $data, 'array');

			// check for errors from the email event
			foreach ($results as $result)
			{
				if ( ! $result)
				{
					$this->set_error('forgot_password_unsuccessful');
					return false;
				}
			}
			
			// email send was successful, let them know
			$this->set_message('forgot_password_successful');
			return true;
		}
		else
		{
			$this->set_error('forgot_password_unsuccessful');
			return false;
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
	    $identity	= $this->ci->config->item('identity', 'ion_auth');
	    $user		= $this->ci->ion_auth_model->profile($code, true); //pass the code to profile

	    if (!is_object($user))
	    {
		$this->set_error('password_change_unsuccessful');
		return false;
	    }

		$new_password = $this->ci->ion_auth_model->forgotten_password_complete($code, $user->salt);

		if ($new_password)
		{
			// Add in some extra details
			$data['subject']		= Settings::get('site_name') . ' - New Password';
			$data['slug'] 			= 'new_password';
			$data['to'] 			= $user->email;
			$data['from'] 			= Settings::get('server_email');
			$data['name']			= Settings::get('site_name');
			$data['reply-to']		= Settings::get('contact_email');
			$data['user']			= $user;
			$data['new_password']	= $new_password;
			
			// send the email using the template event found in system/cms/templates/
			$results = Events::trigger('email', $data, 'array');

			// check for errors from the email event
			foreach ($results as $result)
			{
				if ( ! $result)
				{
					$this->set_error('password_change_unsuccessful');
					return false;
				}
			}
			
			// email send was successful, let them know
			$this->set_message('password_change_successful');
			return true;
		}
		else
		{
			$this->set_error('password_change_unsuccessful');
			return false;
		}
	}

	/**
	 * register
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function register($username, $password, $email, $group_id = null, $additional_data = array(), $group_name = false)
	{
		$id = $this->ci->ion_auth_model->register($username, $password, $email, $group_id, $additional_data, $group_name);

		if ($id !== false)
		{
			$this->set_message('account_creation_successful');

			if ((int)Settings::get('activation_email') === 1)
			{
				return $this->activation_email($id);
			}

			return $id;
		}
		else
		{
			$this->set_error('account_creation_unsuccessful');
			return false;
		}
	}

	/**
	 * Send an activation email to a user
	 * 
	 * @return int|bool
	 * @author Jerel Unruh
	 */
	public function activation_email($id = 0)
	{
		// deactivate them and generate the activation code
		$this->ci->ion_auth_model->deactivate($id);

		$activation_code 	= $this->ci->ion_auth_model->activation_code;
		$user				= $this->ci->ion_auth_model->get_user($id)->row();

		if ( ! $user)
		{
			$this->set_error('activation_email_unsuccessful');
			return false;
		}

		// Add in some extra details
		$data['subject']			= Settings::get('site_name') . ' - Account Activation'; // No translation needed as this is merely a fallback to Email Template subject
		$data['slug'] 				= 'activation';
		$data['to'] 				= $user->email;
		$data['from'] 				= Settings::get('server_email');
		$data['name']				= Settings::get('site_name');
		$data['reply-to']			= Settings::get('contact_email');
		$data['activation_code']	= $activation_code;
		$data['user']				= $user;
		
		// send the email using the template event found in system/cms/templates/
		$results = Events::trigger('email', $data, 'array');

		// check for errors from the email event
		foreach ($results as $result)
		{
			if ( ! $result)
			{
				$this->set_error('activation_email_unsuccessful');
				return false;
			}
		}
		
		// email send was successful, let them know
		$this->set_message('activation_email_successful');

		return $id;
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
			return true;
		}

		$this->set_error('login_unsuccessful');
		return false;
	}
	
	public function force_login($user_id, $remember = false)
	{
		if ($this->ci->ion_auth_model->force_login($user_id, $remember))
		{
			$this->set_message('login_successful');
			return true;
		}

		$this->set_error('login_unsuccessful');
		return false;
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

		$this->ci->session->sess_regenerate(true);

		$this->set_message('logout_successful');
		return true;
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
	public function get_users($group_name=false, $limit=null, $offset=null)
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
	public function get_users_array($group_name=false, $limit=null, $offset=null)
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
	public function update_user($id, $data, $profile_data)
	{
		 if ($this->ci->ion_auth_model->update_user($id, $data, $profile_data))
		 {
			$this->set_message('update_successful');
			return true;
		 }

		$this->set_error('update_unsuccessful');
		return false;
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
			return true;
		 }

		$this->set_error('delete_unsuccessful');
		return false;
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

		return true;
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

		return true;
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
        
         /** username_check
	 *
	 *
	 * Check to make sure username is unique upon create/edit
	 *
	 * @return void
	 * @author Matthew Moore / F2K Development Team
	 **/
        public function username_check($username)
        {
                return $this->ci->ion_auth_model->username_check($username);
        }
        
        /** email_check
	 *
	 *
	 * Check to make sure email is unique upon create/edit
	 *
	 * @return void
	 * @author Matthew Moore / F2K Development Team
	 **/
        public function email_check($email)
        {
                return $this->ci->ion_auth_model->email_check($email);
        }

}
