<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Module_Comments extends Module {
	
	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'sl' => 'Komentarji',
				'en' => 'Comments',
				'br' => 'Comentários',
				'nl' => 'Reacties',
				'es' => 'Comentarios',
				'fr' => 'Commentaires',
				'de' => 'Kommentare',
				'pl' => 'Komentarze',
				'zh' => '回應',
				'it' => 'Commenti',
				'ru' => 'Комментарии',
				'ar' => 'التعليقات',
				'cs' => 'Komentáře',
				'fi' => 'Kommentit',
				'el' => 'Σχόλια',
				'he' => 'תגובות',
				'lt' => 'Komentarai',
				'da' => 'Kommentarer',
				'id' => 'Komentar'
			),
			'description' => array(
				'sl' => 'Uporabniki in obiskovalci lahko vnesejo komentarje na vsebino kot je blok, stra ali slike',
				'en' => 'Users and guests can write comments for content like blog, pages and photos.',
				'br' => 'Usuários e convidados podem escrever comentários para quase tudo com suporte nativo ao captcha.',
				'nl' => 'Gebruikers en gasten kunnen reageren op bijna alles.',
				'es' => 'Los usuarios y visitantes pueden escribir comentarios en casi todo el contenido con el soporte de un sistema de captcha incluído.',
				'fr' => 'Les utilisateurs et les invités peuvent écrire des commentaires pour quasiment tout grâce au générateur de captcha intégré.',
				'de' => 'Benutzer und Gäste können für fast alles Kommentare schreiben.',
				'pl' => 'Użytkownicy i goście mogą dodawać komentarze z wbudowanym systemem zabezpieczeń captcha.',
				'zh' => '用戶和訪客可以針對新聞、頁面與照片等內容發表回應。',
				'it' => 'Utenti e visitatori possono scrivere commenti ai contenuti quali blog, pagine e foto.',
				'ru' => 'Пользователи и гости могут добавлять комментарии к новостям, информационным страницам и фотографиям.',
				'ar' => 'يستطيع الأعضاء والزوّار كتابة التعليقات على المُحتوى كالأخبار، والصفحات والصّوَر.',
				'cs' => 'Uživatelé a hosté mohou psát komentáře k obsahu, např. neovinkám, stránkám a fotografiím.',
				'fi' => 'Käyttäjät ja vieraat voivat kirjoittaa kommentteja eri sisältöihin kuten uutisiin, sivuihin ja kuviin.',
				'el' => 'Οι χρήστες και οι επισκέπτες μπορούν να αφήνουν σχόλια για περιεχόμενο όπως το ιστολόγιο, τις σελίδες και τις φωτογραφίες.',
				'he' => 'משתמשי האתר יכולים לרשום תגובות למאמרים, תמונות וכו',
				'lt' => 'Vartotojai ir svečiai gali komentuoti jūsų naujienas, puslapius ar foto.',
				'da' => 'Brugere og besøgende kan skrive kommentarer til indhold som blog, sider og fotoer.',
				'id' => 'Pengguna dan pengunjung dapat menuliskan komentaruntuk setiap konten seperti blog, halaman dan foto.'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => 'content'
		);
	}
	
	public function install()
	{
		$this->dbforge->drop_table('comments');

		$tables = array(
			'comments' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'is_active' => array('type' => 'INT', 'constraint' => 1, 'default' => 0,),
				'user_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
				'name' => array('type' => 'VARCHAR', 'constraint' => 40, 'default' => '',),
				'email' => array('type' => 'VARCHAR', 'constraint' => 40, 'default' => '',), // @todo Shouldn't this be 255?
				'website' => array('type' => 'VARCHAR', 'constraint' => 255,),
				'comment' => array('type' => 'TEXT',),
				'parsed' => array('type' => 'TEXT',),
				'module' => array('type' => 'VARCHAR', 'constraint' => 40,),
				'module_id' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => 0,),
				'created_on' => array('type' => 'VARCHAR', 'constraint' => 11, 'default' => '0',), // @todo Shouldn't this be an int?
				'ip_address' => array('type' => 'VARCHAR', 'constraint' => 15, 'default' => '',),
			),
		);

		$this->install_tables($tables);

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
		return TRUE;
	}

}
