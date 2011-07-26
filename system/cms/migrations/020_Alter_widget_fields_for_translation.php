<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_widget_fields_for_translation extends Migration {

	function up()
	{
		$this->dbforge->modify_column('widgets', array(
			'title' => array(
				'type'	=> 'TEXT',
				'null'	=> FALSE
			)			
		));
	}

	function down()
	{
		$this->dbforge->modify_column('widgets', array(
			'title' => array(
				'type'			=> 'VARCHAR',
				'constraint'	=> '100',
				'null'			=> FALSE
			)			
		));
	}
}