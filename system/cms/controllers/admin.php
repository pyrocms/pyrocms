<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * The admin class is basically the main controller for the backend.
 *
 * @author PyroCMS Development Team
 * @package	 PyroCMS\Core\Controllers
 */
class Admin extends Admin_Controller
{
	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('users/user');
	}

	/**
	 * Show the control panel
	 */
	public function index()
	{
		$this->template
			->enable_parser(TRUE)
			->title(lang('global:dashboard'));

		if (is_dir('./installer'))
		{
			$this->template
				->set('messages', array('notice' => lang('cp_delete_installer_message')));
		}

		$this->template
			->build('admin/dashboard');
	}

	/**
	 * Log in
	 */
	public function login()
	{
		// Set the validation rules
		$this->validation_rules = array(
			array(
				'field' => 'email',
				'label' => lang('email_label'),
				'rules' => 'required|callback__check_login'
			),
			array(
				'field' => 'password',
				'label' => lang('password_label'),
				'rules' => 'required'
			)
		);

		// Call validation and set rules
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->validation_rules);

		// If the validation worked, or the user is already logged in
		if ($this->form_validation->run() OR $this->ion_auth->logged_in())
		{
			// if they were trying to go someplace besides the 
			// dashboard we'll have stored it in the session
			$redirect = $this->session->userdata('admin_redirect');
			$this->session->unset_userdata('admin_redirect');

			redirect($redirect ? $redirect : 'admin');
		}

		$this->template
			->set_layout(FALSE)
			->build('admin/login');
	}

	/**
	 * Logout
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
	 * @param string $email The Email address to validate
	 *
	 * @return bool
	 */
	public function _check_login($email)
	{
		if ($this->ion_auth->login($email, $this->input->post('password'), (bool)$this->input->post('remember')))
		{
			Events::trigger('post_admin_login');
			
			return true;
		}

		$this->form_validation->set_message('_check_login', $this->ion_auth->errors());
		return false;
	}

	/**
	 * Display the help string from a module's
	 * details.php file in a modal window
	 *
	 * @param	string	$slug	The module to fetch help for
	 *
	 * @return	void
	 */
	public function help($slug)
	{
		$this->template
			->set_layout('modal', 'admin')
			->set('help', $this->module_m->help($slug))
			->build('admin/partials/help');
	}
}