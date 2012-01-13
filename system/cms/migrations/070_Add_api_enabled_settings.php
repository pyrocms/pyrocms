<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_api_enabled_settings extends CI_Migration {

	public function up()
	{
		$this->dbforge->modify_column('settings', array(
			'value' => array(
				'name' => 'value',
				'type' => 'TEXT',
				'null' => true,
			),
		));
		
		$this->db->insert('modules', array(
			'slug' => 'api',
			'version' => '1.0',
			'name' => 'a:1:{s:2:"en";s:14:"API Management";}',
			'description' => 'a:1:{s:2:"en";s:66:"Set up a RESTful API with API Keys and out in JSON, XML, CSV, etc.";}',
			'is_frontend' => true,
			'is_backend' => true,
			'menu' => 'utilities',
			'enabled' => 1,
			'is_core' => 1,
			'installed' => 1,
		));
		
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

	public function down()
	{
		$this->db
			->where_in('slug', array('api_enabled', 'api_user_keys'))
			->delete('settings');
			
		$this->db
			->where('slug', 'api')
			->delete('modules');
	}
}