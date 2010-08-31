<?php defined('BASEPATH') or exit('No direct script access allowed');

class Files_details extends Module {

	public $version = '1.0';
	
	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Files',
				'br' => 'Files',
				'de' => 'Dateien'
			),
			'description' => array(
				'en' => 'Manages files and folders for your site.',
				'br' => 'Permite gerenciar facilmente os arquivos de seu site.',
				'de' => 'Verwalte Dateien und Verzeichnisse.'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => TRUE,
			'controllers' => array(
				'admin' => array('index', 'edit', 'delete')
			)
		);
	}
	
	public function install()
	{
		$this->dbforge->drop_table('files');
		$this->dbforge->drop_table('file_folders');
		
		$files = "
			CREATE TABLE `files` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `folder_id` int(11) NOT NULL DEFAULT '0',
			  `user_id` int(11) NOT NULL DEFAULT '1',
			  `type` enum('a','v','d','i','o') COLLATE utf8_unicode_ci DEFAULT NULL,
			  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `extension` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
			  `mimetype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `width` int(5) DEFAULT NULL,
			  `height` int(5) DEFAULT NULL,
			  `filesize` int(11) NOT NULL DEFAULT 0,
			  `date_added` int(11) NOT NULL DEFAULT 0,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";
		
		$file_folders = "
			CREATE TABLE `file_folders` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `parent_id` int(11) DEFAULT '0',
			  `slug` varchar(100) NOT NULL,
			  `name` varchar(50) NOT NULL,
			  `date_added` int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";

		if($this->db->query($files) && $this->db->query($file_folders))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		//it's a core module, lets keep it around
		return FALSE;
	}

	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}
	
	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "Some Help Stuff";
	}
}
/* End of file details.php */