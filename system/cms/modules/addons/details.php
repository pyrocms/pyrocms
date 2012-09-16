<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Addons Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Modules
 */
class Module_Addons extends Module
{
	public $version = '2.0.0';

	public function info()
	{
		$info = array(
			'name' => array(
				'en' => 'Add-ons',
				'ar' => 'الإضافات',
				'br' => 'Complementos',
				'pt' => 'Complementos',
				'cs' => 'Doplňky',
				'da' => 'Add-ons',
				'de' => 'Erweiterungen',
				'el' => 'Πρόσθετα',
				'es' => 'Agregados',
				'fi' => 'Lisäosat',
				'fr' => 'Extensions',
				'he' => 'תוספות',
				'id' => 'Pengaya',
				'it' => 'Add-ons',
				'lt' => 'Priedai',
				'nl' => 'Add-ons',
				'pl' => 'Rozszerzenia',
				'ru' => 'Дополнения',
				'sl' => 'Razširitve',
				'zh' => '附加模組',
				'hu' => 'Bővítmények',
				'th' => 'ส่วนเสริม',
            	'se' => 'Add-ons',
			),
			'description' => array(
				'en' => 'Allows admins to see a list of currently installed modules.',
				'ar' => 'تُمكّن المُدراء من معاينة جميع الوحدات المُثبّتة.',
				'br' => 'Permite aos administradores ver a lista dos módulos instalados atualmente.',
				'pt' => 'Permite aos administradores ver a lista dos módulos instalados atualmente.',
				'cs' => 'Umožňuje administrátorům vidět seznam nainstalovaných modulů.',
				'da' => 'Lader administratorer se en liste over de installerede moduler.',
				'de' => 'Zeigt Administratoren alle aktuell installierten Module.',
				'el' => 'Επιτρέπει στους διαχειριστές να προβάλουν μια λίστα των εγκατεστημένων πρόσθετων.',
				'es' => 'Permite a los administradores ver una lista de los módulos instalados.',
				'fi' => 'Listaa järjestelmänvalvojalle käytössä olevat moduulit.',
				'fr' => 'Permet aux administrateurs de voir la liste des modules installés',
				'he' => 'נותן אופציה למנהל לראות רשימה של המודולים אשר מותקנים כעת באתר או להתקין מודולים נוספים',
				'id' => 'Memperlihatkan kepada admin daftar modul yang terinstall.',
				'it' => 'Permette agli amministratori di vedere una lista dei moduli attualmente installati.',
				'lt' => 'Vartotojai ir svečiai gali komentuoti jūsų naujienas, puslapius ar foto.',
				'nl' => 'Stelt admins in staat om een overzicht van geinstalleerde modules te genereren.',
				'pl' => 'Umożliwiają administratorowi wgląd do listy obecnie zainstalowanych modułów.',
				'ru' => 'Список модулей, которые установлены на сайте.',
				'sl' => 'Dovoljuje administratorjem pregled trenutno nameščenih modulov.',
				'zh' => '管理員可以檢視目前已經安裝模組的列表',
				'hu' => 'Lehetővé teszi az adminoknak, hogy lássák a telepített modulok listáját.',
				'th' => 'ช่วยให้ผู้ดูแลระบบดูรายการของโมดูลที่ติดตั้งในปัจจุบัน',
				'se' => 'Gör det möjligt för administratören att se installerade mouler.',
			),
			'frontend' => false,
			'backend' => true,
			'menu' => false,

			'modules' => array(
				'name' => 'addons:modules',
				'uri' => 'admin/addons',
				'shortcuts' => array(
					array(
						// @TODO
						'name' => 'global:upload',
						'uri' => 'admin/themes/upload',
						'class' => 'add modal',
					),
				),
			),
			'themes' => array(
				'name' => 'themes.list_title',
				'uri' => 'admin/themes',
				'shortcuts' => array(
					array(
						// @TODO
						'name' => 'global:upload',
						'uri' => 'admin/addons/themes/upload',
						'class' => 'add modal',
					),
				),
			),
		);

		// 'br' => 'Módulos',
		// 'pt' => 'Módulos',
		// 'cs' => 'Moduly',
		// 'da' => 'Moduler',
		// 'de' => 'Module',
		// 'el' => 'Πρόσθετα',
		// 'es' => 'Módulos',
		// 'fi' => 'Moduulit',
		// 'fr' => 'Modules',
		// 'he' => 'מודולים',
		// 'id' => 'Modul',
		// 'it' => 'Moduli',
		// 'lt' => 'Moduliai',
		// 'nl' => 'Modules',
		// 'pl' => 'Moduły',
		// 'ru' => 'Модули',
		// 'sl' => 'Moduli',
		// 'zh' => '模組',
		// 'hu' => 'Modulok',
		// 'th' => 'โมดูล',
		// 'se' => 'Moduler',

		return $info;
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