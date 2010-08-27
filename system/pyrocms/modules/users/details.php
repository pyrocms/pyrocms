<?php defined('BASEPATH') or exit('No direct script access allowed');

class Users_details extends Module {

	public $version = '0.8';
	
	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Users',
				'nl' => 'Gebruikers',
				'pl' => 'Użytkownicy',
				'es' => 'Usuarios',
				'fr' => 'Utilisateurs',
				'de' => 'Benutzer',
				'br' => 'Usuários'
			),
			'description' => array(
				'en' => 'Let users register and log in to the site, and manage them via the control panel.',
				'nl' => 'Laat gebruikers registreren en inloggen op de site, en beheer ze via het controlepaneel.',
				'pl' => 'Pozwól użytkownikom na logowanie się na stronie i zarządzaj nimi za pomocą panelu.',
				'es' => 'Permite el registro de nuevos usuarios quienes podrán loguearse en el sitio. Estos podrán controlarse desde el panel de administración.',
				'fr' => 'Permet aux utilisateurs de s\'enregistrer et de se connecter au site et de les gérer via le panneau de contrôle',
				'de' => 'Erlaube Benutzern das Registrieren und Einloggen auf der Seite und verwalte sie über die Admin-Oberfläche.',
				'br' => 'Permite com que usuários se registrem e entrem no site e também que eles sejam gerenciáveis apartir do painel de controle.'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => TRUE
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