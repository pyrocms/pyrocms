<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Remove_unique_chunks extends CI_Migration {

	public function up()
	{
		return $this->db->query('ALTER TABLE '.$this->db->dbprefix('page_chunks').' DROP KEY `unique - slug`');
	}

	public function down()
	{
		
	}
}