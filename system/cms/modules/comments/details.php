<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Comments module
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Comments
 */
class Module_Comments extends Module
{

	public $version = '1.1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Comments',
				'ar' => 'التعليقات',
				'br' => 'Comentários',
				'pt' => 'Comentários',
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
				'tw' => '回應',
				'cn' => '回应',
				'hu' => 'Hozzászólások',
				'th' => 'ความคิดเห็น',
				'se' => 'Kommentarer',
			),
			'description' => array(
				'en' => 'Users and guests can write comments for content like blog, pages and photos.',
				'ar' => 'يستطيع الأعضاء والزوّار كتابة التعليقات على المُحتوى كالأخبار، والصفحات والصّوَر.',
				'br' => 'Usuários e convidados podem escrever comentários para quase tudo com suporte nativo ao captcha.',
				'pt' => 'Utilizadores e convidados podem escrever comentários para quase tudo com suporte nativo ao captcha.',
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
				'tw' => '用戶和訪客可以針對新聞、頁面與照片等內容發表回應。',
				'cn' => '用户和访客可以针对新闻、页面与照片等内容发表回应。',
				'hu' => 'A felhasználók és a vendégek hozzászólásokat írhatnak a tartalomhoz (bejegyzésekhez, oldalakhoz, fotókhoz).',
				'th' => 'ผู้ใช้งานและผู้เยี่ยมชมสามารถเขียนความคิดเห็นในเนื้อหาของหน้าเว็บบล็อกและภาพถ่าย',
				'se' => 'Användare och besökare kan skriva kommentarer till innehåll som blogginlägg, sidor och bilder.',
			),
			'frontend' => false,
			'backend' => true,
			'menu' => 'content'
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('comments');
		$this->dbforge->drop_table('comment_blacklists');

		$tables = array(
			'comments' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
				'is_active' => array('type' => 'INT', 'constraint' => 1, 'default' => 0),
				'user_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
				'user_name' => array('type' => 'VARCHAR', 'constraint' => 40, 'default' => ''),
				'user_email' => array('type' => 'VARCHAR', 'constraint' => 40, 'default' => ''), // @todo Shouldn't this be 255?
				'user_website' => array('type' => 'VARCHAR', 'constraint' => 255),
				'comment' => array('type' => 'TEXT'),
				'parsed' => array('type' => 'TEXT'),
				'module' => array('type' => 'VARCHAR', 'constraint' => 40),
				'entry_id' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => 0),
				'entry_title' => array('type' => 'char', 'constraint' => 255, 'null' => false),
				'entry_key' => array('type' => 'varchar', 'constraint' => 100, 'null' => false),
				'entry_plural' => array('type' => 'varchar', 'constraint' => 100, 'null' => false),
				'uri' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
				'cp_uri' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
				'created_on' => array('type' => 'INT', 'constraint' => 11, 'default' => '0'),
				'ip_address' => array('type' => 'VARCHAR', 'constraint' => 45, 'default' => ''),
			),
			'comment_blacklists' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
				'website' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
				'email' => array('type' => 'VARCHAR', 'constraint' => 150, 'default' => ''),
			),
		);

		if ( ! $this->install_tables($tables))
		{
			return false;
		}

		// Install the setting
		$settings = array(
			array(
				'slug' => 'akismet_api_key',
				'title' => 'Akismet API Key',
				'description' => 'Akismet is a spam-blocker from the WordPress team. It keeps spam under control without forcing users to get past human-checking CAPTCHA forms.',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'integration',
				'order' => 981,
			),
			array(
				'slug' => 'enable_comments',
				'title' => 'Enable Comments',
				'description' => 'Enable comments.',
				'type' => 'radio',
				'default' => true,
				'value' => true,
				'options' => '1=Enabled|0=Disabled',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'comments',
				'order' => 968,
			),
			array(
				'slug' => 'moderate_comments',
				'title' => 'Moderate Comments',
				'description' => 'Force comments to be approved before they appear on the site.',
				'type' => 'radio',
				'default' => true,
				'value' => true,
				'options' => '1=Enabled|0=Disabled',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'comments',
				'order' => 967,
			),
			array(
				'slug' => 'comment_order',
				'title' => 'Comment Order',
				'description' => 'Sort order in which to display comments.',
				'type' => 'select',
				'default' => 'ASC',
				'value' => 'ASC',
				'options' => 'ASC=Oldest First|DESC=Newest First',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'comments',
				'order' => 966,
			),
			array(
				'slug' => 'comment_markdown',
				'title' => 'Allow Markdown',
				'description' => 'Do you want to allow visitors to post comments using Markdown?',
				'type' => 'select',
				'default' => '0',
				'value' => '0',
				'options' => '0=Text Only|1=Allow Markdown',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'comments',
				'order' => 965,
			),
		);

		foreach ($settings as $setting)
		{
			if ( ! $this->db->insert('settings', $setting))
			{
				return false;
			}
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
		return true;
	}

}
