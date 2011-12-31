<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Api extends Module
{
	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'API Management',
			),
			'description' => array(
				'en' => 'Set up a RESTful API with API Keys and out in JSON, XML, CSV, etc.',
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => 'utilities',
		);
	}

	public function install()
	{
		// Do nothing! We will add tables in the backend as features are enabled
	}

	public function uninstall()
	{
		//it's a core module, lets keep it around
		return FALSE;
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
		return "No documentation has been added for this module.";
	}
}
/* End of file details.php */