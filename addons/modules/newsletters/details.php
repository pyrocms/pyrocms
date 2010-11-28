<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Newsletters extends Module {

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
				'pl' => 'Newslettery',
				'zh' => '電子報',
				'it' => 'Newsletter',
				'ru' => 'Подписка на новости'
			),
			'description' => array(
				'en' => 'Let visitors subscribe via their email address.',
				'nl' => 'Laat bezoekers een abonnement nemen door hun emailadres achter te laten.',
				'es' => 'Permite que tus visitantes puedan suscribirse a las actualizaciones del sitio vía correo electrónico.',
				'fr' => 'Permet aux visiteurs de s\'abonner avec leur adresse e-mail.',
				'de' => 'Erlaube Besuchern Newsletter via Email zu abonnieren.',
				'pl' => 'Umożliwia użytkownikom zapisanie się za pomocą adresu e-mail do newsleterrów.',
				'zh' => '讓訪客填寫電子郵件以訂閱電子報。',
				'it' => 'Permette ai visitatori di iscriversi attraverso i loro indirizzi email.',
				'ru' => 'Посетители могут подписаться на рассылку новостей, используя свой адрес Email.'
			),
			'frontend' => FALSE,
			'backend' => TRUE,
			'menu' => 'users'
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('newsletters');
		$this->dbforge->drop_table('emails');
		
		$newsletters = "
			CREATE TABLE `newsletters` (
			  `id` smallint(5) unsigned NOT NULL auto_increment,
			  `title` varchar(100) collate utf8_unicode_ci NOT NULL default '',
			  `body` text collate utf8_unicode_ci NOT NULL,
			  `created_on` int(11) default NULL,
			  `sent_on` int(11) default NULL,
			  PRIMARY KEY  (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Newsletter emails stored before being sent then archived her';
		";
		
		$emails = "
			CREATE TABLE `emails` (
			  `email` varchar(40) collate utf8_unicode_ci NOT NULL default '',
			  `registered_on` varchar(11) collate utf8_unicode_ci NOT NULL default '',
			  PRIMARY KEY  (`email`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='E-mail addresses for newsletter subscriptions';
		";
		
		if($this->db->query($newsletters) &&
		   $this->db->query($emails))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		if($this->dbforge->drop_table('newsletters'))
		{
			return TRUE;
		}
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
		return "<h4>Overview</h4>
		<p>The Newsletter module is a quick way to create email \"blasts\" to send to your email newsletter subscribers.</p>
		<h4>Subscribers</h4><hr>
		<p>To collect email addresses use the Newsletter Subscribe widget. Embed the widget anywhere on your site and
		let your visitors subscribe.</p>
		<h4>Sending Newsletters</h4><hr>
		<p>Creating a newsletter is very similar to creating page content. Use the WYSIWYG editor to generate the html
		that will be used in the email. Keep in mind that any images that you place in the newsletter will be fetched
		from your server whenever the recipient reads the email. So don't delete the images from your server as soon as you send the blast.</p>";
	}
}
/* End of file details.php */