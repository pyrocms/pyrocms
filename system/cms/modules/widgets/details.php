<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Widgets extends Module {

	public $version = '1.1';
	
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
		
		$widget_areas = "
			CREATE TABLE " . $this->db->dbprefix('widget_areas') . " (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `slug` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
			  `title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `unique_slug` (`slug`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";
		
		$widget_instances = "
			CREATE TABLE " . $this->db->dbprefix('widget_instances') . " (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
			  `widget_id` int(11) DEFAULT NULL,
			  `widget_area_id` int(11) DEFAULT NULL,
			  `options` text COLLATE utf8_unicode_ci NOT NULL,
			  `order` int(10) NOT NULL DEFAULT '0',
			  `created_on` int(11) NOT NULL DEFAULT '0',
			  `updated_on` int(11) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";
		
		$widgets = "
			CREATE TABLE " . $this->db->dbprefix('widgets') . " (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
			  `title` text COLLATE utf8_unicode_ci NOT NULL,
			  `description` text COLLATE utf8_unicode_ci NOT NULL,
			  `author` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
			  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
			  `version` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
			  `enabled` tinyint(1) NOT NULL DEFAULT '1',
			  `order` int(5) NOT NULL DEFAULT '0',
			  `updated_on` int(11) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";
		
		$default_data = "
			INSERT INTO " . $this->db->dbprefix('widget_areas') . " (slug, title) VALUES ('sidebar', 'Sidebar');
		";
		
		if ($this->db->query($widget_areas) &&
		   $this->db->query($widget_instances) &&
		   $this->db->query($widgets) &&
		   $this->db->query($default_data))
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
