<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Files extends Module {

	public $version = '1.0';
	
	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Files',
				'pt' => 'Arquivos',
				'de' => 'Dateien',
				'nl' => 'Bestanden',
				'fr' => 'Fichiers',
				'zh' => '檔案',
				'it' => 'File',
				'ru' => 'Файлы',
				'ar' => 'الملفّات',
				'cs' => 'Soubory'
			),
			'description' => array(
				'en' => 'Manages files and folders for your site.',
				'pt' => 'Permite gerenciar facilmente os arquivos de seu site.',
				'de' => 'Verwalte Dateien und Verzeichnisse.',
				'nl' => 'Beheer bestanden en folders op uw website.',
				'fr' => 'Gérer les fichiers et dossiers de votre site.',
				'zh' => '管理網站中的檔案與目錄',
				'it' => 'Gestisci file e cartelle del tuo sito.',
				'ru' => 'Управление файлами и папками вашего сайта.',
				'ar' => 'إدارة ملفات ومجلّدات موقعك.',
				'cs' => 'Spravujte soubory a složky na vašem webu.'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => 'content'
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
		return "<h4>Overview</h4><hr>
		<p>The files module is an excellent way for the site admin to manage the files in use on the
		site. All images or files that are inserted into pages or blog posts are stored here. You may upload
		them directly from the WYSIWYG editor or you can upload them here and just insert them via WYSIWYG.</p>
		<h6>Managing Folders</h6>
		<p>After you create the top level folder or folders you may create as many subfolders as you need such as blog/images/screenshots/image.jpg
		and pages/audio/sample.mp3. The folder names are for your use only, the name is not displayed in the download link on the front end.
		To manage folders select Manage Folders in the left column, then click Edit on the folder you wish to change.</p>
		<h6>Managing Files</h6>
		<p>To upload or manage files select the folder name in the left column. If the file is in a subfolder just choose the parent. Once you are
		in the parent folder you can choose the subfolder and filter by file type with the dropdowns at the top of the screen.</p>";
	}
}
/* End of file details.php */
