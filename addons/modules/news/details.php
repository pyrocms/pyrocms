<?php defined('BASEPATH') or exit('No direct script access allowed');

class News_details extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'News',
				'nl' => 'Nieuws',
				'es' => 'Artículos',
				'fr' => 'Actualités',
				'de' => 'News',
				'pl' => 'Aktualności'
			),
			'description' => array(
				'en' => 'Post news articles and blog entries.',
				'nl' => 'Post nieuwsartikelen en blogs op uw site.',
				'es' => 'Escribe entradas para los artículos y blogs (web log).',
				'fr' => 'Envoyez de nouveaux articles et messages de blog.',
				'de' => 'Veröffentliche neue Artikel und Blog-Einträge',
				'pl' => 'Postuj nowe artykuły oraz wpisy w blogu'
			),
			'frontend' => TRUE,
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