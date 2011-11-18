<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Modules extends Module {

	public $version = '1.0';
	
	public function info()
	{
		$info = array(
			'name' => array(
				'sl' => 'Moduli',
				'en' => 'Modules',
				'nl' => 'Modules',
				'es' => 'Módulos',
				'fr' => 'Modules',
				'de' => 'Module',
				'pl' => 'Moduły',
				'br' => 'Módulos',
				'zh' => '模組',
				'it' => 'Moduli',
				'ru' => 'Модули',
				'ar' => 'الوحدات',
				'cs' => 'Moduly',
				'fi' => 'Moduulit',
				'el' => 'Πρόσθετα',
				'he' => 'מודולים',
				'lt' => 'Moduliai',
				'da' => 'Moduler'
			),
			'description' => array(
				'sl' => 'Dovoljuje administratorjem pregled trenutno nameščenih modulov.',
				'en' => 'Allows admins to see a list of currently installed modules.',
				'nl' => 'Stelt admins in staat om een overzicht van geinstalleerde modules te genereren.',
				'es' => 'Permite a los administradores ver una lista de los módulos instalados.',
				'fr' => 'Permet aux administrateurs de voir la liste des modules installés',
				'de' => 'Zeigt Administratoren alle aktuell installierten Module.',
				'pl' => 'Umożliwiają administratorowi wgląd do listy obecnie zainstalowanych modułów.',
				'br' => 'Permite aos administradores ver a lista dos módulos instalados atualmente.',
				'zh' => '管理員可以檢視目前已經安裝模組的列表',
				'it' => 'Permette agli amministratori di vedere una lista dei moduli attualmente installati.',
				'ru' => 'Список модулей, которые установлены на сайте.',
				'ar' => 'تُمكّن المُدراء من معاينة جميع الوحدات المُثبّتة.',
				'cs' => 'Umožňuje administrátorům vidět seznam nainstalovaných modulů.',
				'fi' => 'Listaa järjestelmänvalvojalle käytössä olevat moduulit.',
				'el' => 'Επιτρέπει στους διαχειριστές να προβάλουν μια λίστα των εγκατεστημένων πρόσθετων.',
				'he' => 'נותן אופציה למנהל לראות רשימה של המודולים אשר מותקנים כעת באתר או להתקין מודולים נוספים',
				'lt' => 'Vartotojai ir svečiai gali komentuoti jūsų naujienas, puslapius ar foto.',
				'da' => 'Lader administratorer se en liste over de installerede moduler.'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => FALSE,
		);

		// Check to make sure we're not running the installer or MSM. Then check perms
		if ( ! class_exists('Module_import') AND Settings::get('addons_upload'))
		{
			$info['shortcuts'][] = array(
		 	 	'name' => 'upload_label',
				'uri' => 'admin/modules/upload',
				'class' => 'add',
			);
		}

		return $info;
	}
	
	public function install()
	{
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
		// You could include a file and return it here.
		return TRUE;
	}
}
/* End of file details.php */