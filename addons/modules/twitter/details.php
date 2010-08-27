<?php defined('BASEPATH') or exit('No direct script access allowed');

class Twitter_details extends Module {

	public $version = '0.2';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Twitter'
			),
			'description' => array(
				'en' => 'Show twitter posts and support general Twitter integration.'
			),
			'frontend' => FALSE,
			'backend' => FALSE,
			'menu' => FALSE
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