<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Increase_mime_length extends CI_Migration
{
	public function up()
	{
		$this->dbforge->modify_column('files', array(
			'mimetype' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false),
		));
	}

	public function down()
	{
		$this->dbforge->modify_column('files', array(
			'mimetype' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => false),
		));
	}
}