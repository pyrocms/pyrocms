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
		$this->db->insert_batch('settings', array(
			array(
				'slug'			=> 'api_enabled',
				'title'			=> 'API Enabled',
				'description'	=> 'Allow API access to all modules which have an API controller.',
				'`default`' 	=> false,
				'type'			=> 'select',
				'`options`'		=> '0=Disabled|1=Enabled',
				'is_required'	=> false,
				'is_gui' 		=> false,
				'module' 		=> 'files'
			),
			array(
				'slug'			=> 'api_user_keys',
				'title'			=> 'API User Keys',
				'description'	=> 'Allow users to sign up for API keys (if the API is Enabled).',
				'`default`' 	=> false,
				'type'			=> 'select',
				'`options`'		=> '0=Disabled|1=Enabled',
				'is_required'	=> false,
				'is_gui' 		=> false,
				'module' 		=> 'files'
			),
		));
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