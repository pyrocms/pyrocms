<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Remove_unique_slug extends CI_Migration {

	public function up()
	{
		$current = $this->db->query('SHOW CREATE TABLE '.$this->db->dbprefix('pages'))->result();

		// Make sure the unique key exists before we try to drop it.
		if (strpos($current[0]->{'Create Table'}, 'UNIQUE KEY'))
		{
			return $this->db->query('ALTER TABLE '.$this->db->dbprefix('pages').' DROP KEY `Unique`');
		}
	}

	public function down()
	{
		
	}
}