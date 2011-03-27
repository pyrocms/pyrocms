<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_page_order extends Migration {

	function up()
	{
		$this->dbforge->add_column('pages', array(
			'`order`' => array(
				'type' => 'int',
				'constraint' => 11,
				'null' => FALSE,
				'default' => 0
			)
		));
	}

	function down()
	{
		$this->dbforge->drop_column('pages', 'order');
	}
}