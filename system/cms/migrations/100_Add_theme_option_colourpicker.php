<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_theme_option_colourpicker extends CI_Migration
{
	public function up()
	{
		$this->dbforge->modify_column('theme_options', array(
			'type' => array('type' => "SET('text','textarea','password','select','select-multiple','radio','checkbox','colour-picker')", 'null' => false),
		));
	}
	
	public function down()
	{
		$this->dbforge->modify_column('theme_options', array(
			'type' => array('type' => "SET('text','textarea','password','select','select-multiple','radio','checkbox')", 'null' => false),
		));
	}
}