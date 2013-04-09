<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Permissions Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Permissions
 */
class Module_Permissions extends Module {

	public $version = '1.0.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Permissions',
				'ar' => 'الصلاحيات',
				'br' => 'Permissões',
				'pt' => 'Permissões',
				'cs' => 'Oprávnění',
				'da' => 'Adgangskontrol',
				'de' => 'Zugriffsrechte',
				'el' => 'Δικαιώματα',
				'es' => 'Permisos',
                            'fa' => 'اجازه ها',
				'fi' => 'Käyttöoikeudet',
				'fr' => 'Permissions',
				'he' => 'הרשאות',
				'id' => 'Perizinan',
				'it' => 'Permessi',
				'lt' => 'Teisės',
				'nl' => 'Toegangsrechten',
				'pl' => 'Uprawnienia',
				'ru' => 'Права доступа',
				'sl' => 'Dovoljenja',
				'tw' => '權限',
				'cn' => '权限',
				'hu' => 'Jogosultságok',
				'th' => 'สิทธิ์',
				'se' => 'Behörigheter',
			),
			'description' => array(
				'en' => 'Control what type of users can see certain sections within the site.',
				'ar' => 'التحكم بإعطاء الصلاحيات للمستخدمين للوصول إلى أقسام الموقع المختلفة.',
				'br' => 'Controle quais tipos de usuários podem ver certas seções no site.',
				'pt' => 'Controle quais os tipos de utilizadores podem ver certas secções no site.',
				'cs' => 'Spravujte oprávnění pro jednotlivé typy uživatelů a ke kterým sekcím mají přístup.',
				'da' => 'Kontroller hvilken type brugere der kan se bestemte sektioner på sitet.',
				'de' => 'Regelt welche Art von Benutzer welche Sektion in der Seite sehen kann.',
				'el' => 'Ελέγξτε τα δικαιώματα χρηστών και ομάδων χρηστών όσο αφορά σε διάφορες λειτουργίες του ιστοτόπου.',
				'es' => 'Controla que tipo de usuarios pueden ver secciones específicas dentro del sitio.',
                            'fa' => 'مدیریت اجازه های گروه های کاربری',
				'fi' => 'Hallitse minkä tyyppisiin osioihin käyttäjät pääsevät sivustolla.',
				'fr' => 'Permet de définir les autorisations des groupes d\'utilisateurs pour afficher les différentes sections.',
				'he' => 'ניהול הרשאות כניסה לאיזורים מסוימים באתר',
				'id' => 'Mengontrol tipe pengguna mana yang dapat mengakses suatu bagian dalam situs.',
				'it' => 'Controlla che tipo di utenti posssono accedere a determinate sezioni del sito.',
				'lt' => 'Kontroliuokite kokio tipo varotojai kokią dalį puslapio gali pasiekti.',
				'nl' => 'Bepaal welke typen gebruikers toegang hebben tot gedeeltes van de site.',
				'pl' => 'Ustaw, którzy użytkownicy mogą mieć dostęp do odpowiednich sekcji witryny.',
				'ru' => 'Управление правами доступа, ограничение доступа определённых групп пользователей к произвольным разделам сайта.',
				'sl' => 'Uredite dovoljenja kateri tip uporabnika lahko vidi določena področja vaše strani.',
				'tw' => '用來控制不同類別的用戶，設定其瀏覽特定網站內容的權限。',
				'cn' => '用来控制不同类别的用户，设定其浏览特定网站内容的权限。',
				'hu' => 'A felhasználók felügyelet alatt tartására, hogy milyen típusú felhasználók, mit láthatnak, mely szakaszain az oldalnak.',
				'th' => 'ควบคุมว่าผู้ใช้งานจะเห็นหมวดหมู่ไหนบ้าง',
				'se' => 'Hantera gruppbehörigheter.',
			),
			'frontend' => false,
			'backend'  => true,
			'menu'	  => 'users',
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('permissions');

		$tables = array(
			'permissions' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'group_id' => array('type' => 'INT', 'constraint' => 11, 'key' => true),
				'module' => array('type' => 'VARCHAR', 'constraint' => 50,),
				'roles' => array('type' => 'TEXT', 'null' => true,),
			),
		);

		if ( ! $this->install_tables($tables))
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
		return true;
	}

}