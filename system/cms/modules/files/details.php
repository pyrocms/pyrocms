<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Files module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Files
 */
class Module_Files extends Module {

	public $version = '2.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Files',
				'ar' => 'الملفّات',
				'br' => 'Arquivos',
				'pt' => 'Ficheiros',
				'cs' => 'Soubory',
				'da' => 'Filer',
				'de' => 'Dateien',
				'el' => 'Αρχεία',
				'es' => 'Archivos',
				'fi' => 'Tiedostot',
				'fr' => 'Fichiers',
				'he' => 'קבצים',
				'id' => 'File',
				'it' => 'File',
				'lt' => 'Failai',
				'nl' => 'Bestanden',
				'ru' => 'Файлы',
				'sl' => 'Datoteke',
				'zh' => '檔案',
				'hu' => 'Fájlok',
				'th' => 'ไฟล์',
                                'se' => 'Filer'
			),
			'description' => array(
				'en' => 'Manages files and folders for your site.',
				'ar' => 'إدارة ملفات ومجلّدات موقعك.',
				'br' => 'Permite gerenciar facilmente os arquivos de seu site.',
				'pt' => 'Permite gerir facilmente os ficheiros e pastas do seu site.',
				'cs' => 'Spravujte soubory a složky na vašem webu.',
				'da' => 'Administrer filer og mapper for dit site.',
				'de' => 'Verwalte Dateien und Verzeichnisse.',
				'el' => 'Διαχειρίζεται αρχεία και φακέλους για το ιστότοπό σας.',
				'es' => 'Administra archivos y carpetas en tu sitio.',
				'fi' => 'Hallitse sivustosi tiedostoja ja kansioita.',
				'fr' => 'Gérer les fichiers et dossiers de votre site.',
				'he' => 'ניהול תיקיות וקבצים שבאתר',
				'id' => 'Mengatur file dan folder dalam situs Anda.',
				'it' => 'Gestisci file e cartelle del tuo sito.',
				'lt' => 'Katalogų ir bylų valdymas.',
				'nl' => 'Beheer bestanden en mappen op uw website.',
				'ru' => 'Управление файлами и папками вашего сайта.',
				'sl' => 'Uredi datoteke in mape na vaši strani',
				'zh' => '管理網站中的檔案與目錄',
				'hu' => 'Fájlok és mappák kezelése az oldalon.',
				'th' => 'บริหารจัดการไฟล์และโฟลเดอร์สำหรับเว็บไซต์ของคุณ',
                                'se' => 'Hanterar filer och mappar för din webbplats.'
			),
			'frontend' => FALSE,
			'backend' => TRUE,
			'menu' => 'content',
			'roles' => array(
				'wysiwyg', 'upload', 'download_file', 'edit_file', 'delete_file', 'create_folder', 'set_location', 'synchronize', 'edit_folder', 'delete_folder'
			)
		);
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
				'name' => array('type' => 'VARCHAR', 'constraint' => 100,),
				'filename' => array('type' => 'VARCHAR', 'constraint' => 255,),
				'path' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
				'description' => array('type' => 'TEXT',),
				'extension' => array('type' => 'VARCHAR', 'constraint' => 5,),
				'mimetype' => array('type' => 'VARCHAR', 'constraint' => 50,),
				'width' => array('type' => 'INT', 'constraint' => 5, 'null' => true,),
				'height' => array('type' => 'INT', 'constraint' => 5, 'null' => true,),
				'filesize' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
				'download_count' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
				'date_added' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
				'sort' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
			),
			'file_folders' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'parent_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true, 'default' => 0,),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 100,),
				'name' => array('type' => 'VARCHAR', 'constraint' => 100,),
				'location' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => 'local',),
				'remote_container' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => '',),
				'date_added' => array('type' => 'INT', 'constraint' => 11,),
				'sort' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
			),
		);

		if ( ! $this->install_tables($tables))
		{
			return false;
		}

		return true;
	}

	public function uninstall()
	{
		// This is a core module, lets keep it around.
		return false;
	}

	public function upgrade($old_version)
	{
		return true;
	}

}