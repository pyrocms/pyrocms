<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Index_profile_table extends CI_Migration {

	public function up()
	{
		$this->db->query('ALTER TABLE '.$this->db->dbprefix('users').' ENGINE = InnoDB');
		$this->db->query('ALTER TABLE '.$this->db->dbprefix('profiles').' ADD INDEX `user_id` ( `user_id` )');
		$this->db->query('ALTER TABLE '.$this->db->dbprefix('profiles').' ENGINE = InnoDB');
	}

	public function down()
	{
	}
}