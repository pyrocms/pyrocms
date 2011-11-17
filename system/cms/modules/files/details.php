<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Files extends Module {

	public $version = '1.2';

	public function info()
	{
		$info = array(
			'name' => array(
				'sl' => 'Datoteke',
				'en' => 'Files',
				'br' => 'Arquivos',
				'de' => 'Dateien',
				'nl' => 'Bestanden',
				'fr' => 'Fichiers',
				'zh' => '檔案',
				'it' => 'File',
				'ru' => 'Файлы',
				'ar' => 'الملفّات',
				'cs' => 'Soubory',
				'es' => 'Archivos',
				'fi' => 'Tiedostot',
				'el' => 'Αρχεία',
				'he' => 'קבצים',
				'lt' => 'Failai',
				'da' => 'Filer'
			),
			'description' => array(
				'sl' => 'Uredi datoteke in mape na vaši strani',
				'en' => 'Manages files and folders for your site.',
				'br' => 'Permite gerenciar facilmente os arquivos de seu site.',
				'de' => 'Verwalte Dateien und Verzeichnisse.',
				'nl' => 'Beheer bestanden en mappen op uw website.',
				'fr' => 'Gérer les fichiers et dossiers de votre site.',
				'zh' => '管理網站中的檔案與目錄',
				'it' => 'Gestisci file e cartelle del tuo sito.',
				'ru' => 'Управление файлами и папками вашего сайта.',
				'ar' => 'إدارة ملفات ومجلّدات موقعك.',
				'cs' => 'Spravujte soubory a složky na vašem webu.',
				'es' => 'Administra archivos y carpetas en tu sitio.',
				'fi' => 'Hallitse sivustosi tiedostoja ja kansioita.',
				'el' => 'Διαχειρίζεται αρχεία και φακέλους για το ιστότοπό σας.',
				'he' => 'ניהול תיקיות וקבצים שבאתר',
				'lt' => 'Katalogų ir bylų valdymas.',
				'da' => 'Administrer filer og mapper for dit site.'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => 'content',
			'roles' => array(
				'download_file', 'edit_file', 'delete_file', 'edit_folder', 'delete_folder'
			),
			'shortcuts' => array(
								 array(
									   'name' => 'files.files_title',
									   'uri' => 'admin/files',
									   ),
								 ),
			);
		
			if (function_exists('group_has_role') AND group_has_role('files', 'edit_file'))
			{
				$info['shortcuts'][] = array(
											 'name' => 'file_folders.create_title',
											 'uri' => 'admin/files/folders/create',
											 'class' => 'add folder-create'
											 );
				
				$info['shortcuts'][] = array(
											 'name' => 'files.upload_title',
											 'uri' => 'admin/files/upload',
											 'class' => 'files-uploader'
											 );
			}
			
			return $info;
	}

	public function install()
	{
		$this->dbforge->drop_table('files');
		$this->dbforge->drop_table('file_folders');

		$files = "
			CREATE TABLE " . $this->db->dbprefix('files') . " (
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
			CREATE TABLE " . $this->db->dbprefix('file_folders') . " (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `parent_id` int(11) DEFAULT '0',
			  `slug` varchar(100) NOT NULL,
			  `name` varchar(50) NOT NULL,
			  `date_added` int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";

		if( $this->db->query($files) &&
			$this->db->query($file_folders))
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
		return TRUE;
	}
}
/* End of file details.php */