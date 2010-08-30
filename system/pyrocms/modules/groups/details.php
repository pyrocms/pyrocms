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
		$this->load->dbforge();
		$this->dbforge->drop_table('groups');
		
		$groups = "
			CREATE TABLE IF NOT EXISTS `groups` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
			  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
			  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Permission roles such as admins, moderators, staff, etc' AUTO_INCREMENT=3 ;
		";

		$default_data = "
			INSERT INTO `groups` (`id`, `title`, `name`, `description`) VALUES
			(1, 'Administator', 'admin', NULL),
			(2, 'User', 'user', NULL);
		";
		
		if($this->db->query($groups) && $this->db->query($default_data))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		$this->load->dbforge();
		if($this->dbforge->drop_table('groups'))
		{
			return TRUE;
		}
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