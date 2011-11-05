<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author 		PyroCMS Development Team
 * @package 	PyroCMS
 * @subpackage 	Controllers
 */
class Admin extends Admin_Controller
{
	/**
	 * Constructor method
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
  		parent::__construct();

		$this->load->helper('users/user');
 	}

 	/**
 	 * Show the control panel
	 *
	 * @access public
	 * @return void
 	 */
 	public function index()
	{
		$data = array();
		
		if (is_dir('./installer'))
		{
			$data['messages']['notice'] = lang('cp_delete_installer_message');
		}
		
		$this->template
			->enable_parser(TRUE)
			->title(lang('global:dashboard'))
			->build('admin/dashboard', $data);
	}

	/**
	 * Log in
	 *
	 * @access public
	 * @return void
	 */
	public function login()
	{
		// Set the validation rules
		$this->validation_rules = array(
			array(
				'field' => 'email',
				'label'	=> lang('email_label'),
				'rules' => 'required|callback__check_login'
			),
			array(
				'field' => 'password',
				'label'	=> lang('password_label'),
				'rules' => 'required'
			)
		);

		// Call validation and set rules
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->validation_rules);
	
		// If the validation worked, or the user is already logged in
		if ($this->form_validation->run() OR $this->ion_auth->logged_in())
		{
			redirect('admin');
		}

		$this->template
			->set_layout(FALSE)
			->build('admin/login');
	}

	/**
	 * Logout
	 *
	 * @access public
	 * @return void
	 */
	public function logout()
	{
		$this->load->language('users/user');
		$this->ion_auth->logout();
		$this->session->set_flashdata('success', lang('user_logged_out'));
		redirect('admin/login');
	}

	/**
	 * Callback From: login()
	 *
	 * @access public
	 * @param string $email The Email address to validate
	 * @return bool
	 */
	public function _check_login($email)
	{
		$remember = (bool) $this->input->post('remember');

		if ($this->ion_auth->login($email, $this->input->post('password'), $remember))
		{
			return TRUE;
		}

		$this->form_validation->set_message('_check_login', $this->ion_auth->errors());
		return FALSE;
	}
	
	/**
	 * Display the help string from a module's
	 * details.php file in a modal window
	 *
	 * @access	public
	 * @param	string	$slug	The module to fetch help for
	 * @return	void
	 */
	
	public function help($slug)
	{
		$this->data->help = $this->module_m->help($slug);

		$this->template
			->set_layout('modal', 'admin')
			->build('admin/partials/help', $this->data);
	}
}