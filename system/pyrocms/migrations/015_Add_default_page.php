<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_default_page extends Migration {

	function up()
	{
		$this->dbforge->add_column('pages', array(
			'is_home' => array(
				'type' => 'tinyint',
				'constraint' => 1,
				'null' => FALSE,
				'default' => 0
			)
		));

		$this->db
			->where('slug', 'home')
			->update('pages', array('is_home' => 1));

		$this->pyrocache->delete_all('pages_m');
	}

	function down()
	{
		$this->dbforge->drop_column('pages', 'is_home');
		
		$this->pyrocache->delete_all('pages_m');
	}
}