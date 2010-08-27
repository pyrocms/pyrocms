<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pages_details extends Module {

	public $version = '1.0';
	
	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Pages',
				'nl' => 'Pagina\'s',
				'es' => 'Páginas',
				'fr' => 'Pages',
				'de' => 'Seiten',
				'pl' => 'Strony',
				'br' => 'Páginas'
			),
			'description' => array(
				'en' => 'Add custom pages to the site with any content you want.',
				'nl' => "Voeg aangepaste pagina's met willekeurige inhoud aan de site toe.",
				'pl' => 'Dodaj własne strony z dowolną treścią do witryny.',
				'es' => 'Agrega páginas customizadas al sitio con cualquier contenido que tu quieras.',
				'fr' => "Permet d'ajouter sur le site des pages personalisées avec le contenu que vous souhaitez.",
				'de' => 'Füge eigene Seiten mit anpassbaren Inhalt hinzu.',
				'br' => 'Adicionar páginas personalizadas ao site com qualquer conteúdo que você queira.'
			),
			'frontend' => TRUE,
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