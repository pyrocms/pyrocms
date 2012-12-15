<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Files module
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Files
 */
class Module_Files extends Module
{
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
				'tw' => '檔案',
				'cn' => '档案',
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
				'tw' => '管理網站中的檔案與目錄',
				'cn' => '管理网站中的档案与目录',
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

		$schema->dropIfExists('files');
		$schema->dropIfExists('file_folders');

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
			$table->integer('width')->nullable();
			$table->integer('height')->nullable();
			$table->integer('filesize')->nullable();
			$table->integer('alt_attribute')->nullable();
			$table->integer('download_count')->default(0);
			$table->integer('date_added');
			$table->integer('sort')->default(0);
			
			$table->index('folder_id');
		});

		$schema->create('file_folders', function($table) { 
			$table->increments('id');
			$table->integer('parent_id')->nullable();
			$table->string('slug', 100);
			$table->string('name', 100);
			$table->string('location', 20)->default('local');
			$table->string('remote_container', 100)->nullable();
			$table->integer('date_added');
			$table->integer('sort')->default(0);
		});

		// Install the settings
		$settings = array(
			array(
				'slug' => 'files_cache',
				'title' => 'Files Cache',
				'description' => 'When outputting an image via site.com/files what shall we set the cache expiration for?',
				'type' => 'select',
				'default' => '480',
				'value' => '480',
				'options' => '0=no-cache|1=1-minute|60=1-hour|180=3-hour|480=8-hour|1440=1-day|43200=30-days',
				'is_required' => true,
				'is_gui' => true,
				'module' => 'files',
				'order' => 986,
			),
			array(
				'slug' => 'files_enabled_providers',
				'title' => 'Enabled File Storage Providers',
				'description' => 'Which file storage providers do you want to enable? (If you enable a cloud provider you must provide valid auth keys below',
				'type' => 'checkbox',
				'default' => '0',
				'value' => '0',
				'options' => 'amazon-s3=Amazon S3|rackspace-cf=Rackspace Cloud Files',
				'is_required' => false,
				'is_gui' => true,
				'module' => 'files',
				'order' => 994,
			),
			array(
				'slug' => 'files_s3_access_key',
				'title' => 'Amazon S3 Access Key',
				'description' => 'To enable cloud file storage in your Amazon S3 account provide your Access Key. <a href="https://aws-portal.amazon.com/gp/aws/securityCredentials#access_credentials">Find your credentials</a>',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => false,
				'is_gui' => true,
				'module' => 'files',
				'order' => 993,
			),
			array(
				'slug' => 'files_s3_secret_key',
				'title' => 'Amazon S3 Secret Key',
				'description' => 'You also must provide your Amazon S3 Secret Key. You will find it at the same location as your Access Key in your Amazon account.',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => false,
				'is_gui' => true,
				'module' => 'files',
				'order' => 992,
			),
			array(
				'slug' => 'files_s3_geographic_location',
				'title' => 'Amazon S3 Geographic Location',
				'description' => 'Either US or EU. If you change this you must also change the S3 URL.',
				'type' => 'radio',
				'default' => 'US',
				'value' => 'US',
				'options' => 'US=United States|EU=Europe',
				'is_required' => true,
				'is_gui' => true,
				'module' => 'files',
				'order' => 991,
			),
			array(
				'slug' => 'files_s3_url',
				'title' => 'Amazon S3 URL',
				'description' => 'Change this if using one of Amazon\'s EU locations or a custom domain.',
				'type' => 'text',
				'default' => 'http://{{ bucket }}.s3.amazonaws.com/',
				'value' => 'http://{{ bucket }}.s3.amazonaws.com/',
				'options' => '',
				'is_required' => false,
				'is_gui' => true,
				'module' => 'files',
				'order' => 991,
			),

			array(
				'slug' => 'files_cf_username',
				'title' => 'Rackspace Cloud Files Username',
				'description' => 'To enable cloud file storage in your Rackspace Cloud Files account please enter your Cloud Files Username. <a href="https://manage.rackspacecloud.com/APIAccess.do">Find your credentials</a>',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => false,
				'is_gui' => true,
				'module' => 'files',
				'order' => 990,
			),
			array(
				'slug' => 'files_cf_api_key',
				'title' => 'Rackspace Cloud Files API Key',
				'description' => 'You also must provide your Cloud Files API Key. You will find it at the same location as your Username in your Rackspace account.',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => false,
				'is_gui' => true,
				'module' => 'files',
				'order' => 989,
			),
			array(
				'slug' => 'files_upload_limit',
				'title' => 'Filesize Limit',
				'description' => 'Maximum filesize to allow when uploading. Specify the size in MB. Example: 5',
				'type' => 'text',
				'default' => '5',
				'value' => '5',
				'options' => '',
				'is_required' => true,
				'is_gui' => true,
				'module' => 'files',
				'order' => 987,
			),
		);

		return $this->pdb->table('settings')->insert($settings);
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