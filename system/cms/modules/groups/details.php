<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Groups extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'sl' => 'Skupine',
				'en' => 'Groups',
				'br' => 'Grupos',
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
				'lt' => 'Grupės',
				'da' => 'Grupper',
				'id' => 'Grup'
			),
			'description' => array(
				'sl' => 'Uporabniki so lahko razvrščeni v skupine za urejanje dovoljenj',
				'en' => 'Users can be placed into groups to manage permissions.',
				'br' => 'Usuários podem ser inseridos em grupos para gerenciar suas permissões.',
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
				'el' => 'Οι χρήστες μπορούν να τοποθετηθούν σε ομάδες και έτσι να διαχειριστείτε τα δικαιώματά τους.',
				'he' => 'נותן אפשרות לאסוף משתמשים לקבוצות',
				'lt' => 'Vartotojai gali būti priskirti grupei tam, kad valdyti jų teises.',
				'da' => 'Brugere kan inddeles i grupper for adgangskontrol',
				'id' => 'Pengguna dapat dikelompokkan ke dalam grup untuk mengatur perizinan.'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => 'users',

			'shortcuts' => array(
				array(
			 	   'name' => 'groups.add_title',
				   'uri' => 'admin/groups/add',
				   'class' => 'add'
				),
			)
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('groups');

		$tables = array(
			'groups' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'name' => array('type' => 'VARCHAR', 'constraint' => 100,),
				'description' => array('type' => 'VARCHAR', 'constraint' => 250, 'null' => true,),
			),
		);
		$this->install_tables($tables);

		$groups = array(
			array('name' => 'admin', 'description' => 'Administrators',),
			array('name' => 'users', 'description' => 'Users',),
		);
		foreach ($groups as $group)
		{
			$this->db->insert('groups', $group);
		}

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
		// Return a string containing help info
		// You could include a file and return it here.
		return TRUE;
	}
}
/* End of file details.php */
