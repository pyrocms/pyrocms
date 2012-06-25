<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Remove_unique_chunks_again extends CI_Migration {

	public function up()
	{
		$current = $this->db->query('SHOW CREATE TABLE '.$this->db->dbprefix('page_chunks'))->result();
		
		// This is some hackery to make sure the unique key exists before we try to drop it.
		// Somehow we got migration 32 that drops the unique key but the unique key was still added upon install.
		// So we have no way of knowing if the installation has unique slug or not
		if (strpos($current[0]->{'Create Table'}, 'unique - slug'))
		{
			return $this->db->query('ALTER TABLE '.$this->db->dbprefix('page_chunks').' DROP KEY `unique - slug`');
		}
	}

	public function down()
	{
		
	}
}