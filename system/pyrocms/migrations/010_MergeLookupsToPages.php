<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Mergelookupstopages extends Migration {

	function up()
	{
		$this->db->query("
		ALTER TABLE `pages`
			ADD `uri` TEXT NULL AFTER title");

		// Move the lookups that we have over to the pages table
		foreach ($this->db->get('pages_lookup')->result() as $lookup)
		{
			$this->db->update('pages', array(
				'uri' => $lookup->path
			), array(
				'id' => $lookup->id
			));
		}

		// Build any lookups that are still missing
		foreach ($this->db->where('uri', NULL)->get('pages')->result() as $item)
		{
			$current_id = $item->id;
	
			$segments = array();
			do
			{
				$page = $this->db
					->select('slug, parent_id')
					->where('id', $current_id)
					->get('pages')
					->row();
	
				$current_id = $page->parent_id;
				array_unshift($segments, $page->slug);
			}
			while( $page->parent_id > 0 );
	
			// If the URI has been passed as a string, explode to create an array of segments
			$this->db
				->where('id', $item->id)
				->set('uri', implode('/', $segments))
				->update('pages');
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