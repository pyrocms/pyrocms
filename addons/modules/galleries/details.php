<?php defined('BASEPATH') or exit('No direct script access allowed');

class Galleries_details extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Galleries'
			),
			'description' => array(
				'en' => 'The galleries module is a powerful module that let\'s users create image galleries.'
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => TRUE
		);
	}

	public function install()
	{
		// Your Install Logic
		return TRUE;
	}

	public function uninstall()
	{
		// Your Uninstall Logic
		return TRUE;
	}

	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "Some Help Stuff";
	}
}
/* End of file details.php */