<?php defined('BASEPATH') or exit('No direct script access allowed');

class Permissions_details extends Module {

	public $version = '0.3';
	
	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Permissions',
				'nl' => 'Toegangsrechten',
				'es' => 'Permisos',
				'fr' => 'Permissions',
				'de' => 'Zugriffsrechte',
				'pl' => 'Uprawnienia',
				'br' => 'Permissões'
			),
			'description' => array(
				'en' => 'Control what type of users can see certain sections within the site.',
				'nl' => 'Bepaal welke typen gebruikers toegang hebben tot gedeeltes van de site.',
				'pl' => 'Ustaw, którzy użytkownicy mogą mieć dostęp do odpowiednich sekcji witryny.',
				'es' => 'Controla que tipo de usuarios pueden ver secciones específicas dentro del sitio.',
				'de' => 'Steuert welche Art von Benutzer welche Sektion in der Seite sehen kann.',
				'br' => 'Controle quais tipos de usuários podem ver certas seções no site.'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => TRUE,
			'controllers' => array(
				'admin' => array('index', 'create', 'edit', 'delete'),
			)
		);
	}
	
	public function install()
	{
		$this->dbforge->drop_table('permission_roles');
		$this->dbforge->drop_table('permission_rules');
		
		$permission_rules = "
			CREATE TABLE `permission_rules` (
			  `id` int(11) NOT NULL auto_increment,
			  `user_id` int(11) NOT NULL,
			  `permission_role_id` int(11) NOT NULL,
			  `module` varchar(50) collate utf8_unicode_ci NOT NULL,
			  `controller` varchar(50) collate utf8_unicode_ci NOT NULL,
			  `method` varchar(50) collate utf8_unicode_ci NOT NULL,
			  PRIMARY KEY  (`id`),
			  KEY `user` (`user_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Permission rules for permission roles';
		";
		
		if($this->db->query($permission_rules))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		// Your Uninstall Logic
		return TRUE;
	}

	public function upgrade($old_version)
	{
		//it's a core module, lets keep it around
		return FALSE;
	}
	
	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "Some Help Stuff";
	}
}
/* End of file details.php */