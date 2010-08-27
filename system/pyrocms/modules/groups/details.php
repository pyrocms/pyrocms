<?php defined('BASEPATH') or exit('No direct script access allowed');

class Groups_details extends Module {

	public $version = '1.0';
	
	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Groups',
				'br' => 'Grupos'
			),
			'description' => array(
				'en' => 'Users can be placed into groups to manage permissions.',
				'br' => 'Usuários podem ser inseridos em grupos para gerenciar permissões.'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => TRUE,
			'controllers' => array(
				'admin' => array('index', 'create', 'edit', 'delete')
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