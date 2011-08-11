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
	 * The ID of the user
	 * @var int
	 */
	private $user_id = 0;

	/**
	 * Constructor method
	 *
	 * @return void
	 */
	function __construct()
	{
		// Call the parent's constructor method
		parent::__construct();

		// Get the user ID, if it exists
		if($user = $this->ion_auth->get_user())
		{
			$this->user_id = $user->id;
		}

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
		$this->view($this->user_id);
	}

	/**
	 * View a user profile based on the ID
	 *
	 * @param	mixed $id The Username or ID of the user
	 * @return	void
	 */
	public function view($id = NULL)
	{
		// No user? Show a 404 error. Easy way for now, instead should show a custom error message
		if ( ! $user = $this->ion_auth->get_user($id) )
		{
			show_404();
		}

		foreach ($user as &$data)
		{
			$data = escape_tags($data);
		}

		// Render view
		$this->data->view_user = $user; //needs to be something other than $this->data->user or it conflicts with the current user
		$this->data->user_settings = $user;
		$this->template->build('profile/view', $this->data);
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
				'rules' => ($this->settings->require_lastname ? 'required' : '')
			),
			array(
				'field' => 'password',
				'label' => lang('user_password'),
				'rules' => 'required|min_length[6]|max_length[20]'
			),
			array(
				'field' => 'confirm_password',
				'label' => lang('user_confirm_password'),
				'rules' => 'required|matches[password]',
			),
			array(
				'field' => 'email',
				'label' => lang('user_email'),
				'rules' => 'required|valid_email|callback__email_check',
			),
			array(
				'field' => 'confirm_email',
				'label' => lang('user_confirm_email'),
				'rules' => 'required|valid_email|matches[email]',
			),
			array(
				'field' => 'username',
				'label' => lang('user_username'),
				'rules' => 'required|alpha_numeric|min_length[3]|max_length[20]|callback__username_check',
			),
			array(
				'field' => 'display_name',
				'label' => lang('user_display_name'),
				'rules' => 'min_length[3]|max_length[50]',
			),
		);

		// Set the validation rules
		$this->form_validation->set_rules($validation);

		$email				= $this->input->post('email');
		$password			= $this->input->post('password');
		$username			= $this->input->post('username');
		$user_data_array	= array(
			'first_name'		=> $this->input->post('first_name'),
			'last_name'			=> $this->input->post('last_name'),
			'display_name'		=> $this->input->post('display_name'),
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
			/* override config settings */
			$this->config->set_item('email_activation', $this->settings->activation_email, 'ion_auth');

			// Try to create the user
			if ($id = $this->ion_auth->register($username, $password, $email, $user_data_array))
			{
				// trigger an event for third party devs
				Events::trigger('post_user_register', $id);

				/* send the internal registered email if applicable */
				if ($this->settings->registered_email)
				{
					$this->load->library('user_agent');

					// Add in some extra details
					$data['name']					= $user_data->first_name.' '.$user_data->last_name;
					$data['sender_ip']		= $this->input->ip_address();
					$data['sender_agent']	= $this->agent->browser() . ' ' . $this->agent->version();
					$data['sender_os']		= $this->agent->platform();
					$data['slug'] 				= 'registered';
					$data['email'] 				= $this->settings->contact_email;

					Events::trigger('email', $data, 'array');
				}

				/* show the you need to activate page while they wait for there email */
				if ($this->settings->activation_email)
				{
				  $this->session->set_flashdata(array('notice' => $this->ion_auth->messages()));
				  redirect('users/activate');
				}
				elseif ($this->settings->registered_email)
				/* show the admin needs to activate you email */
				{
				  $this->session->set_flashdata(array('notice' => lang('user_activation_by_admin_notice')));
				  redirect('users/register'); /* bump it to show the flash data */
				}
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

		foreach ($user_data as &$data)
		{
			$data = escape_tags($data);
		}

		$this->data->user_data =& $user_data;
		$this->template->title(lang('user_register_title'));
		$this->template->build('register', $this->data);
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

			//supplied username match the email also given?  if yes keep going..
			if ($user_meta && $user_meta->username == $uname)
			{
				$new_password = $this->ion_auth->forgotten_password($email);

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
		if ($this->ion_auth->logged_in())
		{
			$this->session->set_flashdata('error', $this->lang->line('user_already_logged_in'));
			redirect('my-profile');
		}

		//set page title
		$this->template->title($this->lang->line('user_password_reset_title'));

		//build and render the output
		$this->template->build('reset_pass_complete', $this->data);
	}

	/**
	 *
	 */
	public function edit()
	{


		// Got login?
		if(!$this->ion_auth->logged_in())
		{
			redirect('users/login');
		}

		// Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'first_name',
				'label' => lang('user_first_name'),
				'rules' => 'xss_clean|required'
			),
			array(
				'field' => 'last_name',
				'label' => lang('user_last_name'),
				'rules' => 'xss_clean'.($this->settings->require_lastname ? '|required' : '')
			),
			array(
				'field' => 'password',
				'label' => lang('user_password'),
				'rules' => 'xss_clean|min_length[6]|max_length[20]'
			),
			array(
				'field' => 'confirm_password',
				'label' => lang('user_confirm_password'),
				'rules' => 'xss_clean|'.($this->input->post('password') ? 'required|' : '').'matches[password]'
			),
			array(
				'field' => 'email',
				'label' => lang('user_email'),
				'rules' => 'xss_clean|valid_email'
			),
			array(
				'field' => 'confirm_email',
				'label' => lang('user_confirm_email'),
				'rules' => 'xss_clean|valid_email|matches[email]'
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

		// Get settings for this user
		$user_settings = $this->ion_auth->get_user();


		// Get the user ID, if it exists
		if ($user_settings)
		{
			$this->user_id = $user_settings->id;
		}

		// If this user already has a profile, use their data if nothing in post array
		if ($user_settings)
		{
		    $user_settings->dob_day 	= date('j', $user_settings->dob);
		    $user_settings->dob_month = date('n', $user_settings->dob);
		    $user_settings->dob_year 	= date('Y', $user_settings->dob);
		}

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
			if(! $secure_post['password'])
			{
				unset($secure_post['password']);
			}
			// We don't need this anymore
			unset($secure_post['confirm_password']);

			// Set the time of update
			$secure_post['updated_on'] = now();

			if ($this->ion_auth->update_user($this->user_id, $secure_post) !== FALSE)
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
					$user_settings->{$rule['field']} = set_value($rule['field']);
				}
			}
		}

		// Take care of the {} braces in the content
		$escape_fields = array(
			'bio', 'address_line1', 'address_line2', 'address_line3', 'postcode',
			'website', 'msn_handle', 'gtalk_handle', 'gravatar'
		);
		foreach ($escape_fields as $field)
		{
			$user_settings->{$field} = escape_tags($user_settings->{$field});
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
	    $this->data->days 	= array_combine($days 	= range(1, 31), $days);
		$this->data->months = array_combine($months = range(1, 12), $month_names);
	    $this->data->years 	= array_combine($years 	= range(date('Y'), date('Y')-120), $years);

	    // Format languages for the dropdown box
	    $this->data->languages = array();
	    foreach($this->config->item('supported_languages') as $lang_code => $lang)
	    {
			$this->data->languages[$lang_code] = $lang['name'];
	    }

		$this->data->user_settings =& $user_settings;

		// Render the view
		$this->template->build('profile/edit', $this->data);
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
		$auth = $this->twitter->oauth($this->settings->item('twitter_consumer_key'), $this->settings->item('twitter_consumer_key_secret'), $this->user->twitter_access_token, $this->user->twitter_access_token_secret);

		if ($auth!=1 && $this->settings->item('twitter_consumer_key') && $this->settings->item('twitter_consumer_key_secret'))
		{
			if (isset($auth['access_token']) && !empty($auth['access_token']) && isset($auth['access_token_secret']) && !empty($auth['access_token_secret']))
			{
				// Save the access tokens to the users profile
				$this->ion_auth->update_user($this->user->id, array(
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
		elseif ($auth == 1) {
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
	 */
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