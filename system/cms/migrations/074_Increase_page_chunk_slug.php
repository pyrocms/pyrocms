<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Increase_page_chunk_slug extends CI_Migration {

	public function up()
	{
		$this->dbforge->modify_column('page_chunks', array(
			'slug' => array(
				'name' => 'slug',
				'type' => 'varchar',
				'constraint' => 255,
				'null' => false,
				'default' => '',
			),
		));
	}

	public function down()
	{
		$this->dbforge->modify_column('page_chunks', array(
			'slug' => array(
				'name' => 'slug',
				'type' => 'varchar',
				'constraint' => 30,
				'null' => true,
			),
		));
	}
}