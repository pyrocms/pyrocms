<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once('installer.php');

class Quick_Installer extends Installer
{

	public function index()
	{
		// List of variables we want to grab
		$variables = array(
			'database', 'hostname', 'username', 'password', 'port', 'http_server',
			'site_ref', 'user_name', 'user_firstname', 'user_lastname', 'user_email', 
			'user_password'
		);

		// Check environment variables first, post second
		foreach ($variables as $var)
		{
			$_POST[$var] = isset($_SERVER['pyrocms_'.$var]) ? $_SERVER['pyrocms_'.$var] : $this->input->post($var);
		}

		// Save this junk for later
		$this->session->set_userdata(array(
			'database' => $this->input->post('database'),
			'hostname' => $this->input->post('hostname'),
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'port' => $this->input->post('port'),
			'http_server' => $this->input->post('http_server')
		));

		// Install everything
		$install = $this->installer_lib->install($_POST);

		// Did the install fail?
		if ($install['status'] === false)
		{
			// Let's tell them why the install failed
			echo $this->lang->line('error_'.$install['code']).$install['message'];
			exit(1);
		}

		// Store the default username and password in the session data
		$this->session->set_userdata('user', array(
			'user_email' => $this->input->post('user_email'),
			'user_password' => $this->input->post('user_password'),
			'user_firstname' => $this->input->post('user_firstname'),
			'user_lastname' => $this->input->post('user_lastname')
		));

		// Define the default user email to be used in the settings module install
		define('DEFAULT_EMAIL', $this->input->post('user_email'));

		// Import the modules
		$this->load->library('module_import');
		$this->module_import->import_all();
	}

}