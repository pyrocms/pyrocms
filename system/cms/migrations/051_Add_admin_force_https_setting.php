<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_admin_force_https_setting extends CI_Migration {

	public function up()
	{
		$this->db->insert('settings', array(
			'slug'			=> 'admin_force_https',
			'title'			=> 'Force HTTPS for Control Panel?',
			'description'	=> 'Allow only the HTTPS protocol when using the Control Panel?',
			'type'			=> 'radio',
			'default'		=> '0',
			'value'			=> '0',
			'options'		=> '1=Yes|0=No',
			'module'		=> '',
			'is_required'	=> 0,
			'is_gui'		=> 1,
			'order'			=> 5
		));
	}

	public function down()
	{
		$this->db->delete('settings', array('slug' => 'admin_force_https'));
	}
}