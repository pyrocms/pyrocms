<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_comment_expiry extends CI_Migration
{
	public function up()
	{
		$this->dbforge->modify_column('blog', array(
			'comments_enabled' => array(
				'type' => 'set',
				'constraint' => array('no','1 day','1 week','2 weeks','1 month', '3 months', 'always'),
				'null' => false,
				'default' => 'always',
			),
		));

		$this->db->update('blog', array('comments_enabled' => '3 months'));
	}
	
	public function down()
	{
		$this->dbforge->modify_column('blog', array(
			'comments_enabled' => array(
				'type' => "tinyint",
				'constraint' => 1,
				'null' => false,
				'default' => 1
			),
		));
	}
}