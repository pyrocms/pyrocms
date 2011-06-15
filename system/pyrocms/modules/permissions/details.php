<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Permissions extends Module {

	public $version = '0.5';
	
	public function info()
	{
		return array(
			'name' => array(
				'sl' => 'Dovoljenja',
				'en' => 'Permissions',
				'nl' => 'Toegangsrechten',
				'es' => 'Permisos',
				'fr' => 'Permissions',
				'de' => 'Zugriffsrechte',
				'pl' => 'Uprawnienia',
				'pt' => 'Permissões',
				'zh' => '權限',
				'it' => 'Permessi',
				'ru' => 'Права доступа',
				'ar' => 'الصلاحيات',
				'cs' => 'Oprávnění',
				'fi' => 'Käyttöoikeudet',
				'el' => 'Δικαιώματα',
				'he' => 'הרשאות',
				'lt' => 'Teisės'
			),
			'description' => array(
				'sl' => 'Uredite dovoljenja kateri tip uporabnika lahko vidi določena področja vaše strani.',
				'en' => 'Control what type of users can see certain sections within the site.',
				'nl' => 'Bepaal welke typen gebruikers toegang hebben tot gedeeltes van de site.',
				'pl' => 'Ustaw, którzy użytkownicy mogą mieć dostęp do odpowiednich sekcji witryny.',
				'es' => 'Controla que tipo de usuarios pueden ver secciones específicas dentro del sitio.',
				'fr' => 'Permet de définir les autorisations des groupes d\'utilisateurs pour afficher les différentes sections.',
				'de' => 'Regelt welche Art von Benutzer welche Sektion in der Seite sehen kann.',
				'pt' => 'Controle quais tipos de usuários podem ver certas seções no site.',
				'zh' => '用來控制不同類別的用戶，設定其瀏覽特定網站內容的權限。',
				'it' => 'Controlla che tipo di utenti posssono accedere a determinate sezioni del sito.',
				'ru' => 'Управление правами доступа, ограничение доступа определённых групп пользователей к произвольным разделам сайта.',
				'ar' => 'التحكم بإعطاء الصلاحيات للمستخدمين للوصول إلى أقسام الموقع المختلفة.',
				'cs' => 'Spravujte oprávnění pro jednotlivé typy uživatelů a ke kterým sekcím mají přístup.',
				'fi' => 'Hallitse minkä tyyppisiin osioihin käyttäjät pääsevät sivustolla.',
				'el' => 'Ελέγξτε οι χρήστες ποιας ομάδας μπορούν να δούν ποιες περιοχές του ιστοτόπου.',
				'he' => 'ניהול הרשאות כניסה לאיזורים מסוימים באתר',
				'lt' => 'Kontroliuokite kokio tipo varotojai kokią dalį puslapio gali pasiekti.'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => 'users'
		);
	}
	
	public function install()
	{
		$this->dbforge->drop_table('permissions');
		
		$permission_rules = "
			CREATE TABLE " . $this->db->dbprefix('permissions') . " (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `group_id` int(11) NOT NULL,
			  `module` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
			  `roles` text NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Contains a list of modules that a group can access.';
		";
		
		if($this->db->query($permission_rules))
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
		return TRUE;
	}
	
	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "<h2>Overview</h2>
				<p>The Permissions module works together with the User Manager and the Groups module to give PyroCMS access control.</p>
				<h2>Setting Permissions</h2>
				<p>New groups have no permissions at all by default. Simply check the box
				by each module that you want users in that group to be able to access.</p>";
	}
}
/* End of file details.php */
