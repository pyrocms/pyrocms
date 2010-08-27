<?php defined('BASEPATH') or exit('No direct script access allowed');

class Widgets_details extends Module {

	public $version = '1.0';
	
	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Widgets'
			),
			'description' => array(
				'en' => 'Manage small sections of self-contained logic in blocks or "Widgets".',
				'br' => 'Gerenciar pequenas seções de conteúdos em bloco conhecidos como "Widgets".',
				'de' => 'Verwaltet kleine, eigentständige Bereiche, genannt "Widgets".',
				'nl' => 'Beheer kleine onderdelen die zelfstandige logica bevatten, ofwel "Widgets".'
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