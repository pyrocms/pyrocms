<?php defined('BASEPATH') or exit('No direct script access allowed');

class Settings_details extends Module {

	public $version = '0.3';
	
	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Settings',
				'nl' => 'Instellingen',
				'es' => 'Configuraciones',
				'fr' => 'Paramètres',
				'de' => 'Einstellungen',
				'pl' => 'Ustawienia',
				'br' => 'Configurações'
			),
			'description' => array(
				'en' => 'Allows adminsistators to update settings like Site Name, messages and email address, etc.',
				'nl' => 'Maakt het administratoren en medewerkers mogelijk om websiteinstellingen zoals naam en beschrijving te veranderen.',
				'es' => 'Permite a los administradores y al personal configurar los detalles del sitio como el nombre del sitio y la descripción del mismo.',
				'fr' => 'Permet aux admistrateurs et au personnel de modifier les paramètres du site : nom du site et description',
				'de' => 'Erlaubt es Administratoren Einstellungen der Seite wie Name und Beschreibung zu ändern.',
				'pl' => 'Umożliwia administratorom zmianę ustawień strony jak nazwa strony, opis, e-mail administratora, itd.',
				'br' => 'Permite com que administradores e a equipe consigam trocar as configurações do website incluindo o nome e descrição.'
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