<?php  defined('BASEPATH') or exit('No direct script access allowed');

class Files_details extends Module {

	public $version = '1.0';
	
	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Files'
			),
			'description' => array(
				'en' => 'Manages files and folders for your site'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => TRUE
			'controllers' => array(
				'admin' => array('index', 'edit', 'delete')
			)
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