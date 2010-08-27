<?php defined('BASEPATH') or exit('No direct script access allowed');

class Navigation_details extends Module {

	public $version = '1.0';
	
	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Navigation',
				'nl' => 'Navigatie',
				'es' => 'Navegación',
				'fr' => 'Navigation',
				'de' => 'Navigation',
				'pl' => 'Nawigacja',
				'br' => 'Navegação'
			),
			'description' => array(
				'en' => 'Manage links on navigation menu\'s and all the navigation groups they belong to.',
				'nl' => 'Beheer links op de navigatiemenu\'s en alle navigatiegroepen waar ze onder vallen.',
				'es' => 'Administra links en los menús de navegación y en todos los grupos de navegación al cual pertenecen.',
				'fr' => 'Gérer les liens du menu Navigation et tous les groupes de navigation auxquels ils appartiennent.',
				'de' => 'Verwalte Links in Navigations-Menus und alle zugehörigen Navigations-Gruppen',
				'pl' => 'Zarządzaj linkami w menu nawigacji oraz wszystkimi grupami nawigacji do których one należą.',
				'br' => 'Gerenciar links do menu de navegação e todos os grupos de navegação pertencentes a ele.'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => TRUE,
			'controllers' => array(
				'admin' => array('index', 'create', 'edit', 'delete'),
				'admin_groups' => array('index', 'create', 'edit', 'delete')
			)
		);
	}
	
	public function install()
	{
		// Your Install Logic
		return TRUE;
	}

	public function uninstall()
	{
		// Your Uninstall Logic
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