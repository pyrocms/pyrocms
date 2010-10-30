<?php defined('BASEPATH') or exit('No direct script access allowed');

class Details_Newsletters extends Module {

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
				'zh' => '電子報'
			),
			'description' => array(
				'en' => 'Let visitors subscribe via their email address.',
				'nl' => 'Laat bezoekers een abonnement nemen door hun emailadres achter te laten.',
				'es' => 'Permite que tus visitantes puedan suscribirse a las actualizaciones del sitio vía correo electrónico.',
				'fr' => 'Permet aux visiteurs de s\'abonner avec leur adresse e-mail.',
				'de' => 'Erlaube Besuchern Newsletter via Email zu abonnieren.',
				'pl' => 'Umożliwia użytkownikom zapisanie się za pomocą adresu e-mail do newsleterrów.',
				'zh' => '讓訪客填寫電子郵件以訂閱電子報。'
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
		return "No documentation has been added for this module.<br/>Contact the module developer for assistance.";
	}
}
/* End of file details.php */