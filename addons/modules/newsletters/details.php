<?php defined('BASEPATH') or exit('No direct script access allowed');

class Newsletter_details extends Module {

	public $version = '0.2';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Newsletters',
				'nl' => 'Nieuwsbrieven',
				'es' => 'Boletines',
				'fr' => 'Newsletters',
				'de' => 'Newsletter',
				'pl' => 'Newslettery'
			),
			'description' => array(
				'en' => 'Let visitors subscribe via their email address.',
				'nl' => 'Laat bezoekers een abonnement nemen door hun emailadres achter te laten.',
				'es' => 'Permite que tus visitantes puedan suscribirse a las actualizaciones del sitio vía correo electrónico.',
				'fr' => 'Permet aux visiteurs de s\'abonner avec leur adresse e-mail.',
				'de' => 'Erlaube Besuchern Newsletter via Email zu abonnieren.',
				'pl' => 'Umożliwia użytkownikom zapisanie się za pomocą adresu e-mail do newsleterrów.'
			),
			'frontend' => FALSE,
			'backend' => TRUE,
			'menu' => TRUE
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