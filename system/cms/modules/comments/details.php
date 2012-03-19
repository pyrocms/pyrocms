<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Comments module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Comments
 */
class Module_Comments extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Comments',
				'ar' => 'التعليقات',
				'br' => 'Comentários',
				'cs' => 'Komentáře',
				'da' => 'Kommentarer',
				'de' => 'Kommentare',
				'el' => 'Σχόλια',
				'es' => 'Comentarios',
				'fi' => 'Kommentit',
				'fr' => 'Commentaires',
				'he' => 'תגובות',
				'id' => 'Komentar',
				'it' => 'Commenti',
				'lt' => 'Komentarai',
				'nl' => 'Reacties',
				'pl' => 'Komentarze',
				'ru' => 'Комментарии',
				'sl' => 'Komentarji',
				'zh' => '回應',
				'hu' => 'Hozzászólások',
                                'se' => 'Kommentarer'
			),
			'description' => array(
				'en' => 'Users and guests can write comments for content like blog, pages and photos.',
				'ar' => 'يستطيع الأعضاء والزوّار كتابة التعليقات على المُحتوى كالأخبار، والصفحات والصّوَر.',
				'br' => 'Usuários e convidados podem escrever comentários para quase tudo com suporte nativo ao captcha.',
				'cs' => 'Uživatelé a hosté mohou psát komentáře k obsahu, např. neovinkám, stránkám a fotografiím.',
				'da' => 'Brugere og besøgende kan skrive kommentarer til indhold som blog, sider og fotoer.',
				'de' => 'Benutzer und Gäste können für fast alles Kommentare schreiben.',
				'el' => 'Οι χρήστες και οι επισκέπτες μπορούν να αφήνουν σχόλια για περιεχόμενο όπως το ιστολόγιο, τις σελίδες και τις φωτογραφίες.',
				'es' => 'Los usuarios y visitantes pueden escribir comentarios en casi todo el contenido con el soporte de un sistema de captcha incluído.',
				'fi' => 'Käyttäjät ja vieraat voivat kirjoittaa kommentteja eri sisältöihin kuten uutisiin, sivuihin ja kuviin.',
				'fr' => 'Les utilisateurs et les invités peuvent écrire des commentaires pour quasiment tout grâce au générateur de captcha intégré.',
				'he' => 'משתמשי האתר יכולים לרשום תגובות למאמרים, תמונות וכו',
				'id' => 'Pengguna dan pengunjung dapat menuliskan komentaruntuk setiap konten seperti blog, halaman dan foto.',
				'it' => 'Utenti e visitatori possono scrivere commenti ai contenuti quali blog, pagine e foto.',
				'lt' => 'Vartotojai ir svečiai gali komentuoti jūsų naujienas, puslapius ar foto.',
				'nl' => 'Gebruikers en gasten kunnen reageren op bijna alles.',
				'pl' => 'Użytkownicy i goście mogą dodawać komentarze z wbudowanym systemem zabezpieczeń captcha.',
				'ru' => 'Пользователи и гости могут добавлять комментарии к новостям, информационным страницам и фотографиям.',
				'sl' => 'Uporabniki in obiskovalci lahko vnesejo komentarje na vsebino kot je blok, stra ali slike',
				'zh' => '用戶和訪客可以針對新聞、頁面與照片等內容發表回應。',
				'hu' => 'A felhasználók és a vendégek hozzászólásokat írhatnak a tartalomhoz (bejegyzésekhez, oldalakhoz, fotókhoz).',
                                'se' => 'Användare och besökare kan skriva kommentarer till innehåll som blogginlägg, sidor och bilder.'
			),
			'frontend' => false,
			'backend'  => true,
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

		if ( !$this->install_tables($tables))
		{
			return false;
		}

		return true;
	}

	public function uninstall()
	{
		// This is a core module, lets keep it around.
		return false;
	}

	public function upgrade($old_version)
	{
		return TRUE;
	}

}
