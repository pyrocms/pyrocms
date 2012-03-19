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
				'fr' => 'Maintenance',
				'id' => 'Pemeliharaan',
				'zh' => '維護',
				'hu' => 'Karbantartás',
				'fi' => 'Ylläpito',
                                'se' => 'Underhåll'
			),
			'description' => array(
				'en' => 'Manage the site cache and export information from the database.',
				'ar' => 'حذف عناصر الذاكرة المخبأة عبر واجهة الإدارة.',
				'el' => 'Διαγραφή αντικειμένων προσωρινής αποθήκευσης μέσω της περιοχής διαχείρισης.',
				'fr' => 'Gérer le cache du site et exporter les contenus de la base de données',
				'id' => 'Mengatur cache situs dan mengexport informasi dari database.',
				'zh' => '經由管理介面手動刪除暫存資料。',
				'hu' => 'Az oldal gyorsítótár kezelése és az adatbázis exportálása.',
				'fi' => 'Hallinoi sivuston välimuistia ja vie tietoa tietokannasta.',
                                'se' => 'Underhåll webbplatsens cache och exportera data från webbplatsens databas.'
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
