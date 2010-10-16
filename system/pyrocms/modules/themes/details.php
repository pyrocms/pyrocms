<?php defined('BASEPATH') or exit('No direct script access allowed');

class Details_Themes extends Module {

	public $version = '0.5';
	
	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Themes',
				'nl' => "Thema's",
				'es' => 'Temas',
				'fr' => 'Thèmes',
				'de' => 'Themen',
				'pl' => 'Motywy',
				'br' => 'Temas',
				'zh' => '佈景主題'
			),
			'description' => array(
				'en' => 'Allows admins and staff to change website theme, upload new themes and manage them in a more visual approach.',
				'nl' => 'Maakt het voor administratoren en medewerkers mogelijk om het thema van de website te wijzigen, nieuwe thema\'s te uploaden en ze visueel te beheren.',
				'es' => 'Permite a los administradores y miembros del personal cambiar el tema del sitio web, subir nuevos temas y manejar los ya existentes.',
				'fr' => 'Permet aux administrateurs et au personnel de modifier le thème du site, de charger de nouveaux thèmes et de le gérer de façon plus visuelle',
				'de' => 'Ermöglicht es dem Administrator das Seiten Thema auszuwählen, neue Themen hochzulanden oder diese visuell zu verwalten.',
				'pl' => 'Umożliwia administratorowi zmianę motywu strony, wgrywanie nowych motywów oraz zarządzanie nimi.',
				'br' => 'Permite com que administradores e membros da equipe configurem o tema de layout do website, fazer upload de novos temas e gerenciá-los em uma interface mais visual.',
				'zh' => '讓管理者可以更改網站顯示風貌，以視覺化的操作上傳並管理這些網站佈景主題。'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => 'design'
		);
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
		return "Some Help Stuff";
	}
}
/* End of file details.php */