<?php defined('BASEPATH') or exit('No direct script access allowed');

class Modules_details extends Module {

	public $version = '1.0';
	
	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Modules',
				'nl' => 'Modules',
				'es' => 'Módulos',
				'fr' => 'Modules',
				'de' => 'Module',
				'pl' => 'Moduły',
				'br' => 'Módulos'
			),
			'description' => array(
				'en' => 'Allows admins to see a list of currently installed modules.',
				'nl' => 'Stelt admins in staat om een overzicht van geinstalleerde modules te genereren.',
				'es' => 'Permite a los administradores ver una lista de los módulos instalados.',
				'fr' => 'Permet aux administrateurs de voir la liste des modules installés',
				'de' => 'Zeigt Administratoren alle aktuell installierten Module.',
				'pl' => 'Umożliwiają administratorowi wgląd do listy obecnie zainstalowanych modułów.',
				'br' => 'Permite aos administradores ver a lista dos módulos instalados atualmente.'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => TRUE,
			'controllers' => array(
				'admin' => array('index', 'upload')
			)
		);
	}
	
	public function install()
	{
		$this->load->dbforge();
		$this->dbforge->drop_table('modules');
		
		$modules = "
			CREATE TABLE `modules` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` TEXT NOT NULL,
			  `slug` varchar(50) NOT NULL,
			  `version` varchar(20) NOT NULL,
			  `type` varchar(20) DEFAULT NULL,
			  `description` TEXT DEFAULT NULL,
			  `skip_xss` tinyint(1) NOT NULL,
			  `is_frontend` tinyint(1) NOT NULL,
			  `is_backend` tinyint(1) NOT NULL,
			  `is_backend_menu` tinyint(1) NOT NULL,
			  `enabled` tinyint(1) NOT NULL,
			  `installed` tinyint(1) NOT NULL,
			  `is_core` tinyint(1) NOT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `slug` (`slug`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";

		if($this->db->query($modules))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		// you really don't want to uninstall this module
		return TRUE;

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
		return "Some Help Stuff";
	}
}
/* End of file details.php */