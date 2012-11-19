<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Files module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Files
 */
class Module_Files extends Module {

	public $version = '2.1.0';

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
				'se' => 'Filer',
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
				'se' => 'Hanterar filer och mappar för din webbplats.',
			),
			'frontend' => false,
			'backend' => true,
			'menu' => 'content',
			'roles' => array(
				'wysiwyg', 'upload', 'download_file', 'edit_file', 'delete_file', 'create_folder',
				'set_location', 'synchronize', 'edit_folder', 'delete_folder',
			)
		);
	}

	public function install()
	{
		$schema = $this->pdb->getSchemaBuilder();

		$schema->drop('files');
		$schema->drop('file_folders');

		$schema->create('files', function($table) { 
			$table->increments('id');
			$table->integer('folder_id');
			$table->integer('user_id');
			$table->enum('type', array('a', 'v', 'd', 'i', 'o'));
			$table->string('name', 100);
			$table->string('filename', 255);
			$table->string('path', 255);
			$table->text('description');
			$table->string('extension', 10);
			$table->string('mimetype', 100);
			$table->string('keywords', 32)->nullable();
			$table->integer('width', 5)->nullable();
			$table->integer('height', 5)->nullable();
			$table->integer('filesize')->nullable();
			$table->integer('download_count')->default(0);
			$table->integer('date_added', 11);
			$table->integer('sort')->default(0);
			
			$table->key('folder_id');
		});

		$schema->create('file_folders', function($table) { 
			$table->increments('id');
			$table->integer('parent_id')->nullable();
			$table->string('slug', 100);
			$table->string('name', 100);
			$table->string('location', 20)->default('local');
			$table->string('remote_container', 100)->nullable();,
			$table->integer('date_added', 11);
			$table->integer('sort')->default(0);

			$table->key('folder_id');
		});

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