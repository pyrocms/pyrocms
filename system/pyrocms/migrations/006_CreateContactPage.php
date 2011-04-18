<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Createcontactpage extends Migration {
	
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

			$this->load->model(array('navigation/navigation_m'));
			
			$this->db->insert('pages', array(
				'slug' 			=> 'contact',
				'title' 		=> 'Contact',
				'parent_id'		=> 0,
				'layout_id'		=> 1,
				'css'			=> '',
				'js'			=> '',
				'meta_title'	=> 'Contact Us',
				'meta_keywords'	=> '',
				'meta_description' => '',
				'status' 		=> 'live'
			));
			
			$id = $this->db->insert_id();

			// Create the revision
			$revision_id = $this->versioning->create_revision(array('author_id' => 1, 'owner_id' => $id, 'body' => '<p>To contact us please fill out the form below.</p> {pyro:contact:form}'));

			$this->db->where('id', $id);
			$this->db->update('pages', array('revision_id' => $revision_id));

			// Create navigation link
			$this->navigation_m->insert_link(array(
				'title' 				=> 'Contact',
				'link_type' 			=> 'page',
				'module_name' 			=> '',
				'page_id' 				=> $id,
				'navigation_group_id'	=> 1
			));

			$this->pyrocache->delete_all('pages_m');
			$this->pyrocache->delete_all('navigation_m');
		}
	}

	function down() 
	{
	}
}
