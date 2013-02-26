<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Remove_theme_option_length extends CI_Migration
{
	public function up()
	{
		$this->dbforge->modify_column('theme_options', array(
			'options' => array('type' => 'TEXT'),
		));
		
		// Snuck in a fix for IPv6 support
		$this->dbforge->modify_column('ci_sessions', array(
			'ip_address' => array(
				'type' => 'VARCHAR',
				'constraint' => 45,
				'null' => false
			)
		));
	}

	public function down()
	{
		$this->dbforge->modify_column('theme_options', array(
			'options' => array('type' => 'VARCHAR', 'constraint' => 255),
		));
	}
}
