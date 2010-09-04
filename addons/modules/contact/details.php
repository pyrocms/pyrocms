<?php defined('BASEPATH') or exit('No direct script access allowed');

class Details_Contact extends Module {

	public $version = '0.6';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Contact',
				'nl' => 'Contact',
				'pl' => 'Kontakt',
				'es' => 'Contacto',
				'fr' => 'Contact',
				'de' => 'Kontakt'
			),
			'description' => array(
				'en' => 'Adds a form to your site that allows visitors to send emails to you without disclosing an email address to them.',
				'nl' => 'Voegt een formulier aan de site toe waarmee bezoekers een email kunnen sturen, zonder dat u ze een emailadres hoeft te tonen.',
				'pl' => 'Dodaje formularz kontaktowy do Twojej strony, który pozwala użytkownikom wysłanie maila za pomocą formularza kontaktowego.',
				'es' => 'Añade un formulario a tu sitio que permitirá a los visitantes enviarte correos electrónicos a ti sin darles tu dirección de correo directamente a ellos.',
				'fr' => 'Ajoute un formulaire à votre site qui permet aux visiteurs de vous envoyer un e-mail sans révéler votre adresse e-mail.',
				'de' => 'Fügt ein Formular hinzu, welches Besuchern erlaubt Emails zu schreiben, ohne die Kontakt Email-Adresse offen zu legen.'
			),
			'frontend' => TRUE,
			'backend' => FALSE,
			'menu' => FALSE
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