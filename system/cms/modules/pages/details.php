<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Pages Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Pages
 */
class Module_Pages extends Module
{
	public $version = '2.2.0';

	public function info()
	{
		$info = array(
			'name' => array(
				'en' => 'Pages',
				'ar' => 'الصفحات',
				'br' => 'Páginas',
				'pt' => 'Páginas',
				'cs' => 'Stránky',
				'da' => 'Sider',
				'de' => 'Seiten',
				'el' => 'Σελίδες',
				'es' => 'Páginas',
                            'fa' => 'صفحه ها ',
				'fi' => 'Sivut',
				'fr' => 'Pages',
				'he' => 'דפים',
				'id' => 'Halaman',
				'it' => 'Pagine',
				'lt' => 'Puslapiai',
				'nl' => 'Pagina&apos;s',
				'pl' => 'Strony',
				'ru' => 'Страницы',
				'sl' => 'Strani',
				'tw' => '頁面',
				'cn' => '页面',
				'hu' => 'Oldalak',
				'th' => 'หน้าเพจ',
            	'se' => 'Sidor',
			),
			'description' => array(
				'en' => 'Add custom pages to the site with any content you want.',
				'ar' => 'إضافة صفحات مُخصّصة إلى الموقع تحتوي أية مُحتوى تريده.',
				'br' => 'Adicionar páginas personalizadas ao site com qualquer conteúdo que você queira.',
				'pt' => 'Adicionar páginas personalizadas ao seu site com qualquer conteúdo que você queira.',
				'cs' => 'Přidávejte vlastní stránky na web s jakýmkoliv obsahem budete chtít.',
				'da' => 'Tilføj brugerdefinerede sider til dit site med det indhold du ønsker.',
				'de' => 'Füge eigene Seiten mit anpassbaren Inhalt hinzu.',
				'el' => 'Προσθέστε και επεξεργαστείτε σελίδες στον ιστότοπό σας με ό,τι περιεχόμενο θέλετε.',
				'es' => 'Agrega páginas customizadas al sitio con cualquier contenido que tu quieras.',
                            'fa' => 'ایحاد صفحات جدید و دلخواه با هر محتوایی که دوست دارید',
				'fi' => 'Lisää mitä tahansa sisältöä sivustollesi.',
				'fr' => "Permet d'ajouter sur le site des pages personalisées avec le contenu que vous souhaitez.",
				'he' => 'ניהול דפי תוכן האתר',
				'id' => 'Menambahkan halaman ke dalam situs dengan konten apapun yang Anda perlukan.',
				'it' => 'Aggiungi pagine personalizzate al sito con qualsiesi contenuto tu voglia.',
				'lt' => 'Pridėkite nuosavus puslapius betkokio turinio',
				'nl' => "Voeg aangepaste pagina&apos;s met willekeurige inhoud aan de site toe.",
				'pl' => 'Dodaj własne strony z dowolną treścią do witryny.',
				'ru' => 'Управление информационными страницами сайта, с произвольным содержимым.',
				'sl' => 'Dodaj stran s kakršno koli vsebino želite.',
				'tw' => '為您的網站新增自定的頁面。',
				'cn' => '为您的网站新增自定的页面。',
				'th' => 'เพิ่มหน้าเว็บที่กำหนดเองไปยังเว็บไซต์ของคุณตามที่ต้องการ',
				'hu' => 'Saját oldalak hozzáadása a weboldalhoz, akármilyen tartalommal.',
            	'se' => 'Lägg till egna sidor till webbplatsen.',
			),
			'frontend' => true,
			'backend'  => true,
			'skip_xss' => true,
			'menu'	  => 'content',

			'roles' => array(
				'put_live', 'edit_live', 'delete_live',
                'create_types', 'edit_types', 'delete_types'
			),

			'sections' => array(
			    'pages' => array(
				    'name' => 'pages:list_title',
				    'uri' => 'admin/pages',
				),
				'types' => array(
				    'name' => 'page_types:list_title',
				    'uri' => 'admin/pages/types'
			    ),
			),
		);

		// We check that the table exists (only when in the admin controller)
		// to avoid any pre 109 migration module class spawning issues.
		if (class_exists('Admin_controller') and $this->db->table_exists('page_types'))
		{
			// Shortcuts for New page

			// Do we have more than one page type? If we don't, no need to have a modal
			// ask them to choose a page type.
			if ($this->db->count_all('page_types') > 1)
			{

				$info['sections']['pages']['shortcuts'] = array(
					array(
					    'name' => 'pages:create_title',
					    'uri' => 'admin/pages/choose_type?modal=true',
					    'class' => 'add modal'
					)
				);
			}
			else
			{
				// Get the one page type. 
				$page_type = $this->db->limit(1)->select('id')->get('page_types')->row();

				$info['sections']['pages']['shortcuts'] = array(
					array(
					    'name' => 'pages:create_title',
					    'uri' => 'admin/pages/create?page_type='.$page_type->id,
					    'class' => 'add'
					)
				);			
			}

			// Show the correct +Add button based on the page
			if ($this->uri->segment(4) == 'fields' and $this->uri->segment(5))
			{
				$info['sections']['types']['shortcuts'] = array(
								array(
								    'name' => 'streams:new_field',
								    'uri' => 'admin/pages/types/fields/'.$this->uri->segment(5).'/new_field',
								    'class' => 'add'
								)
						    );
			}
			else
			{
				$info['sections']['types']['shortcuts'] = array(
								array(
								    'name' => 'pages:types_create_title',
								    'uri' => 'admin/pages/types/create',
								    'class' => 'add'
								)
							);			
			}
		}

		return $info;
	}

