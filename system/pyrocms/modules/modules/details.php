<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Modules extends Module {

	public $version = '1.0';
	
	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Modules',
				'nl' => 'Modules',
				'es' => 'Módulos',
				'fr' => 'Modules',
				'de' => 'Module',
				'pl' => 'Moduły',
				'pt' => 'Módulos',
				'zh' => '模組',
				'it' => 'Moduli',
				'ru' => 'Модули',
				'ar' => 'الوحدات',
				'cs' => 'Moduly'
			),
			'description' => array(
				'en' => 'Allows admins to see a list of currently installed modules.',
				'nl' => 'Stelt admins in staat om een overzicht van geinstalleerde modules te genereren.',
				'es' => 'Permite a los administradores ver una lista de los módulos instalados.',
				'fr' => 'Permet aux administrateurs de voir la liste des modules installés',
				'de' => 'Zeigt Administratoren alle aktuell installierten Module.',
				'pl' => 'Umożliwiają administratorowi wgląd do listy obecnie zainstalowanych modułów.',
				'pt' => 'Permite aos administradores ver a lista dos módulos instalados atualmente.',
				'zh' => '管理員可以檢視目前已經安裝模組的列表',
				'it' => 'Permette agli amministratori di vedere una lista dei moduli attualmente installati.',
				'ru' => 'Список модулей, которые установлены на сайте.',
				'ar' => 'تُمكّن المُدراء من معاينة جميع الوحدات المُثبّتة.',
				'cs' => 'Umožňuje administrátorům vidět seznam nainstalovaných modulů.'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => FALSE
		);
	}
	
	public function install()
	{
		return TRUE;
	}

	public function uninstall()
	{
		// you really don't want to uninstall this module
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
		return "No documentation has been added for this module.";
	}
}
/* End of file details.php */
