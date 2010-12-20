<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Contact extends Module {

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
				'de' => 'Kontakt',
				'zh' => '聯絡我們',
				'it' => 'Contattaci',
				'ru' => 'Обратная связь',
				'ar' => 'الإتصال',
				'pt' => 'Contato',
				'cs' => 'Kontakt'
			),
			'description' => array(
				'en' => 'Adds a form to your site that allows visitors to send emails to you without disclosing an email address to them.',
				'nl' => 'Voegt een formulier aan de site toe waarmee bezoekers een email kunnen sturen, zonder dat u ze een emailadres hoeft te tonen.',
				'pl' => 'Dodaje formularz kontaktowy do Twojej strony, który pozwala użytkownikom wysłanie maila za pomocą formularza kontaktowego.',
				'es' => 'Añade un formulario a tu sitio que permitirá a los visitantes enviarte correos electrónicos a ti sin darles tu dirección de correo directamente a ellos.',
				'fr' => 'Ajoute un formulaire à votre site qui permet aux visiteurs de vous envoyer un e-mail sans révéler votre adresse e-mail.',
				'de' => 'Fügt ein Formular hinzu, welches Besuchern erlaubt Emails zu schreiben, ohne die Kontakt Email-Adresse offen zu legen.',
				'zh' => '為您的網站新增「聯絡我們」的功能，對訪客是較為清楚便捷的聯絡方式，也無須您將電子郵件公開在網站上。',
				'it' => 'Aggiunge un modulo al tuo sito che permette ai visitatori di inviarti email senza mostrare loro il tuo indirizzo email.',
				'ru' => 'Добавляет форму обратной связи на сайт, через которую посетители могут отправлять вам письма, при этом адрес Email остаётся скрыт.',
				'ar' => 'إضافة استمارة إلى موقعك تُمكّن الزوّار من مراسلتك دون علمهم بعنوان البريد الإلكتروني.',
				'pt' => 'Adiciona um formulário para o seu site permitir aos visitantes que enviem e-mails para voce sem divulgar um endereço de e-mail para eles.',
				'cs' => 'Přidá na web kontaktní formulář pro návštěvníky a uživatele, díky kterému vás mohou kontaktovat i bez znalosti vaší e-mailové adresy.'
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
		return "No documentation has been added for this module.<br/>Contact the module developer for assistance.";
	}
}
/* End of file details.php */
