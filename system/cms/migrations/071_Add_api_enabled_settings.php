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

		// --------------------------
		// Add API Module
		// --------------------------
		
		if ( ! $this->db->limit(1)->where('slug', 'api')->get('modules')->num_rows())
		{
			$this->db->insert('modules', array(
				'slug' => 'api',
				'version' => '1.0',
				'name' => 'a:1:{s:2:"en";s:14:"API Management";}',
				'description' => 'a:1:{s:2:"en";s:66:"Set up a RESTful API with API Keys and out in JSON, XML, CSV, etc.";}',
				'is_frontend' => true,
				'is_backend' => true,
				'menu' => 'utilities',
				'enabled' => true,
				'is_core' => true,
				'installed' => true,
				'skip_xss' => false,
			));
		}

		// --------------------------
		// Add API Enabled Setting
		// --------------------------

		if ( ! $this->db->limit(1)->where('slug', 'api_enabled')->get('settings')->num_rows())
		{
			$this->db->insert('settings', array(
				'slug'			=> 'api_enabled',
				'title'			=> 'API Enabled',
				'description'	=> 'Allow API access to all modules which have an API controller.',
				'`default`' 	=> false,
				'type'			=> 'select',
				'`options`'		=> '0=Disabled|1=Enabled',
				'is_required'	=> false,
				'is_gui' 		=> false,
				'module' 		=> 'files'
			));
		}

		// --------------------------
		// Add API User Keys Setting
		// --------------------------
		
		if ( ! $this->db->limit(1)->where('slug', 'api_user_keys')->get('settings')->num_rows())
		{
			$this->db->insert('settings', array(
				'slug'			=> 'api_user_keys',
				'title'			=> 'API User Keys',
				'description'	=> 'Allow users to sign up for API keys (if the API is Enabled).',
				'`default`' 	=> false,
				'type'			=> 'select',
				'`options`'		=> '0=Disabled|1=Enabled',
				'is_required'	=> false,
				'is_gui' 		=> false,
				'module' 		=> 'files'
			));
		}
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