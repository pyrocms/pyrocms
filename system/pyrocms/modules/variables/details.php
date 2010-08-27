<?php defined('BASEPATH') or exit('No direct script access allowed');

class Variables_details extends Module {

	public $version = '0.3';
	
	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Variables',
				'nl' => 'Variabelen',
				'pl' => 'Zmienne',
				'es' => 'Variables',
				'fr' => 'Variables',
				'de' => 'Variablen',
				'en' => 'Variáveis',
			),
			'description' => array(
				'en' => 'Manage global variables to access from everywhere.',
				'nl' => 'Beheer globale variabelen die overal beschikbaar zijn.',
				'pl' => 'Zarządzaj globalnymi zmiennymi do których masz dostęp z każdego miejsca aplikacji.',
				'es' => 'Manage global variables to access from everywhere.',
				'fr' => 'Manage global variables to access from everywhere.',
				'de' => 'Verwaltet globale Variablen, auf die von überall zugegriffen werden kann.',
				'br' => 'Gerencia as variáveis globais acessíveis de qualquer lugar.'
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