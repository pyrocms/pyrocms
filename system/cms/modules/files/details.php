<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Files module
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Files
 */
class Module_Files extends Module
{

	public $version = '2.0.0';

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
				'id' => array('type' => 'CHAR', 'constraint' => 15, 'primary' => true,),
				'folder_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
				'user_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 1,),
				'type' => array('type' => 'ENUM', 'constraint' => array('a', 'v', 'd', 'i', 'o'), 'null' => true, 'default' => null,),
				'name' => array('type' => 'VARCHAR', 'constraint' => 100,),
				'filename' => array('type' => 'VARCHAR', 'constraint' => 255,),
				'path' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
				'description' => array('type' => 'TEXT',),
				'extension' => array('type' => 'VARCHAR', 'constraint' => 10,),
				'mimetype' => array('type' => 'VARCHAR', 'constraint' => 100,),
				'keywords' => array('type' => 'CHAR', 'constraint' => 32, 'default' => ''),
				'width' => array('type' => 'INT', 'constraint' => 5, 'null' => true,),
				'height' => array('type' => 'INT', 'constraint' => 5, 'null' => true,),
				'filesize' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
				'alt_attribute' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
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
				'hidden' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0,),
			),
		);

		if ( ! $this->install_tables($tables))
		{
			return false;
		}

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
				'is_required' => 1,
				'is_gui' => 1,
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
				'is_gui' => 1,
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
				'is_required' => 0,
				'is_gui' => 1,
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
				'is_required' => 0,
				'is_gui' => 1,
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
				'is_required' => 1,
				'is_gui' => 1,
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
				'is_required' => 0,
				'is_gui' => 1,
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
				'is_required' => 0,
				'is_gui' => 1,
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
				'is_required' => 0,
				'is_gui' => 1,
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
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 987,
			),
		);

		foreach ($settings as $setting)
		{
			if ( ! $this->db->insert('settings', $setting))
			{
				return false;
			}
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
