<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_auto_username_setting extends CI_Migration {

	public function up()
	{
		$this->db->insert('settings', array(
			'slug'			=> 'auto_username',
			'title'			=> 'Auto Username',
			'description'	=> 'Create the username automatically, meaning users can skip making one on registration.',
			'type'			=> 'radio',
			'default'		=> '0',
			'value'			=> '0',
			'options'		=> '1=Enabled|0=Disabled',
			'module'		=> 'users',
			'is_required'	=> 0,
			'is_gui'		=> 1,
			'order'			=> 1
		));
	}

	public function down()
	{
		$this->db->delete('settings', array('slug' => 'auto_username'));
	}
}