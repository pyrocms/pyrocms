<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Profile controller for the users module
 * 
 * @author 		Phil Sturgeon - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Users module
 * @category	Modules
 */
class Profile extends Public_Controller
{
	/**
	 * The ID of the user
	 * @access private
	 * @var int
	 */
	private $user_id 			= 0;
	
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
	public function __construct()
	{
		// Call the parent's constructor method
		parent::Public_Controller();
		
		// Load the required classes
		$this->load->model('users_m');
		$this->load->model('profile_m');
		
		$this->load->helper('user');
		$this->load->helper('date');		
		
		$this->lang->load('user');
		$this->lang->load('profile');
		
		$this->load->library('form_validation');
		
		// Validation rules - git is really pissing me off right now 
		$this->validation_rules = array(
			array(
				'field' => 'display_name',
				'label' => lang('profile_display'),
				'rules' => 'required|trim|alphanumeric'
			),
			array(
				'field' => 'gender',
				'label' => lang('profile_gender'),
				'rules' => 'trim|max_length[1]'
			),
			array(
				'field' => 'dob_day',
				'label' => lang('profile_dob_day'),
				'rules' => 'trim|numeric|required'
			),
			array(
				'field' => 'dob_month',
				'label' => lang('profile_dob_month'),
				'rules' => 'trim|numeric|required'
			),
			array(
				'field' => 'dob_year',
				'label' => lang('profile_dob_year'),
				'rules' => 'trim|numeric|required'
			),
			array(
				'field' => 'bio',
				'label' => lang('profile_bio'),
				'rules' => 'trim|max_length[1000]'
			),
			array(
				'field' => 'phone',
				'label' => lang('profile_phone'),
				'rules' => 'trim|alpha_numeric|max_length[20]'
			),
			array(
				'field' => 'mobile',
				'label' => lang('profile_mobile'),
				'rules' => 'trim|alpha_numeric|max_length[20]'
			),
			array(
				'field' => 'address_line1',
				'label' => lang('profile_address_line1'),
				'rules' => 'trim'
			),
			array(
				'field' => 'address_line2',
				'label' => lang('profile_address_line2'),
				'rules' => 'trim'
			),
			array(
				'field' => 'address_line3',
				'label' => lang('profile_address_line3'),
				'rules' => 'trim'
			),
			array(
				'field' => 'postcode',
				'label' => lang('profile_postcode'),
				'rules' => 'trim|max_length[20]'
			),
			array(
				'field' => 'website',
				'label' => lang('profile_website'),
				'rules' => 'trim|max_length[255]'
			 ),
			array(
				'field' => 'msn_handle',
				'label' => lang('profile_msn_handle'),
				'rules' => 'trim|valid_email'
			),
			array(
				'field' => 'aim_handle',
				'label' => lang('profile_aim_handle'),
				'rules' => 'trim|alpha_numeric'
			),
			array(
				'field' => 'yim_handle',
				'label' => lang('profile_yim_handle'),
				'rules' => 'trim|alpha_numeric'
			),
			array(
				'field' => 'gtalk_handle',
				'label' => lang('profile_gtalk_handle'),
				'rules' => 'trim|valid_email'
			),
			array(
				'field' => 'gravatar',
				'label' => lang('profile_gravatar'),
				'rules' => 'trim|valid_email'
			)
		);

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);
        
	    // If profiles are not enabled, pretend they don't exist
	    if(!$this->settings->item('enable_profiles'))
	    {
	    	show_404();
	    }
	        	
		// Get the user ID, if it exists
		if($user = $this->ion_auth->get_user())
		{
			$this->user_id = $user->id;
		}
			
	    // The user is not logged in, send them to login page
	   	if(!$this->ion_auth->logged_in())
	    {
			redirect('users/login');
	    }
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
	 * @access public 
	 * @param int $id The ID of the user
	 * @return void
	 */
	public function view($id = 0)
	{
		// No user? Show a 404 error. Easy way for now, instead should show a custom error message 
		if(!$this->data->user = $this->ion_auth->get_user($id) )
		{
			show_404();
		}
		
		// Render view
		$this->data->profile = $this->ion_auth->get_user($id);
		$this->template->build('profile/view', $this->data);
	}
	
	/**
	 * Edit the current user's profile
	 * 
	 * @access public
	 * @return void
	 */
	public function edit()
	{		
		// Array that will contain the POST data
		$secure_post;
		$profile = $this->ion_auth->get_user();
		
		// If this user already has a profile, use their data if nothing in post array
    	if ($profile)
    	{
		    $profile->dob_day 	= date('j', $profile->dob);
		    $profile->dob_month = date('n', $profile->dob);
		    $profile->dob_year 	= date('Y', $profile->dob);	
		}
  
	  	// Profile valid?
    	if ($this->form_validation->run())
    	{			
			// Loop through each POST item and add it to the secure_post array
			foreach($_POST as $key => $value)
			{
				$secure_post[$key] = $this->input->post($key);
			}
			
			// Set the full date of birth
    		$secure_post['dob'] = mktime(0, 0, 0, $secure_post['dob_month'], $secure_post['dob_day'], $secure_post['dob_year']);

			// Unset the data that's no longer required
			unset($secure_post['dob_month']);
			unset($secure_post['dob_day']);
			unset($secure_post['dob_year']);
			
			// Try to update the user's data
			if ($this->ion_auth->update_user($this->user_id, $secure_post) !== FALSE)
			{
    			$this->session->set_flashdata('success', $this->ion_auth->messages());
	    	}  
	    	else
	    	{
	    		$this->session->set_flashdata('error', $this->ion_auth->errors());
	    	}	

			// Redirect
	    	redirect('edit-profile');    	
		}
		else
		{
			// Loop through each validation rule
			foreach($this->validation_rules as $rule)
			{
				if($this->input->post($rule['field']) !== FALSE)
				{
					$profile->{$rule['field']} = set_value($rule['field']);	
				}
			}
		}
    	
	    // Date ranges for select boxes
		$this->data->profile =& $profile;
		
	    $this->data->days 	= array_combine($days 	= range(1, 31), $days);
	    $this->data->months = array_combine($months = range(1, 12), $months);
	    $this->data->years 	= array_combine($years 	= range(date('Y'), date('Y')-120), $years);
       	
		// Render the view
		$this->template->build('profile/edit', $this->data);
	}	
	
	
	/**
	 * Authenticate to Twitter with oAuth
	 *
	 * @author Ben Edmunds
	 * @access public
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
				$tokens = array(
							'twitter_access_token' 		  => $auth['access_token'],
							'twitter_access_token_secret' => $auth['access_token_secret'],
							   );
				$this->ion_auth->update_user($this->user->id, $tokens);

				if ( isset($_GET['oauth_token']) )
				{
					$uri = $_SERVER['REQUEST_URI'];
					$parts = explode('?', $uri);

					// redirect the user since we've saved their info
					header('Location: '.$parts[0]);
					return;
				}
			}
		}
		elseif ($auth == 1) {
			redirect('users/profile/edit', 'refresh');
		}
	}

}

?>