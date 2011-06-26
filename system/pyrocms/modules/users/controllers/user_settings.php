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
	 * @var int
	 */
	private $user_id = 0;

	/**
	 * Array containing the validation rules
	 * @var array
	 */
	private $validation_rules 	= array();

	/**
	 * Constructor method
	 *
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

		// Load the required classes
		$this->load->model('users_m');

		$this->load->helper('user');

		$this->lang->load('user');

		$this->load->library('form_validation');

		// Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'settings_first_name',
				'label' => lang('user_first_name'),
				'rules' => 'required|xss_clean'
			),
			array(
				'field' => 'settings_last_name',
				'label' => lang('user_last_name'),
				'rules' => ($this->settings->require_lastname ? 'required|' : '').'xss_clean'
			),
			array(
				'field' => 'settings_password',
				'label' => lang('user_password'),
				'rules' => 'min_length[6]|max_length[20]|xss_clean'
			),
			array(
				'field' => 'settings_confirm_password',
				'label' => lang('user_confirm_password'),
				'rules' => ($this->input->post('settings_password') ? 'required|' : '').'matches[settings_password]|xss_clean'
			),
			array(
				'field' => 'settings_email',
				'label' => lang('user_email'),
				'rules' => 'valid_email|xss_clean'
			),
			array(
				'field' => 'settings_confirm_email',
				'label' => lang('user_confirm_email'),
				'rules' => 'valid_email|matches[settings_email]|xss_clean'
			),
			array(
				'field' => 'settings_lang',
				'label' => lang('user_lang'),
				'rules' => 'alpha|max_length[2]|xss_clean'
			),
		);

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);
	}

	/**
	 * Show the current settings
	 *
	 * @return void
	 */
	public function index()
	{
		$this->edit();
	}

	/**
	 * Edit the current user's settings
	 *
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
			$set = array(
				'first_name'	=> $this->input->post('settings_first_name'),
				'last_name' 	=> $this->input->post('settings_last_name'),
				'lang' 		=> $this->input->post('settings_lang'),
				'password' 	=> $this->input->post('settings_password'),
			);

			// Set the language for this user
			if ($set['lang'])
			{
				$this->ion_auth->set_lang( $set['lang'] );
				$_SESSION['lang_code'] = $set['lang'];
			}
			else
			{
				unset($set['lang']);
			}

			// If password is being changed (and matches)
			if(! $set['password'])
			{
				unset($set['password']);
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