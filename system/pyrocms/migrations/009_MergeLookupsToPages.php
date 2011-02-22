<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_MergeLookupsToPages extends Migration {

	function up()
	{
		$this->db->query("
		ALTER TABLE `pages`
			ADD `uri` TEXT NULL AFTER title");

		foreach ($this->db->get('pages_lookup')->result() as $lookup)
		{
			$this->db->update('pages', array(
				'uri' => $lookup->path
			), array(
				'id' => $lookup->id
			));
		}

		$this->dbforge->drop_table('pages_lookup');
	}

	function down()
	{
		$this->db->query("
			ALTER TABLE `pages`
				DROP `uri`");
	}

}