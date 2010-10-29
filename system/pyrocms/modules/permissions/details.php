<?php defined('BASEPATH') or exit('No direct script access allowed');

class Details_Permissions extends Module {

	public $version = '0.5';
	
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
				'br' => 'Permissões',
				'zh' => '權限'
			),
			'description' => array(
				'en' => 'Control what type of users can see certain sections within the site.',
				'nl' => 'Bepaal welke typen gebruikers toegang hebben tot gedeeltes van de site.',
				'pl' => 'Ustaw, którzy użytkownicy mogą mieć dostęp do odpowiednich sekcji witryny.',
				'es' => 'Controla que tipo de usuarios pueden ver secciones específicas dentro del sitio.',
				'fr' => 'Permet de définir les autorisations des groupes d\'utilisateurs pour afficher les différentes sections.',
				'de' => 'Regelt welche Art von Benutzer welche Sektion in der Seite sehen kann.',
				'br' => 'Controle quais tipos de usuários podem ver certas seções no site.',
				'zh' => '用來控制不同類別的用戶，設定其瀏覽特定網站內容的權限。'
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
			CREATE TABLE `permissions` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `group_id` int(11) NOT NULL,
			  `module` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
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
		return "No documentation has been added for this module.";
	}
}
/* End of file details.php */