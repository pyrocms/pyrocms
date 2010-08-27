<?php defined('BASEPATH') or exit('No direct script access allowed');

class Permissions_details extends Module {

	public $version = '0.3';
	
	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Permissions',
				'nl' => 'Toegangsrechten',
				'es' => 'Permisos',
				'fr' => 'Permissions',
				'de' => 'Zugriffsrechte',
				'pl' => 'Uprawnienia',
				'br' => 'Permissões'
			),
			'description' => array(
				'en' => 'Control what type of users can see certain sections within the site.',
				'nl' => 'Bepaal welke typen gebruikers toegang hebben tot gedeeltes van de site.',
				'pl' => 'Ustaw, którzy użytkownicy mogą mieć dostęp do odpowiednich sekcji witryny.',
				'es' => 'Controla que tipo de usuarios pueden ver secciones específicas dentro del sitio.',
				'de' => 'Steuert welche Art von Benutzer welche Sektion in der Seite sehen kann.',
				'br' => 'Controle quais tipos de usuários podem ver certas seções no site.'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => TRUE,
			'controllers' => array(
				'admin' => array('index', 'create', 'edit', 'delete'),
			)
		);
	}
	
	public function install()
	{
		// Your Install Logic
		return TRUE;
	}

	public function uninstall()
	{
		// Your Uninstall Logic
		return TRUE;
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
		return "Some Help Stuff";
	}
}
/* End of file details.php */