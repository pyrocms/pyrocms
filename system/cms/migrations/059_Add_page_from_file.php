<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_page_from_file extends CI_Migration {

	function up()
	{
		/* insert settings */
		$this->db->insert('settings', array(
			'slug'				=> 'save_pchunks_file',
			'title'				=> 'Save Page Chunks as File',
			'description'		=> 'This will save all pages chunks as files. When you request a page chunk (frontend or backend) PyroCMS will first load the database record. It will then check to see if a matching page chunk file exists in the "save page chunks as file folder". If a matching file is found it will replace the chunk data loaded from the database. When a page chunk is saved in the backend it will also save a copy to the "save page chunks as file folder".',
			'type'				=> 'radio',
			'default'			=> '0',
			'value'				=> '0',
			'options'			=> '1=Enabled|0=Disabled',
			'module'			=> '',
			'is_required'		=> 0,
			'is_gui'			=> 1,
			'order'				=> 201
		));

		$this->db->insert('settings', array(
			'slug'				=> 'save_pchunks_file_path',
			'title'				=> 'Save Page Chunks as File Folder Path',
			'description'		=> 'This folder is based off the root level of your website (where index.php is) and because this is optional it must be manually created. The access privileges must also be set up to allow read/write access.',
			'type'				=> 'text',
			'default'			=> '',
			'value'				=> '',
			'options'			=> '',
			'module'			=> '',
			'is_required'		=> 0,
			'is_gui'			=> 1,
			'order'				=> 200
		));

	}

	function down()
	{
		$this->db->delete('settings', array('slug' => 'save_pchunks_file'));
		$this->db->delete('settings', array('slug' => 'save_pchunks_file_path'));
	}
}