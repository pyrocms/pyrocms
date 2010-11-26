<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Widgets extends Module {

	public $version = '1.0';
	
	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Widgets',
				'de' => 'Widgets',
				'nl' => 'Widgets',
                'fr' => 'Widgets',
				'zh' => '小組件',
				'it' => 'Widgets',
				'ru' => 'Виджеты',
				'en' => 'الودجت',
			),
			'description' => array(
				'en' => 'Manage small sections of self-contained logic in blocks or "Widgets".',
				'br' => 'Gerenciar pequenas seções de conteúdos em bloco conhecidos como "Widgets".',
				'de' => 'Verwaltet kleine, eigentständige Bereiche, genannt "Widgets".',
				'nl' => 'Beheer kleine onderdelen die zelfstandige logica bevatten, ofwel "Widgets".',
				'fr' => 'Gérer des mini application ou "Widgets".',
				'zh' => '可將小段的程式碼透過小組件來管理。即所謂 "Widgets"，或稱為小工具、部件。',
				'it' => 'Gestisci piccole sezioni di logica a se stante in blocchi o "Widgets".',
				'ru' => 'Управление небольшими, самостоятельными блоками.',
				'ar' => 'إدارة أقسام صغيرة من البرمجيات في مساحات الموقع أو ما يُسمّى بالـ"وِدْجِتْ".'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => 'content'
		);
	}
	
	public function install()
	{
		$this->dbforge->drop_table('widget_areas');
		$this->dbforge->drop_table('widget_instances');
		$this->dbforge->drop_table('widgets');
		
		$widget_areas = "
			CREATE TABLE `widget_areas` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `slug` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
			  `title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `unique_slug` (`slug`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";
		
		$widget_instances = "
			CREATE TABLE `widget_instances` (
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
			CREATE TABLE `widgets` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
			  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
			  `description` text COLLATE utf8_unicode_ci NOT NULL,
			  `author` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
			  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
			  `version` int(3) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";
		
		$default_data = "
			INSERT INTO widget_areas (slug, title) VALUES ('unsorted', 'Unsorted');
		";
		
		if($this->db->query($widget_areas) &&
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
