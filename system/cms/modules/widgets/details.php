<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Widgets extends Module {

	public $version = '1.1';
	
	/**
	 * The modules tables.
	 *
	 * @var array
	 */
	protected $_tables = array(
		'widgets',
		'widget_areas',
		'widget_instances',
	);
	
	public function info()
	{
		return array(
			'name' => array(
				'sl' => 'Vtičniki',
				'en' => 'Widgets',
				'es' => 'Widgets',
				'br' => 'Widgets',
				'de' => 'Widgets',
				'nl' => 'Widgets',
				'fr' => 'Widgets',
				'zh' => '小組件',
				'it' => 'Widgets',
				'ru' => 'Виджеты',
				'ar' => 'الودجت',
				'cs' => 'Widgety',
				'fi' => 'Widgetit',
				'lt' => 'Papildiniai',
				'id' => 'Widget'
			),
			'description' => array(
				'sl' => 'Urejanje manjših delov blokov strani ti. Vtičniki (Widgets)',
				'en' => 'Manage small sections of self-contained logic in blocks or "Widgets".',
				'es' => 'Manejar pequeñas secciones de lógica autocontenida en bloques o "Widgets"',
				'br' => 'Gerenciar pequenas seções de conteúdos em bloco conhecidos como "Widgets".',
				'de' => 'Verwaltet kleine, eigentständige Bereiche, genannt "Widgets".',
				'nl' => 'Beheer kleine onderdelen die zelfstandige logica bevatten, ofwel "Widgets".',
				'fr' => 'Gérer des mini application ou "Widgets".',
				'zh' => '可將小段的程式碼透過小組件來管理。即所謂 "Widgets"，或稱為小工具、部件。',
				'it' => 'Gestisci piccole sezioni di logica a se stante in blocchi o "Widgets".',
				'ru' => 'Управление небольшими, самостоятельными блоками.',
				'ar' => 'إدارة أقسام صغيرة من البرمجيات في مساحات الموقع أو ما يُسمّى بالـ"وِدْجِتْ".',
				'cs' => 'Spravujte malé funkční části webu neboli "Widgety".',
				'fi' => 'Hallitse pieniä osioita, jotka sisältävät erillisiä lohkoja tai "Widgettejä".',
				'el' => 'Διαχείριση μικρών τμημάτων αυτόνομης προγραμματιστικής λογικής σε πεδία ή "Widgets".',
				'lt' => 'Nedidelių, savarankiškų blokų valdymas.',
				'da' => 'Håndter små sektioner af selv-opretholdt logik i blokke eller "Widgets".',
				'id' => 'Mengatur bagian-bagian kecil dari blok-blok yang memuat sesuatu atau dikenal dengan istilah "Widget".'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => 'content',
			
			'sections' => array(
			    'instances' => array(
				    'name' => 'widgets.instances',
				    'uri' => 'admin/widgets',
				),
				'areas' => array(
				    'name' => 'widgets.areas',
				    'uri' => 'admin/widgets/areas',
				    'shortcuts' => array(
						array(
						    'name' => 'widgets.add_area',
						    'uri' => 'admin/widgets/areas/create',
						),
				    ),
			    ),
		    ),
		);
	}
	
	public function install()
	{
		$this->dbforge->drop_table('widget_areas');
		$this->dbforge->drop_table('widget_instances');
		$this->dbforge->drop_table('widgets');
		
		$tables = array(	
			'widget_areas' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true,),
				'title' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true,),
			),
			
			'widget_instances' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'title' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true,),
				'widget_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true,),
				'widget_area_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true,),
				'options' => array('type' => 'TEXT'),
				'order' => array('type' => 'INT', 'constraint' => 10, 'default' => 0,),
				'created_on' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
				'updated_on' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
			),
			
			'widgets' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => '',),
				'title' => array('type' => 'TEXT', 'constraint' => 100,),
				'description' => array('type' => 'TEXT', 'constraint' => 100,),
				'author' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => '',),
				'website' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => '',),
				'version' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => 0,),
				'enabled' => array('type' => 'INT', 'constraint' => 1, 'default' => 1,),
				'order' => array('type' => 'INT', 'constraint' => 10, 'default' => 0,),
				'updated_on' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
			),
		);

		$this->install_tables($tables);
		
		// Add the default data
		$this->db->insert('widget_areas', array(
			'title' => 'Sidebar',
			'slug' 	=> 'sidebar',
		));
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
