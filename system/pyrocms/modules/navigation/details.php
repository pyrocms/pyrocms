<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Navigation extends Module {

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
				'br' => 'Navegação',
				'zh' => '導航列',
				'it' => 'Navigazione',
				'ru' => 'Навигация',
				'ar' => 'الروابط'
			),
			'description' => array(
				'en' => 'Manage links on navigation menus and all the navigation groups they belong to.',
				'nl' => 'Beheer links op de navigatiemenu&apos;s en alle navigatiegroepen waar ze onder vallen.',
				'es' => 'Administra links en los menús de navegación y en todos los grupos de navegación al cual pertenecen.',
				'fr' => 'Gérer les liens du menu Navigation et tous les groupes de navigation auxquels ils appartiennent.',
				'de' => 'Verwalte Links in Navigationsmenüs und alle zugehörigen Navigationsgruppen',
				'pl' => 'Zarządzaj linkami w menu nawigacji oraz wszystkimi grupami nawigacji do których one należą.',
				'br' => 'Gerenciar links do menu de navegação e todos os grupos de navegação pertencentes a ele.',
				'zh' => '管理導航選單中的連結，以及它們所隸屬的導航群組。',
				'it' => 'Gestisci i collegamenti dei menu di navigazione e tutti i gruppi di navigazione da cui dipendono.',
				'ru' => 'Управление ссылками в меню навигации и группах, к которым они принадлежат.',
				'ar' => 'إدارة روابط وقوائم ومجموعات الروابط في الموقع.',
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => 'design'
		);
	}
	
	public function install()
	{
		$this->dbforge->drop_table('navigation_groups');
		$this->dbforge->drop_table('navigation_links');
		
		$navigation_groups = "
			CREATE TABLE `navigation_groups` (
			  `id` int(11) NOT NULL auto_increment,
			  `title` varchar(50) collate utf8_unicode_ci NOT NULL,
			  `abbrev` varchar(20) collate utf8_unicode_ci NOT NULL,
			  PRIMARY KEY  (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Navigation groupings. Eg, header, sidebar, footer, etc';
		";
		
		$navigation_links = "
			CREATE TABLE `navigation_links` (
			  `id` int(11) NOT NULL auto_increment,
			  `title` varchar(100) collate utf8_unicode_ci NOT NULL default '',
			  `link_type` VARCHAR( 20 ) collate utf8_unicode_ci NOT NULL default 'uri',
			  `page_id` int(11) NOT NULL default '0',
			  `module_name` varchar(50) collate utf8_unicode_ci NOT NULL default '',
			  `url` varchar(255) collate utf8_unicode_ci NOT NULL default '',
			  `uri` varchar(255) collate utf8_unicode_ci NOT NULL default '',
			  `navigation_group_id` int(5) NOT NULL default '0',
			  `position` int(5) NOT NULL default '0',
			  `target` varchar(10) NULL default NULL,
			  `class` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL default '',
			  PRIMARY KEY  (`id`),
			  KEY `navigation_group_id - normal` (`navigation_group_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Links for site navigation';
		";
		
		$default_groups = "
			INSERT INTO `navigation_groups` VALUES
			('1','Header','header'),
			('2','Sidebar','sidebar'),
			('3','Footer','footer');
		";
		
		$default_links = "
			INSERT INTO navigation_links (title, link_type, page_id, navigation_group_id, position) VALUES
			('Home', 'page', 1, 1, 1);
		";
		
		if($this->db->query($navigation_groups) &&
		   $this->db->query($navigation_links) &&
		   $this->db->query($default_groups) &&
		   $this->db->query($default_links))
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
		return "No documentation has been added for this module.";
	}
}
/* End of file details.php */
