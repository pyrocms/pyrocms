<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Maintenance Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Maintenance
 */
class Module_Maintenance extends Module
{

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Maintenance',
				'ar' => 'الصيانة',
				'el' => 'Συντήρηση',
				'hu' => 'Karbantartás',
				'fi' => 'Ylläpito',
				'fr' => 'Maintenance',
				'id' => 'Pemeliharaan',
				'se' => 'Underhåll',
				'zh' => '維護',
			),
			'description' => array(
				'en' => 'Manage the site cache and export information from the database.',
				'ar' => 'حذف عناصر الذاكرة المخبأة عبر واجهة الإدارة.',
				'el' => 'Διαγραφή αντικειμένων προσωρινής αποθήκευσης μέσω της περιοχής διαχείρισης.',
				'id' => 'Mengatur cache situs dan mengexport informasi dari database.',
				'fr' => 'Gérer le cache du site et exporter les contenus de la base de données',
				'fi' => 'Hallinoi sivuston välimuistia ja vie tietoa tietokannasta.',
				'hu' => 'Az oldal gyorsítótár kezelése és az adatbázis exportálása.',
				'se' => 'Underhåll webbplatsens cache och exportera data från webbplatsens databas.',
				'zh' => '經由管理介面手動刪除暫存資料。',
			),
			'frontend' => false,
			'backend' => true,
			'menu' => 'utilities'
		);
	}


	public function install()
	{
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
