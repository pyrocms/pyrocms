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
				'da' => 'Filer',
				'id' => 'File'
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
				'da' => 'Administrer filer og mapper for dit site.',
				'id' => 'Mengatur file dan folder dalam situs Anda.'
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

		$tables = array(
			'files' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'folder_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
				'user_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 1,),
				'type' => array('type' => 'ENUM', 'constraint' => array('a', 'v', 'd', 'i', 'o'), 'null' => true, 'default' => null,),
				'name' => array('type' => 'VARCHAR', 'constraint' => 255,),
				'filename' => array('type' => 'VARCHAR', 'constraint' => 255,),
				'description' => array('type' => 'VARCHAR', 'constraint' => 255,),
				'extension' => array('type' => 'VARCHAR', 'constraint' => 5,),
				'mimetype' => array('type' => 'VARCHAR', 'constraint' => 255,),
				'width' => array('type' => 'INT', 'constraint' => 5, 'null' => true,),
				'height' => array('type' => 'INT', 'constraint' => 5, 'null' => true,),
				'filesize' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
				'date_added' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
				'sort' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
			),
			'file_folders' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'parent_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true, 'default' => 0,),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 100,),
				'name' => array('type' => 'VARCHAR', 'constraint' => 50,),
				'date_added' => array('type' => 'INT', 'constraint' => 11,),
				'sort' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
			),
		);
		$this->install_tables($tables);
		
		return TRUE;
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
