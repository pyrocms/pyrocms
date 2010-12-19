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
		return "<h4>Overview</h4>
				<p>The Addons module allows admins to upload, install, and uninstall third-party modules.</p>
				<h4>Uploading</h4>
				<p>New modules must be in a zip file and the folder must be named the same as the module.
				For example if you are uploading the 'forums' module the folder must be named 'forums' not 'test_forums'.</p>
				<h4>Disabling or Uninstalling a module</h4>
				<p>If you want to remove a module from the front-end and from the admin menus you may Disable the module. If you
				are completely done with it you may Uninstall it. <font color=\"red\">Warning: Uninstalling a module deletes all
				source files, uploaded files, and database records associated with the module.</font></p>";
	}
}
/* End of file details.php */
