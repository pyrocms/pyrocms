<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_file_sort_column extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('file_folders', array(
			'sort' => array(
				'type'			=> 'int',
				'constraint'	=> 11,
				'null'			=> false,
				'default'		=> 0
			)
		));

		$this->dbforge->add_column('files', array(
			'sort' => array(
				'type'			=> 'int',
				'constraint'	=> 11,
				'null'			=> false,
				'default'		=> 0
			)
		));
	}

	public function down()
	{
		$this->dbforge->drop_column('file_folders', 'sort');
		$this->dbforge->drop_column('files', 'sort');
	}
}