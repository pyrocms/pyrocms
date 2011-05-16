<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_widget_fields extends Migration {

	function up()
	{
		$this->dbforge->add_column('widgets', array(
			'enabled' => array(
				'type'			=> 'tinyint',
				'constraint'	=> 1,
				'null'			=> FALSE,
				'default'		=> 1
			),
			'`order`' => array(
				'type'			=> 'int',
				'constraint'	=> 5,
				'null'			=> FALSE,
				'default'		=> 0
			)
		));

		$this->db->update('widgets', array('enabled' => 1));
	}

	function down()
	{
		$this->dbforge->drop_column('widgets', 'enabled');
		$this->dbforge->drop_column('widgets', 'order');
	}
}