<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_page_from_file extends Migration {

	function up()
	{
		$this->migrations->verbose AND print "Added settings - save pages as files.";

		/* insert settings */
		$this->db->insert('settings', array(
			'slug'				=> 'save_page_as_file',
			'title'				=> 'Save Page as File',
			'description'		=> 'This will save all pages entries as files. When you request a page pyrocms will first check to see if this pages exists in the template folder.
			If found it will load the file.
			if not it will default back to the database version.
			When a page is saved in the gui it will save it to the file system.
			When a page is loaded for the gui it will first check the file system then default back to the database if the page isn\'t found.',
			'type'				=> 'radio',
			'default'			=> '0',
			'value'				=> '0',
			'options'			=> '1=Enabled|0=Disabled',
			'module'			=> '',
			'is_required'		=> 0,
			'is_gui'			=> 1,
			'order'				=> 200
		));

		$this->db->insert('settings', array(
			'slug'				=> 'save_page_as_file_folder_path',
			'title'				=> 'Save Page as File Folder Path',
			'description'		=> 'This folder is based off the root level of your website and must be manually created. The access privileges must be set up to allow read/write access',
			'type'				=> 'text',
			'default'			=> '',
			'value'				=> '',
			'options'			=> '',
			'module'			=> '',
			'is_required'		=> 0,
			'is_gui'			=> 1,
			'order'				=> 201
		));

	}

	function down()
	{
		$this->db->delete('settings', array('slug' => 'save_page_as_file'));
		$this->db->delete('settings', array('slug' => 'save_page_as_file_folder_path'));
	}
}