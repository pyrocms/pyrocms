<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_cp_access_flag_to_groups extends CI_Migration
{
	public function up()
	{
		$this->dbforge->add_column('groups', array(
			'has_cp_access' => array('type' => 'BOOLEAN', 'null' => false, 'default' => 1)
		));
	}

	public function down()
	{
		$this->dbforge->drop_column('groups', 'has_cp_access');
	}
}