<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_comment_blacklist_table extends CI_Migration {
	
	public function up()
	{
		$this->dbforge->add_field('id');
		$fields = array(
			'website' => array(
				'type' => 'VARCHAR',
				'constraint' => 255
				),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => 150
				),
			);
		$this->dbforge->add_field($fields);
		$this->dbforge->create_table('comment_blacklists');
	}

	public function down()
	{
		$this->dbforge->drop_table('comment_blacklists');
	}

}
