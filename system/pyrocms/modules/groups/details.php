<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Groups extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'sl' => 'Skupine',
				'en' => 'Groups',
				'pt' => 'Grupos',
				'de' => 'Gruppen',
				'nl' => 'Groepen',
				'fr' => 'Groupes',
				'zh' => '群組',
				'it' => 'Gruppi',
				'ru' => 'Группы',
				'ar' => 'المجموعات',
				'cs' => 'Skupiny',
				'es' => 'Grupos',
				'fi' => 'Ryhmät',
				'el' => 'Ομάδες',
				'he' => 'קבוצות',
				'lt' => 'Grupės'
			),
			'description' => array(
				'sl' => 'Uporabniki so lahko razvrščeni v skupine za urejanje dovoljenj',
				'en' => 'Users can be placed into groups to manage permissions.',
				'pt' => 'Usuários podem ser inseridos em grupos para gerenciar suas permissões.',
				'de' => 'Benutzer können zu Gruppen zusammengefasst werden um diesen Zugriffsrechte zu geben.',
				'nl' => 'Gebruikers kunnen in groepen geplaatst worden om rechten te kunnen geven.',
				'fr' => 'Les utilisateurs peuvent appartenir à des groupes afin de gérer les permissions.',
				'zh' => '用戶可以依群組分類並管理其權限',
				'it' => 'Gli utenti possono essere inseriti in gruppi per gestirne i permessi.',
				'ru' => 'Пользователей можно объединять в группы, для управления правами доступа.',
				'ar' => 'يمكن وضع المستخدمين في مجموعات لتسهيل إدارة صلاحياتهم.',
				'cs' => 'Uživatelé mohou být rozřazeni do skupin pro lepší správu oprávnění.',
				'es' => 'Los usuarios podrán ser colocados en grupos para administrar sus permisos.',
				'fi' => 'Käyttäjät voidaan liittää ryhmiin, jotta käyttöoikeuksia voidaan hallinnoida.',
				'el' => 'Οι χρήστες μπορούν να τοποθετηθούν σε ομάδες και να διαχειριστείτε τα δικαιώματά τους.',
				'he' => 'נותן אפשרות לאסוף משתמשים לקבוצות',
				'lt' => 'Vartotojai gali būti priskirti grupei tam, kad valdyti jų teises.'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => 'users'
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('groups');

		$groups = "
			CREATE TABLE IF NOT EXISTS " . $this->db->dbprefix('groups') . " (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
			  `description` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Permission roles such as admins, moderators, staff, etc' AUTO_INCREMENT=3 ;
		";

		$default_data = "
			INSERT INTO " . $this->db->dbprefix('groups') . " (`id`, `name`, `description`) VALUES
			(1, 'admin', 'Administrators'),
			(2, 'user', 'Users');
		";

		if($this->db->query($groups) && $this->db->query($default_data))
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
		return TRUE;
	}
}
/* End of file details.php */
