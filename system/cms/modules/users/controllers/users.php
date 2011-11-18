<?php defined('BASEPATH') OR exit('No direct script access allowed');

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
	 * Constructor method
	 *
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->model('users_m');
		$this->load->helper('user');
		$this->lang->load('user');
		$this->load->library('form_validation');
	}

	/**
	 * Show the current user's profile
	 *
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$this->view($this->current_user->id);
	}

	/**
	 * View a user profile based on the ID
	 *
	 * @param	mixed $id The Username or ID of the user
	 * @return	void
	 */
	public function view($id = NULL)
	{
		$user = ($this->current_user && $id == $this->current_user->id) ? $this->current_user : $this->ion_auth->get_user($id);
		
		// No user? Show a 404 error. Easy way for now, instead should show a custom error message
		$user or show_404();
		
		// Take care of the {} braces in the content
		foreach ($user as $field => $value)
		{
			$user->{$field} = escape_tags($value);
		}

		$this->template->build('profile/view', array(
			'user' => $user,
		));
	}

	/**
	 * Let's login, shall we?
	 *
	 * @return void
	 */
	public function login()
	{
		// Check post and session for the redirect place
		$redirect_to = $this->input->post('redirect_to') ? $this->input->post('redirect_to') : $this->session->userdata('redirect_to');

		// Any idea where we are heading after login?
		if ( ! $_POST AND $args = func_get_args())
		{
			$this->session->set_userdata('redirect_to', $redirect_to = implode('/', $args));
		}

		// Get the user data
		$user_data = (object) array(
			'email'		=> $this->input->post('email'),
			'password'	=> $this->input->post('password')
		);

		$validation = array(
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
		$this->form_validation->set_rules($validation);

		// If the validation worked, or the user is already logged in
		if ($this->form_validation->run() or $this->ion_auth->logged_in())
		{
			$this->session->set_flashdata('success', lang('user_logged_in'));

			// Kill the session
			$this->session->unset_userdata('redirect_to');

			// Deprecated.
			$this->hooks->_call_hook('post_user_login');

			// trigger a post login event for third party devs
			Events::trigger('post_user_login');

			redirect($redirect_to ? $redirect_to : '');
		}

		$this->template->build('login', array(
			'user_data' => $user_data,
			'redirect_to' => $redirect_to,
		));
	}

	/**
	 * Method to log the user out of the system
	 *
	 * @return void
	 */
	public function logout()
	{
		// allow third party devs to do things right before the user leaves
		Events::trigger('pre_user_logout');

		$this->ion_auth->logout();
		$this->session->set_flashdata('success', lang('user_logged_out'));
		redirect('');
	}

	/**
	 * Method to register a new user
	 *
	 * @return void
	 */
	public function register()
	{
		// Validation rules
		$validation = array(
			array(
				'field' => 'first_name',
				'label' => lang('user_first_name'),
				'rules' => 'required'
			),
			array(
				'field' => 'last_name',
				'label' => lang('user_last_name'),
				'rules' => (Settings::get('require_lastname') ? 'required' : '')
			),
			array(
				'field' => 'password',
				'label' => lang('user_password'),
				'rules' => 'required|min_length[6]|max_length[20]'
			),
			array(
				'field' => 'email',
				'label' => lang('user_email'),
				'rules' => 'required|valid_email|callback__email_check',
			),
			array(
				'field' => 'username',
				'label' => lang('user_username'),
				'rules' => Settings::get('auto_username') ? '' : 'required|alpha_numeric|min_length[3]|max_length[20]|callback__username_check',
			),
		);

		// Set the validation rules
		$this->form_validation->set_rules($validation);
	
		if ($this->form_validation->run())
		{	

			$email				= $this->input->post('email');
			$password			= $this->input->post('password');	
			
			// Let's do some crazy shit and make a username!
			if (Settings::get('auto_username'))
			{
				$i = 1;
				
				do
				{
					$username = url_title($this->input->post('first_name').'.'.$this->input->post('last_name'), '-', true);
					
					// Add 2, 3, 4 etc to the end
					$i > 1 and $username .= $i;
					
					++$i;
				}
				
				// Keep trying until it is unique
				while ($this->db->where('username', $username)->count_all_results('users') > 0);
			}
			
			// Let's just use post (which we required earlier)
			else
			{
				$username = $this->input->post('username');
			}

			$id = $this->ion_auth->register($username, $password, $email, array(
				'first_name'		=> $this->input->post('first_name'),
				'last_name'			=> $this->input->post('last_name'),
				'display_name'		=> $username,
			));

			// Try to create the user
			if ($id > 0)
			{
				// Convert the array to an object
				$user_data						= new stdClass();
				$user_data->first_name 			= $this->input->post('first_name');
				$user_data->last_name			= $this->input->post('last_name');
				$user_data->username			= $username;
				$user_data->display_name		= $username;
				$user_data->email				= $email;
				$user_data->password 			= $password;
				
				// trigger an event for third party devs
				Events::trigger('post_user_register', $id);

				/* send the internal registered email if applicable */
				if (Settings::get('registered_email'))
				{
					$this->load->library('user_agent');

					Events::trigger('email', array(
						'name' => $user_data->first_name.' '.$user_data->last_name,
						'sender_ip' => $this->input->ip_address(),
						'sender_agent' => $this->agent->browser() . ' ' . $this->agent->version(),
						'sender_os' => $this->agent->platform(),
						'slug' => 'registered',
						'email' => Settings::get('contact_email'),
					), 'array');
				}

				/* show the you need to activate page while they wait for there email */
				if (Settings::get('activation_email'))
				{
					$this->session->set_flashdata('notice', $this->ion_auth->messages());
					redirect('users/activate');
				}
				
				elseif (Settings::get('registered_email'))
				/* show the admin needs to activate you email */
				{
					$this->session->set_flashdata('notice', lang('user_activation_by_admin_notice'));
					redirect('users/register'); /* bump it to show the flash data */
				}
			}
			
			// Can't create the user, show why
			else
			{
				$data['error_string'] = $this->ion_auth->errors();
			}
		}
		else
		{
			// Return the validation error
			$data['error_string'] = $this->form_validation->error_string();
		}

		$this->template
			->title(lang('user_register_title'))
			->set($data)
			->build('register');
	}

	/**
	 * Activate a user
	 *
	 * @param int $id The ID of the user
	 * @param str $code The activation code
	 * @return void
	 */
	public function activate($id = 0, $code = NULL)
	{
		// Get info from email
		if ($this->input->post('email'))
		{
			$this->data->activate_user = $this->ion_auth->get_user_by_email($this->input->post('email'));
			$id = $this->data->activate_user->id;
		}

		$code = ($this->input->post('activation_code')) ? $this->input->post('activation_code') : $code;

		// If user has supplied both bits of information
		if ($id AND $code)
		{
			// Try to activate this user
			if ($this->ion_auth->activate($id, $code))
			{
				$this->session->set_flashdata('activated_email', $this->ion_auth->messages());

				// Deprecated
				$this->hooks->_call_hook('post_user_activation');

				// trigger an event for third party devs
				Events::trigger('post_user_activation', $id);

				redirect('users/activated');
			}
			else
			{
				$this->data->error_string = $this->ion_auth->errors();
			}
		}

		$this->template->title($this->lang->line('user_activate_account_title'));
		$this->template->set_breadcrumb($this->lang->line('user_activate_label'), 'users/activate');
		$this->template->build('activate', $this->data);
	}

	/**
	 * Activated page
	 *
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
	 *
	 * @return void
	 */
	public function reset_pass($code = FALSE)
	{
		//if user is logged in they don't need to be here. and should use profile options
		if ($this->ion_auth->logged_in())
		{
			$this->session->set_flashdata('error', $this->lang->line('user_already_logged_in'));
			redirect('my-profile');
		}

		if ($this->input->post('btnSubmit'))
		{
			$uname = $this->input->post('user_name');
			$email = $this->input->post('email');

			$user_meta = $this->ion_auth->get_user_by_email($email);
			
			if ( ! $user_meta)
			{
				$user_meta = $this->ion_auth->get_user_by_username($uname);
			}

			// have we found a user?
			if ($user_meta)
			{
				$new_password = $this->ion_auth->forgotten_password($user_meta->email);

				if ($new_password)
				{
					//set success message
					$this->data->success_string = lang('forgot_password_successful');
				}
				else
				{
					// Set an error message explaining the reset failed
					$this->data->error_string = $this->ion_auth->errors();
				}
			}
			else
			{
				//wrong username / email combination
				$this->data->error_string = $this->lang->line('user_forgot_incorrect');
			}
		}

		//code is supplied in url so lets try to reset the password
		if ($code)
		{
			//verify reset_code against code stored in db
			$reset = $this->ion_auth->forgotten_password_complete($code);

			//did the password reset?
			if ($reset)
			{
				redirect('users/reset_complete');
			}
			else
			{
				//nope, set error message
				$this->data->error_string = $this->ion_auth->errors();
			}
		}

		$this->template->title($this->lang->line('user_reset_password_title'));
		$this->template->build('reset_pass', $this->data);
	}

	/**
	 * Password reset is finished
	 *
	 * @param string $code Optional parameter the reset_password_code
	 * @return void
	 */
	public function reset_complete()
	{
		//if user is logged in they don't need to be here. and should use profile options
		if ($this->current_user)
		{
			$this->session->set_flashdata('error', lang('user_already_logged_in'));
			redirect('my-profile');
		}

		$this->template
			->title(lang('user_password_reset_title'))
			->build('reset_pass_complete', $this->data);
	}

	/**
	 *
	 */
	public function edit()
	{
		$user = $this->current_user or redirect('users/login');

		$this->validation_rules = array(
			array(
				'field' => 'first_name',
				'label' => lang('user_first_name'),
				'rules' => 'xss_clean|required'
			),
			array(
				'field' => 'last_name',
				'label' => lang('user_last_name'),
				'rules' => 'xss_clean'.(Settings::get('require_lastname') ? '|required' : '')
			),
			array(
				'field' => 'password',
				'label' => lang('user_password'),
				'rules' => 'xss_clean|min_length[6]|max_length[20]'
			),
			array(
				'field' => 'email',
				'label' => lang('user_email'),
				'rules' => 'xss_clean|valid_email'
			),
			array(
				'field' => 'lang',
				'label' => lang('user_lang'),
				'rules' => 'xss_clean|alpha|max_length[2]'
			),
			array(
				'field' => 'display_name',
				'label' => lang('profile_display'),
				'rules' => 'xss_clean|trim|required'
			),
			// More fields
			array(
				'field' => 'gender',
				'label' => lang('profile_gender'),
				'rules' => 'xss_clean|trim|max_length[1]'
			),
			array(
				'field' => 'dob_day',
				'label' => lang('profile_dob_day'),
				'rules' => 'xss_clean|trim|numeric|max_length[2]|required'
			),
			array(
				'field' => 'dob_month',
				'label' => lang('profile_dob_month'),
				'rules' => 'xss_clean|trim|numeric|max_length[2]|required'
			),
			array(
				'field' => 'dob_year',
				'label' => lang('profile_dob_year'),
				'rules' => 'xss_clean|trim|numeric|max_length[4]|required'
			),
			array(
				'field' => 'bio',
				'label' => lang('profile_bio'),
				'rules' => 'xss_clean|trim|max_length[1000]'
			),
			array(
				'field' => 'phone',
				'label' => lang('profile_phone'),
				'rules' => 'xss_clean|trim|alpha_numeric|max_length[20]'
			),
			array(
				'field' => 'mobile',
				'label' => lang('profile_mobile'),
				'rules' => 'xss_clean|trim|alpha_numeric|max_length[20]'
			),
			array(
				'field' => 'address_line1',
				'label' => lang('profile_address_line1'),
				'rules' => 'xss_clean|trim'
			),
			array(
				'field' => 'address_line2',
				'label' => lang('profile_address_line2'),
				'rules' => 'xss_clean|trim'
			),
			array(
				'field' => 'address_line3',
				'label' => lang('profile_address_line3'),
				'rules' => 'xss_clean|trim'
			),
			array(
				'field' => 'postcode',
				'label' => lang('profile_postcode'),
				'rules' => 'xss_clean|trim|max_length[20]'
			),
			array(
				'field' => 'website',
				'label' => lang('profile_website'),
				'rules' => 'xss_clean|trim|max_length[255]'
			),
			array(
				'field' => 'msn_handle',
				'label' => lang('profile_msn_handle'),
				'rules' => 'xss_clean|trim|valid_email'
			),
			array(
				'field' => 'aim_handle',
				'label' => lang('profile_aim_handle'),
				'rules' => 'xss_clean|trim|alpha_numeric'
			),
			array(
				'field' => 'yim_handle',
				'label' => lang('profile_yim_handle'),
				'rules' => 'xss_clean|trim|alpha_numeric'
			),
			array(
				'field' => 'gtalk_handle',
				'label' => lang('profile_gtalk_handle'),
				'rules' => 'xss_clean|trim|valid_email'
			),
			array(
				'field' => 'gravatar',
				'label' => lang('profile_gravatar'),
				'rules' => 'xss_clean|trim|valid_email'
			)
		);

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);

		// Settings valid?
		if ($this->form_validation->run())
		{
			// Loop through each POST item and add it to the secure_post array
			$secure_post = $this->input->post();

			// Set the full date of birth
			$secure_post['dob'] = mktime(0, 0, 0, $secure_post['dob_month'], $secure_post['dob_day'], $secure_post['dob_year']);

			// Unset the data that's no longer required
			unset($secure_post['dob_month']);
			unset($secure_post['dob_day']);
			unset($secure_post['dob_year']);

			// Set the language for this user
			if ($secure_post['lang'])
			{
				$this->ion_auth->set_lang( $secure_post['lang'] );
				$_SESSION['lang_code'] = $secure_post['lang'];
			}
			else
			{
				unset($secure_post['lang']);
			}

			// If password is being changed (and matches)
			if ( ! $secure_post['password'])
			{
				unset($secure_post['password']);
			}

			// Set the time of update
			$secure_post['updated_on'] = now();

			if ($this->ion_auth->update_user($this->current_user->id, $secure_post) !== FALSE)
			{
				Events::trigger('post_user_update');

				$this->session->set_flashdata('success', $this->ion_auth->messages());
			}
			else
			{
				$this->session->set_flashdata('error', $this->ion_auth->errors());
			}

			redirect('edit-settings');
		}
		else
		{
			// Loop through each validation rule
			foreach ($this->validation_rules as $rule)
			{
				if ($this->input->post($rule['field']) !== FALSE)
				{
					$user->{$rule['field']} = set_value($rule['field']);
				}
			}
		}

		// Take care of the {} braces in the content
		foreach ($user as $field => $value)
		{
			$user->{$field} = escape_tags($value);
		}
		
		// If this user already has a profile, use their data if nothing in post array
		if ($user->dob > 0)
		{
		    $user->dob_day 	= date('j', $user->dob);
		    $user->dob_month = date('n', $user->dob);
		    $user->dob_year = date('Y', $user->dob);
		}

		// Fix the months
		$this->lang->load('calendar');
		
		$month_names = array(
			lang('cal_january'),
			lang('cal_february'),
			lang('cal_march'),
			lang('cal_april'),
			lang('cal_mayl'),
			lang('cal_june'),
			lang('cal_july'),
			lang('cal_august'),
			lang('cal_september'),
			lang('cal_october'),
			lang('cal_november'),
			lang('cal_december'),
		);
		
	    $days 	= array_combine($days 	= range(1, 31), $days);
		$months = array_combine($months = range(1, 12), $month_names);
	    $years 	= array_combine($years 	= range(date('Y'), date('Y')-120), $years);

	    // Format languages for the dropdown box
	    $languages = array();
	    // get the languages offered on the front-end
	    $site_public_lang = explode(',', Settings::get('site_public_lang'));
	
	    foreach ($this->config->item('supported_languages') as $lang_code => $lang)
	    {
	       // if the supported language is offered on the front-end
	       if (in_array($lang_code, $site_public_lang))
	       {
          	// add it to the dropdown list
        	   $languages[$lang_code] = $lang['name'];
	       }
	    }

		// Render the view
		$this->template->build('profile/edit', array(
			'languages' => $languages,
			'user' => $user,
			'days' => $days,
			'months' => $months,
			'years' => $years,
		));
	}

	/**
	 * Authenticate to Twitter with oAuth
	 *
	 * @author Ben Edmunds
	 * @return boolean
	 */
	public function twitter()
	{
		$this->load->library('twitter/twitter');

		// Try to authenticate
		$auth = $this->twitter->oauth(Settings::get('twitter_consumer_key'), Settings::get('twitter_consumer_key_secret'), $this->current_user->twitter_access_token, $this->current_user->twitter_access_token_secret);

		if ($auth!=1 && Settings::get('twitter_consumer_key') && Settings::get('twitter_consumer_key_secret'))
		{
			if (isset($auth['access_token']) && !empty($auth['access_token']) && isset($auth['access_token_secret']) && !empty($auth['access_token_secret']))
			{
				// Save the access tokens to the users profile
				$this->ion_auth->update_user($this->current_user->id, array(
					'twitter_access_token' 		  => $auth['access_token'],
					'twitter_access_token_secret' => $auth['access_token_secret'],
				));

				if (isset($_GET['oauth_token']) )
				{
					$parts = explode('?', $_SERVER['REQUEST_URI']);

					// redirect the user since we've saved their info
					redirect($parts[0]);
				}
			}
		}
		
		elseif ($auth == 1)
		{
			redirect('edit-settings', 'refresh');
		}
	}

	/**
	 * Callback method used during login
	 *
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
	 */
	public function _username_check($username)
	{
	    if ($this->ion_auth->username_check($username))
	    {
	        $this->form_validation->set_message('_username_check', $this->lang->line('user_error_username'));
	        return FALSE;
	    }
	
        return TRUE;
	}

	/**
	 * Email check
	 *
	 * @return bool
	 * @author Ben Edmunds
	 */
	public function _email_check($email)
	{
		if ($this->ion_auth->email_check($email))
		{
			$this->form_validation->set_message('_email_check', $this->lang->line('user_error_email'));
			return FALSE;
		}
		
		return TRUE;
	}

}