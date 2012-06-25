<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Extend_session_agent extends CI_Migration {

	public function up()
	{
		$this->db->query('ALTER TABLE '.$this->db->dbprefix('ci_sessions').' 
			MODIFY user_agent VARCHAR(120)');
	}

	public function down()
	{
	}
}