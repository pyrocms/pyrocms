<?php defined('BASEPATH') or exit('No direct script access allowed');

class Details_Twitter extends Module {

	public $version = '0.2';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Twitter',
				'de' => 'Twitter'
			),
			'description' => array(
				'en' => 'Show twitter posts and support general Twitter integration.',
				'de' => 'Zeigt Twitter Nachrichten und bietet die Twitter Integration.'
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