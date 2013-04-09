<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Groups module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Groups
 */
 class Module_Groups extends Module
{

	public $version = '1.0.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Groups',
				'ar' => 'المجموعات',
				'br' => 'Grupos',
				'pt' => 'Grupos',
				'cs' => 'Skupiny',
				'da' => 'Grupper',
				'de' => 'Gruppen',
				'el' => 'Ομάδες',
				'es' => 'Grupos',
                            'fa' => 'گروه ها',
				'fi' => 'Ryhmät',
				'fr' => 'Groupes',
				'he' => 'קבוצות',
				'id' => 'Grup',
				'it' => 'Gruppi',
				'lt' => 'Grupės',
				'nl' => 'Groepen',
				'ru' => 'Группы',
				'sl' => 'Skupine',
				'tw' => '群組',
				'cn' => '群组',
				'hu' => 'Csoportok',
				'th' => 'กลุ่ม',
				'se' => 'Grupper',
			),
			'description' => array(
				'en' => 'Users can be placed into groups to manage permissions.',
				'ar' => 'يمكن وضع المستخدمين في مجموعات لتسهيل إدارة صلاحياتهم.',
				'br' => 'Usuários podem ser inseridos em grupos para gerenciar suas permissões.',
				'pt' => 'Utilizadores podem ser inseridos em grupos para gerir as suas permissões.',
				'cs' => 'Uživatelé mohou být rozřazeni do skupin pro lepší správu oprávnění.',
				'da' => 'Brugere kan inddeles i grupper for adgangskontrol',
				'de' => 'Benutzer können zu Gruppen zusammengefasst werden um diesen Zugriffsrechte zu geben.',
				'el' => 'Οι χρήστες μπορούν να τοποθετηθούν σε ομάδες και έτσι να διαχειριστείτε τα δικαιώματά τους.',
				'es' => 'Los usuarios podrán ser colocados en grupos para administrar sus permisos.',
                            'fa' => 'کاربرها می توانند در گروه های ساماندهی شوند تا بتوان اجازه های مختلفی را ایجاد کرد',
				'fi' => 'Käyttäjät voidaan liittää ryhmiin, jotta käyttöoikeuksia voidaan hallinnoida.',
				'fr' => 'Les utilisateurs peuvent appartenir à des groupes afin de gérer les permissions.',
				'he' => 'נותן אפשרות לאסוף משתמשים לקבוצות',
				'id' => 'Pengguna dapat dikelompokkan ke dalam grup untuk mengatur perizinan.',
				'it' => 'Gli utenti possono essere inseriti in gruppi per gestirne i permessi.',
				'lt' => 'Vartotojai gali būti priskirti grupei tam, kad valdyti jų teises.',
				'nl' => 'Gebruikers kunnen in groepen geplaatst worden om rechten te kunnen geven.',
				'ru' => 'Пользователей можно объединять в группы, для управления правами доступа.',
				'sl' => 'Uporabniki so lahko razvrščeni v skupine za urejanje dovoljenj',
				'tw' => '用戶可以依群組分類並管理其權限',
				'cn' => '用户可以依群组分类并管理其权限',
				'hu' => 'A felhasználók csoportokba rendezhetőek a jogosultságok kezelésére.',
				'th' => 'สามารถวางผู้ใช้ลงในกลุ่มเพื่',
				'se' => 'Användare kan delas in i grupper för att hantera roller och behörigheter.',
			),
			'frontend' => false,
			'backend' => true,
			'menu' => 'users',
			'shortcuts' => array(
				array(
					'name' => 'groups:add_title',
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

		if ( ! $this->install_tables($tables))
		{
			return false;
		}

		$groups = array(
			array('name' => 'admin', 'description' => 'Administrator',),
			array('name' => 'user', 'description' => 'User',),
		);

		foreach ($groups as $group)
		{
			if ( ! $this->db->insert('groups', $group))
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