<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Navigation extends Module {

	public $version = '1.1';
	
	public $_tables = array('navigation_groups', 'navigation_links');
	
	public function info()
	{
		return array(
			'name' => array(
				'sl' => 'Navigacija',
				'en' => 'Navigation',
				'nl' => 'Navigatie',
				'es' => 'Navegación',
				'fr' => 'Navigation',
				'de' => 'Navigation',
				'pl' => 'Nawigacja',
				'br' => 'Navegação',
				'zh' => '導航選單',
				'it' => 'Navigazione',
				'ru' => 'Навигация',
				'ar' => 'الروابط',
				'cs' => 'Navigace',
				'fi' => 'Navigointi',
				'el' => 'Πλοήγηση',
				'he' => 'ניווט',
				'lt' => 'Navigacija',
				'id' => 'Navigasi',
			),
			'description' => array(
				'sl' => 'Uredi povezave v meniju in vse skupine povezav ki jim pripadajo.',
				'en' => 'Manage links on navigation menus and all the navigation groups they belong to.',
				'nl' => 'Beheer koppelingen op de navigatiemenu&apos;s en alle navigatiegroepen waar ze onder vallen.',
				'es' => 'Administra links en los menús de navegación y en todos los grupos de navegación al cual pertenecen.',
				'fr' => 'Gérer les liens du menu Navigation et tous les groupes de navigation auxquels ils appartiennent.',
				'de' => 'Verwalte Links in Navigationsmenüs und alle zugehörigen Navigationsgruppen',
				'pl' => 'Zarządzaj linkami w menu nawigacji oraz wszystkimi grupami nawigacji do których one należą.',
				'br' => 'Gerenciar links do menu de navegação e todos os grupos de navegação pertencentes a ele.',
				'zh' => '管理導航選單中的連結，以及它們所隸屬的導航群組。',
				'it' => 'Gestisci i collegamenti dei menu di navigazione e tutti i gruppi di navigazione da cui dipendono.',
				'ru' => 'Управление ссылками в меню навигации и группах, к которым они принадлежат.',
				'ar' => 'إدارة روابط وقوائم ومجموعات الروابط في الموقع.',
				'cs' => 'Správa odkazů v navigaci a všech souvisejících navigačních skupin.',
				'fi' => 'Hallitse linkkejä navigointi valikoissa ja kaikkia navigointi ryhmiä, joihin ne kuuluvat.',
				'el' => 'Διαχειριστείτε τους συνδέσμους στα μενού πλοήγησης και όλες τις ομάδες συνδέσμων πλοήγησης στις οποίες ανήκουν.',
				'he' => 'ניהול שלוחות תפריטי ניווט וקבוצות ניווט',
				'lt' => 'Tvarkyk nuorodas navigacijų menių ir visas navigacijų grupes kurioms tos nuorodos priklauso.',
				'da' => 'Håndtér links på navigationsmenuerne og alle navigationsgrupperne de tilhører.',
				'id' => 'Mengatur tautan pada menu navigasi dan semua pengelompokan grup navigasi.',
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => 'design',
			
		    'shortcuts' => array(
				array(
				    'name' => 'nav_group_create_title',
				    'uri' => 'admin/navigation/groups/create',
				    'class' => 'add',
				),
		    ),
		);
	}
	
	public function install()
	{
		$this->dbforge->drop_table('navigation_groups');
		$this->dbforge->drop_table('navigation_links');

		$tables = array(
			'navigation_groups' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'title' => array('type' => 'VARCHAR', 'constraint' => 50,),
				'abbrev' => array('type' => 'VARCHAR', 'constraint' => 50, 'key' => true),
			),
			'navigation_links' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'title' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => '',),
				'parent' => array('type' => 'INT', 'constraint' => 11, 'null' => true,),
				'link_type' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => 'uri',),
				'page_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true,),
				'module_name' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => '',),
				'url' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => '',),
				'uri' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => '',),
				'navigation_group_id' => array('type' => 'INT', 'constraint' => 5, 'default' => 0, 'key' => 'navigation_group_id'),
				'position' => array('type' => 'INT', 'constraint' => 5, 'default' => 0,),
				'target' => array('type' => 'VARCHAR', 'constraint' => 10, 'null' => true,),
				'restricted_to' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true,),
				'class' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => '',),
			),
		);
		$this->install_tables($tables);

		$groups = array(
			array('title' => 'Header', 'abbrev' => 'header',),
			array('title' => 'Sidebar', 'abbrev' => 'sidebar',),
			array('title' => 'Footer', 'abbrev' => 'footer',),
		);
		foreach ($groups as $group)
		{
			$this->db->insert('navigation_groups', $group);
		}

		$links = array(
			array('title' => 'Home', 'link_type' => 'page', 'page_id' => 1, 'navigation_group_id' => 1, 'position' => 1,),
			array('title' => 'Blog', 'link_type' => 'module', 'page_id' => null, 'navigation_group_id' => 1, 'position' => 2, 'module_name' => 'blog'),
			array('title' => 'Contact', 'link_type' => 'page', 'page_id' => 3, 'navigation_group_id' => 1, 'position' => 3,),
		);
		foreach ($links as $link)
		{
			$this->db->insert('navigation_links', $link);
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