	public function install()
	{
		$this->dbforge->drop_table('page_types');
		$this->dbforge->drop_table('pages');

		// Just in case. If this is a new install, we 
		// definiitely should not have a page_chunks table.
		$this->dbforge->drop_table('page_chunks');

		// We only need to do this if the def_page_fields table
		// has already been added.
		if ($this->db->table_exists('def_page_fields'))
		{
			$this->load->driver('Streams');
			$this->streams->utilities->remove_namespace('pages');
			$this->dbforge->drop_table('def_page_fields');
		}

		if ($this->db->table_exists('data_streams'))
		{
			$this->db->where('stream_namespace', 'pages')->delete('data_streams');
		}

		$this->load->helper('date');
		$this->load->config('pages/pages');

		$tables = array(
			'page_types' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
				'title' => array('type' => 'VARCHAR', 'constraint' => 60),
				'description' => array('type' => 'TEXT', 'null' => true),
				'stream_id' => array('type' => 'INT', 'constraint' => 11),
				'meta_title' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
				'meta_keywords' => array('type' => 'CHAR', 'constraint' => 32, 'null' => true),
				'meta_description' => array('type' => 'TEXT', 'null' => true),
				'body' => array('type' => 'TEXT'),
				'css' => array('type' => 'TEXT', 'null' => true),
				'js' => array('type' => 'TEXT', 'null' => true),
				'theme_layout' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => 'default'),
				'updated_on' => array('type' => 'INT', 'constraint' => 11),
	            'save_as_files'     => array('type' => 'CHAR', 'constraint' => 1, 'default' => 'n'),
	            'content_label'     => array('type' => 'VARCHAR', 'constraint' => 60, 'null' => true),
	            'title_label'     => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true)
			),
			'pages' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => '', 'key' => 'slug'),
				'class' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
				'title' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
				'uri' => array('type' => 'TEXT', 'null' => true),
				'parent_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0, 'key' => 'parent_id'),
				'type_id' => array('type' => 'VARCHAR', 'constraint' => 255),
				'entry_id' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
				'css' => array('type' => 'TEXT', 'null' => true),
				'js' => array('type' => 'TEXT', 'null' => true),
				'meta_title' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
				'meta_keywords' => array('type' => 'CHAR', 'constraint' => 32, 'null' => true),
				'meta_robots_no_index' => array('type' => 'TINYINT', 'constraint' => 1, 'null' => true),
				'meta_robots_no_follow' => array('type' => 'TINYINT', 'constraint' => 1, 'null' => true),
				'meta_description' => array('type' => 'TEXT', 'null' => true),
				'rss_enabled' => array('type' => 'INT', 'constraint' => 1, 'default' => 0),
				'comments_enabled' => array('type' => 'INT', 'constraint' => 1, 'default' => 0),
				'status' => array('type' => 'ENUM', 'constraint' => array('draft', 'live'), 'default' => 'draft'),
				'created_on' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
				'updated_on' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
				'restricted_to' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
				'is_home' => array('type' => 'INT', 'constraint' => 1, 'default' => 0),
				'strict_uri' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
				'order' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
			),
		);

		if ( ! $this->install_tables($tables))
		{
			return false;
		}

		$this->load->driver('streams');

		$stream_id = $this->streams->streams->add_stream(
			'Default',
			'def_page_fields',
			'pages',
			null,
			'A simple page type with a WYSIWYG editor that will get you started adding content.'
		);
	
		// add the fields to the streams
		$this->streams->fields->add_fields(config_item('pages:default_fields'));

		// Insert the page type structures
		$page_type = 	array(
			'id' => 1,
			'title' => 'Default',
			'slug' => 'default',
			'description' => 'A simple page type with a WYSIWYG editor that will get you started adding content.',
			'stream_id' => $stream_id,
			'body' => '<h2>{{ page:title }}</h2>'."\n\n".'{{ body }}',
			'css' => '',
			'js' => '',
			'updated_on' => now()
		);

		if ( ! $this->db->insert('page_types', $page_type))
		{
			return false;
		}

		$def_page_type_id = $this->db->insert_id();

		$page_content = config_item('pages:default_page_content');
		$page_entries = array(
			'home' => array(
				'slug' => 'home',
				'title' => 'Home',
				'uri' => 'home',
				'parent_id' => 0,
				'type_id' => $def_page_type_id,
				'status' => 'live',
				'restricted_to' => '',
				'created_on' => now(),
				'is_home' => true,
				'order' => now()
			),
			'contact' => array(
				'slug' => 'contact',
				'title' => 'Contact',
				'uri' => 'contact',
				'parent_id' => 0,
				'type_id' => $def_page_type_id,
				'status' => 'live',
				'restricted_to' => '',
				'created_on' => now(),
				'is_home' => false,
				'order' => now()
			),
			'search' => array(
				'slug' => 'search',
				'title' => 'Search',
				'uri' => 'search',
				'parent_id' => 0,
				'type_id' => $def_page_type_id,
				'status' => 'live',
				'restricted_to' => '',
				'created_on' => now(),
				'is_home' => false,
				'order' => now()
			),
			'search-results' => array(
				'slug' => 'results',
				'title' => 'Results',
				'uri' => 'search/results',
				'parent_id' => 3,
				'type_id' => $def_page_type_id,
				'status' => 'live',
				'restricted_to' => '',
				'created_on' => now(),
				'is_home' => false,
				'strict_uri' => false,
				'order' => now()
			),
			'fourohfour' => array(
				'slug' => '404',
				'title' => 'Page missing',
				'uri' => '404',
				'parent_id' => 0,
				'type_id' => $def_page_type_id,
				'status' => 'live',
				'restricted_to' => '',
				'created_on' => now(),
				'is_home' => false,
				'order' => now()
			)
		);

		foreach ($page_entries as $key => $d)
		{
			// Contact Page
			$this->db->insert('pages', $d);
			$page_id = $this->db->insert_id();

			$this->db->insert('def_page_fields', $page_content[$key]);
			$entry_id = $this->db->insert_id();

			$this->db->where('id', $page_id);
			$this->db->update('pages', array('entry_id' => $entry_id));

			unset($page_id);
			unset($entry_id);
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