<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_CreateContactPage extends Migration {
	
	function up() 
	{
		$not_exists = $this->db
			->where('slug', 'contact')
			->count_all_results('pages') == 0;

		if ($not_exists === TRUE)
		{
			// Versioning
			$this->load->library('versioning');
			$this->versioning->set_table('pages');

			$this->load->model('pages/pages_m');

			$id = $this->pages_m->create(array(
				'slug' 			=> 'contact',
				'title' 		=> 'Contact',
				'parent_id'		=> 0,
				'layout_id'		=> 1,
				'css'			=> '',
				'js'			=> '',
				'meta_title'	=> 'Contact Us',
				'meta_keywords'	=> '',
				'meta_description' => '',
				'status' 		=> 'live',
			));

			// Create the revision
			$revision_id = $this->versioning->create_revision(array('author_id' => 1, 'owner_id' => $id, 'body' => '{pyro:contact:form}'));

			$this->db->where('id', $id);
			$this->db->update('pages', array('revision_id' => $revision_id));

			$this->cache->delete_all('pages_m');
		}
	}

	function down() 
	{
	}
}
