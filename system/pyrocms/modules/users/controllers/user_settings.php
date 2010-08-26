<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User settings controller for the users module
 *
 * @author 		Phil Sturgeon - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Users module
 * @category	Modules
 */
class User_settings extends Public_Controller
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
		parent::__construct();

		// Get the user ID, if it exists
		if($user = $this->ion_auth->get_user())
		{
			$this->user_id = $user->id;
		}

		// Load the required data
		$this->load->model('users_m');
		$this->load->library('form_validation');

		$this->load->helper('user');
		$this->lang->load('user');

		// Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'settings_first_name',
				'label' => lang('user_first_name'),
				'rules' => 'required|alpha_dash'
			),
			array(
				'field' => 'settings_last_name',
				'label' => lang('user_last_name'),
				'rules' => ($this->settings->require_lastname ? 'required|' : '').'surname'
			),
			array(
				'field' => 'settings_password',
				'label' => lang('user_password'),
				'rules' => 'min_length[6]|max_length[20]'
			),
			array(
				'field' => 'settings_confirm_password',
				'label' => lang('user_confirm_password'),
				'rules' => ($this->input->post('settings_password') ? 'required|' : '').'matches[settings_password]'
			),
			array(
				'field' => 'settings_email',
				'label' => lang('user_email'),
				'rules' => 'valid_email'
			),
			array(
				'field' => 'settings_confirm_email',
				'label' => lang('user_confirm_email'),
				'rules' => 'valid_email|matches[settings_email]'
			),
			array(
				'field' => 'settings_lang',
				'label' => lang('user_lang'),
				'rules' => 'alpha|max_length[2]'
			),
		);

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);
	}

	/**
   	 * Show the current settings
	 *
	 * @access public
	 * @return void
   	 */
	public function index()
	{
		$this->edit();
	}

	/**
	 * Edit the current user's settings
	 *
	 * @access public
	 * @return void
	 */
	public function edit()
	{
		// Got login?
		if(!$this->ion_auth->logged_in())
		{
			redirect('users/login');
		}

	    // Get settings for this user
	   $user_settings = $this->ion_auth->get_user();

		// Settings valid?
	    if ($this->form_validation->run())
	    {
			// Set the data to insert
	    	$set['first_name'] 	= $this->input->post('settings_first_name', TRUE);
	    	$set['last_name'] 	= $this->input->post('settings_last_name', TRUE);

	    	// Set the language for this user
			$this->ion_auth->set_lang( $this->input->post('settings_lang', TRUE) );
			$set['lang'] = $this->input->post('settings_lang', TRUE);

	    	// If password is being changed (and matches)
	    	if($this->input->post('settings_password'))
	    	{
				$set['password'] = $this->input->post('settings_password');
	    	}

			if ($this->ion_auth->update_user($this->user_id, $set))
			{
	    		$this->session->set_flashdata('success', $this->ion_auth->messages());
	    	}
	    	else
	    	{
	    		$this->session->set_flashdata('error', $this->ion_auth->errors());
	    	}

			// Redirect
	    	redirect('edit-settings');
	    }
		else
		{
			// Loop through each validation rule
			foreach ($this->validation_rules as $rule)
			{
				if ($this->input->post($rule['field']) !== FALSE)
				{
					// Get rid of the settings_ prefix
					$fieldname = str_replace('settings_','',$rule['field']);
					$user_settings->{$fieldname} = set_value($rule['field']);
				}
			}
		}

	    // Format languages for the dropdown box
	    $this->data->languages = array();
	    foreach($this->config->item('supported_languages') as $lang_code => $lang)
	    {
	    	$this->data->languages[$lang_code] = $lang['name'];
	    }

		$this->data->user_settings =& $user_settings;
		$this->template->build('settings/edit', $this->data);
	}
}
?>
