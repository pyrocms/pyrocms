<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_page_restrictions extends Migration {

	function up()
	{
		$this->dbforge->add_column('pages', array(
			'restricted_to' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => TRUE,
				'collation' => 'utf8_unicode_ci'
			)
		));

		$this->pyrocache->delete_all('pages_m');
	}

	function down()
	{
		$this->dbforge->drop_column('pages', 'restricted_to');
		
		$this->pyrocache->delete_all('pages_m');
	}
}