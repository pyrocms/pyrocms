<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_session_sql extends Migration {

	function up()
	{
		$this->migrations->verbose AND print "Added database table for CI sessions.";

		$session = "
			CREATE TABLE IF NOT EXISTS ".$this->db->dbprefix(str_replace('default_', '', config_item('sess_table_name')))." (
			 `session_id` varchar(40) DEFAULT '0' NOT NULL,
			 `ip_address` varchar(16) DEFAULT '0' NOT NULL,
			 `user_agent` varchar(50) NOT NULL,
			 `last_activity` int(10) unsigned DEFAULT 0 NOT NULL,
			 `user_data` text NULL,
			PRIMARY KEY (`session_id`)
			);
		";
		
		// create a session table so they can use it if they want
		$this->db->query($session);
	}

	function down()
	{
		$this->db->query("DROP TABLE IF EXISTS ".$this->db->dbprefix(str_replace('default_', '', config_item('sess_table_name'))));
	}
}