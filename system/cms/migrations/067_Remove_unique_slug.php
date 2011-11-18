<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Remove_unique_slug extends CI_Migration {

	public function up()
	{
		return $this->db->query('ALTER TABLE '.$this->db->dbprefix('pages').' DROP KEY `Unique`');
	}

	public function down()
	{
		
	}
}