<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_session_sql extends CI_Migration {

	public function up()
	{
		$session = "
			CREATE TABLE IF NOT EXISTS ".$this->db->dbprefix(str_replace('default_', '', config_item('sess_table_name')))." (
			 `session_id` varchar(40) DEFAULT '0' NOT NULL,
			 `ip_address` varchar(16) DEFAULT '0' NOT NULL,
			 `user_agent` varchar(120) NOT NULL,
			 `last_activity` int(10) unsigned DEFAULT 0 NOT NULL,
			 `user_data` text null,
			PRIMARY KEY (`session_id`),
			KEY `last_activity_idx` (`last_activity`)
			);
		";
		
		// create a session table so they can use it if they want
		$this->db->query($session);
	}

	public function down()
	{
		$this->db->query("DROP TABLE IF EXISTS ".$this->db->dbprefix(str_replace('default_', '', config_item('sess_table_name'))));
	}
}