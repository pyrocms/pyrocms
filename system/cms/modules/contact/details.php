<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Contact extends Module {

	public $version = 0.9;

	public function info()
	{
		return array(
			'name' => array(
				'sl' => 'Kontakt',
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
				'cs' => 'Kontakt',
				'fi' => 'Ota yhteyttä',
				'el' => 'Επικοινωνία',
				'he' => 'יצירת קשר',
				'lt' => 'Kontaktinė formą'
			),
			'description' => array(
				'sl' => 'Dodaj obrazec za kontakt da vam lahko obiskovalci pošljejo sporočilo brez da bi jim razkrili vaš email naslov.',
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
				'cs' => 'Přidá na web kontaktní formulář pro návštěvníky a uživatele, díky kterému vás mohou kontaktovat i bez znalosti vaší e-mailové adresy.',
				'fi' => 'Luo lomakkeen sivustollesi, josta kävijät voivat lähettää sähköpostia tietämättä vastaanottajan sähköpostiosoitetta.',
				'el' => 'Προσθέτει μια φόρμα στον ιστότοπό σας που επιτρέπει σε επισκέπτες να σας στέλνουν μηνύμα μέσω email χωρίς να τους αποκαλύπτεται η διεύθυνση του email σας.',
				'he' => 'מוסיף תופס יצירת קשר לאתר על מנת לא לחסוף כתובת דואר האלקטרוני של האתר למנועי פרסומות',
				'lt' => 'Prideda jūsų puslapyje formą leidžianti lankytojams siūsti jums el. laiškus neatskleidžiant jūsų el. pašto adreso.'
			),
			'frontend' => FALSE,
			'backend' => TRUE,
			'menu' => FALSE
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('contact_log');
		
		return $this->db->query("
			CREATE TABLE ".$this->db->dbprefix('contact_log')." (
			  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
			  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
			  `subject` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
			  `message` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
			  `company_name` VARCHAR( 255 ) NOT NULL,
			  `sender_agent` int(11) DEFAULT NULL,
			  `sender_ip` text,
			  `sender_os` int(15) NOT NULL,
			  `sent_at` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8
		");
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
		return "This module has no inline docs as it does not have a back-end.";
	}
}
/* End of file details.php */