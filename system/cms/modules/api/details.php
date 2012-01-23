<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Api extends Module
{
	public $version = '1.0.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'API Management',
			),
			'description' => array(
				'en' => 'Set up a RESTful API with API Keys and out in JSON, XML, CSV, etc.',
			),
			'frontend' => TRUE,
			'backend'  => TRUE,
			'menu'	  => 'utilities',
			
			'sections' => array(
			    'overview' => array(
				    'name' => 'api:overview',
				    'uri' => 'admin/api',
				),
				'keys' => array(
				    'name' => 'api:keys',
				    'uri' => 'admin/api/keys',
				    'shortcuts' => array(
						// array(
						//     'name' => 'cat_create_title',
						//     'uri' => 'admin/blog/categories/create',
						//     'class' => 'add'
						// ),
				    ),
			    ),
			),
		);
	}

	public function install()
	{
		return TRUE;
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