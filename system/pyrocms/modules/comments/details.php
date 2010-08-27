<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Comments_details extends Module {
	
	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Comments',
				'br' => 'Comentários',
				'nl' => 'Reacties',
				'es' => 'Comentarios',
				'fr' => 'Commentaires',
				'de' => 'Kommentare',
				'pl' => 'Komentarze'
			),
			'description' => array(
				'en' => 'Users and guests can write comments for content like news, pages and photos.',
				'br' => 'Usuários e convidados podem escrever comentários para quase tudo com suporte nativo ao captcha.',
				'nl' => 'Gebruikers en gasten kunnen reageren op bijna alles.',
				'es' => 'Los usuarios y visitantes pueden escribir comentarios en casi todo el contenido con el soporte de un sistema de captcha incluído.',
				'fr' => 'Les utilisateurs et les invités peuvent écrire des commentaires pour quasiment tout grâce au générateur de captcha intégré.',
				'de' => 'Benutzer und Gäste können für fast alles Kommentare schreiben.',
				'pl' => 'Użytkownicy i goście mogą dodawać komentarze z wbudowanym systemem zabezpieczeń captcha.'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => TRUE,
			'controllers' => array(
				'admin' => array('index', 'edit', 'delete')
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