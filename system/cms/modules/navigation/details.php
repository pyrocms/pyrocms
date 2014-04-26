<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Navigation Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Navigation
 */
class Module_Navigation extends Module {

	public $version = '1.1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Navigation',
				'ar' => 'الروابط',
				'br' => 'Navegação',
				'pt' => 'Navegação',
				'cs' => 'Navigace',
				'da' => 'Navigation', #translate
				'de' => 'Navigation',
				'el' => 'Πλοήγηση',
				'es' => 'Navegación',
                            'fa' => 'منو ها',
				'fi' => 'Navigointi',
				'fr' => 'Navigation',
				'he' => 'ניווט',
				'id' => 'Navigasi',
				'it' => 'Navigazione',
				'lt' => 'Navigacija',
				'nl' => 'Navigatie',
				'pl' => 'Nawigacja',
				'ru' => 'Навигация',
				'sl' => 'Navigacija',
				'tw' => '導航選單',
				'cn' => '导航选单',
				'th' => 'ตัวช่วยนำทาง',
				'hu' => 'Navigáció',
				'se' => 'Navigation',
			),
			'description' => array(
				'en' => 'Manage links on navigation menus and all the navigation groups they belong to.',
				'ar' => 'إدارة روابط وقوائم ومجموعات الروابط في الموقع.',
				'br' => 'Gerenciar links do menu de navegação e todos os grupos de navegação pertencentes a ele.',
				'pt' => 'Gerir todos os grupos dos menus de navegação e os links de navegação pertencentes a eles.',
				'cs' => 'Správa odkazů v navigaci a všech souvisejících navigačních skupin.',
				'da' => 'Håndtér links på navigationsmenuerne og alle navigationsgrupperne de tilhører.',
				'de' => 'Verwalte Links in Navigationsmenüs und alle zugehörigen Navigationsgruppen',
				'el' => 'Διαχειριστείτε τους συνδέσμους στα μενού πλοήγησης και όλες τις ομάδες συνδέσμων πλοήγησης στις οποίες ανήκουν.',
				'es' => 'Administra links en los menús de navegación y en todos los grupos de navegación al cual pertenecen.',
                            'fa' => 'مدیریت منو ها و گروه های مربوط به آنها',
				'fi' => 'Hallitse linkkejä navigointi valikoissa ja kaikkia navigointi ryhmiä, joihin ne kuuluvat.',
				'fr' => 'Gérer les liens du menu Navigation et tous les groupes de navigation auxquels ils appartiennent.',
				'he' => 'ניהול שלוחות תפריטי ניווט וקבוצות ניווט',
				'id' => 'Mengatur tautan pada menu navigasi dan semua pengelompokan grup navigasi.',
				'it' => 'Gestisci i collegamenti dei menu di navigazione e tutti i gruppi di navigazione da cui dipendono.',
				'lt' => 'Tvarkyk nuorodas navigacijų menių ir visas navigacijų grupes kurioms tos nuorodos priklauso.',
				'nl' => 'Beheer koppelingen op de navigatiemenu&apos;s en alle navigatiegroepen waar ze onder vallen.',
				'pl' => 'Zarządzaj linkami w menu nawigacji oraz wszystkimi grupami nawigacji do których one należą.',
				'ru' => 'Управление ссылками в меню навигации и группах, к которым они принадлежат.',
				'sl' => 'Uredi povezave v meniju in vse skupine povezav ki jim pripadajo.',
				'tw' => '管理導航選單中的連結，以及它們所隸屬的導航群組。',
				'cn' => '管理导航选单中的连结，以及它们所隶属的导航群组。',
				'th' => 'จัดการการเชื่อมโยงนำทางและกลุ่มนำทาง',
				'se' => 'Hantera länkar och länkgrupper.',
				'hu' => 'Linkek kezelése a navigációs menükben és a navigációs csoportok kezelése, amikhez tartoznak.',
			),
			'frontend' => false,
			'backend'  => true,
			'menu'	  => 'structure',

		    'shortcuts' => array(
				array(
				    'name' => 'nav:group_create_title',
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
		if ( ! $this->install_tables($tables))
		{
			return false;
		}

		$groups = array(
			array('title' => 'Header', 'abbrev' => 'header',),
			array('title' => 'Sidebar', 'abbrev' => 'sidebar',),
			array('title' => 'Footer', 'abbrev' => 'footer',),
		);
		foreach ($groups as $group)
		{
			if ( ! $this->db->insert('navigation_groups', $group))
			{
				return false;
			}
		}

		$links = array(
			array('title' => 'Home', 'link_type' => 'page', 'page_id' => 1, 'navigation_group_id' => 1, 'position' => 1,),
			array('title' => 'Blog', 'link_type' => 'module', 'page_id' => null, 'navigation_group_id' => 1, 'position' => 2, 'module_name' => 'blog'),
			array('title' => 'Contact', 'link_type' => 'page', 'page_id' => 2, 'navigation_group_id' => 1, 'position' => 3,),
		);
		foreach ($links as $link)
		{
			if ( ! $this->db->insert('navigation_links', $link))
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