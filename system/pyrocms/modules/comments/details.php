<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Module_Comments extends Module {
	
	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Comments',
				'pt' => 'Comentários',
				'nl' => 'Reacties',
				'es' => 'Comentarios',
				'fr' => 'Commentaires',
				'de' => 'Kommentare',
				'pl' => 'Komentarze',
				'zh' => '回應',
				'it' => 'Commenti',
				'ru' => 'Комментарии',
				'ar' => 'العربيّة',
				'cs' => 'Komentáře',
				'fi' => 'Kommentit'
			),
			'description' => array(
				'en' => 'Users and guests can write comments for content like news, pages and photos.',
				'pt' => 'Usuários e convidados podem escrever comentários para quase tudo com suporte nativo ao captcha.',
				'nl' => 'Gebruikers en gasten kunnen reageren op bijna alles.',
				'es' => 'Los usuarios y visitantes pueden escribir comentarios en casi todo el contenido con el soporte de un sistema de captcha incluído.',
				'fr' => 'Les utilisateurs et les invités peuvent écrire des commentaires pour quasiment tout grâce au générateur de captcha intégré.',
				'de' => 'Benutzer und Gäste können für fast alles Kommentare schreiben.',
				'pl' => 'Użytkownicy i goście mogą dodawać komentarze z wbudowanym systemem zabezpieczeń captcha.',
				'zh' => '用戶和訪客可以針對新聞、頁面與照片等內容發表回應。',
				'it' => 'Utenti e visitatori possono scrivere commenti ai contenuti quali news, pagine e foto.',
				'ru' => 'Пользователи и гости могут добавлять комментарии к новостям, информационным страницам и фотографиям.',
				'ar' => 'يستطيع الأعضاء والزوّار كتابة التعليقات على المُحتوى كالأخبار، والصفحات والصّوَر.',
				'cs' => 'Uživatelé a hosté mohou psát komentáře k obsahu, např. neovinkám, stránkám a fotografiím.',
				'fi' => 'Käyttäjät ja vieraat voivat kirjoittaa kommentteja eri sisältöihin kuten uutisiin, sivuihin ja kuviin.'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => 'content'
		);
	}
	
	public function install()
	{
		$this->dbforge->drop_table('comments');
		
		$comments = "
			CREATE TABLE `comments` (
			  `id` smallint(5) unsigned NOT NULL auto_increment,
			  `is_active` tinyint(1) NOT NULL default '0',
			  `user_id` int(11) NOT NULL default '0',
			  `name` varchar(40) collate utf8_unicode_ci NOT NULL default '',
			  `email` varchar(40) collate utf8_unicode_ci NOT NULL default '',
			  `website` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
			  `comment` text collate utf8_unicode_ci NOT NULL,
			  `module` varchar(40) collate utf8_unicode_ci NOT NULL,
			  `module_id` varchar(255) collate utf8_unicode_ci NOT NULL default '0',
			  `created_on` varchar(11) collate utf8_unicode_ci NOT NULL default '0',
			  `ip_address` varchar(15) collate utf8_unicode_ci NOT NULL default '',
			  PRIMARY KEY  (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Comments by users or guests';
		";
		
		if($this->db->query($comments))
		{
			return TRUE;
		}
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
		return "<h4>Overview</h4>
		<p>The comments module allows visitors to comment on any part of your website that you enable comments for.</p>
		<h4>Enabling Comments</h4><hr>
		<p>Comments can be enabled in Pages, Galleries, and News. If you want to moderate comments you must enable
		comment moderation in Settings.</p>
		<h4>Comment Moderation</h4><hr>
		<p>Comments may be Approved or Unapproved at any time from the admin panel. If you approve a comment and later want to unapprove it you may do so.</p>";
	}

}
