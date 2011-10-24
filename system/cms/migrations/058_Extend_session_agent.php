<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Extend_session_agent extends CI_Migration {

	public function up()
	{
		$this->db->query('ALTER TABLE '.$this->db->dbprefix('ci_sessions').' 
			CHANGE `user_agent` `user_agent` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_unicode_ci');
	}

	public function down()
	{
	}
}