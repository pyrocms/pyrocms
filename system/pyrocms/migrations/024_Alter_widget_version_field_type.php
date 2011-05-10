<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_widget_version_field_type extends Migration {

	function up()
	{
		$this->dbforge->modify_column('widgets', array(
			'version' => array(
				'type' => 'varchar',
				'constraint' => 20,
				'null' => FALSE,
				'collation'	=> 'utf8_unicode_ci',
				'default' => '0'
			)			
		));
	}

	function down()
	{
		$this->dbforge->modify_column('widgets', array(
			'version' => array(
				'type'			=> 'int',
				'constraint'	=> '3',
				'null'			=> FALSE,
				'default' => '0'
			)			
		));
	}
}