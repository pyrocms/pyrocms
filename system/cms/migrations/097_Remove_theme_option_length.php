<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Remove_theme_option_length extends CI_Migration
{
	public function up()
	{
		$this->dbforge->modify_column('theme_options', array(
			'options' => array('type' => 'TEXT'),
		));
	}

	public function down()
	{
		$this->dbforge->modify_column('theme_options', array(
			'options' => array('type' => 'VARCHAR', 'constraint' => 255),
		));
	}
}