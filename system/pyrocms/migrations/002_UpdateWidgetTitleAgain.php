<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Updatewidgettitleagain extends Migration {
	
	function up() 
	{
		$this->migrations->verbose AND print "Update widget title to be not Arabic...";

		// Setup Keys
		$this->db
				
			->set('name', serialize(array(
				'en' => 'Widgets',
				'de' => 'Widgets',
				'nl' => 'Widgets',
				'fr' => 'Widgets',
				'zh' => '小組件',
				'it' => 'Widgets',
				'ru' => 'Виджеты',
				'ar' => 'الودجت',
				'sl' => 'Vtičniki'
			)))

			->set('description', serialize(array(
				'en' => 'Manage small sections of self-contained logic in blocks or "Widgets".',
				'br' => 'Gerenciar pequenas seções de conteúdos em bloco conhecidos como "Widgets".',
				'de' => 'Verwaltet kleine, eigentständige Bereiche, genannt "Widgets".',
				'nl' => 'Beheer kleine onderdelen die zelfstandige logica bevatten, ofwel "Widgets".',
				'fr' => 'Gérer des mini application ou "Widgets".',
				'zh' => '可將小段的程式碼透過小組件來管理。即所謂 "Widgets"，或稱為小工具、部件。',
				'it' => 'Gestisci piccole sezioni di logica a se stante in blocchi o "Widgets".',
				'sl' =>	'Uredite majša področja delčke vaš spletne strani - Vtičnike',
				'ru' => 'Управление небольшими, самостоятельными блоками.',
				'ar' => 'إدارة أقسام صغيرة من البرمجيات في مساحات الموقع أو ما يُسمّى بالـ"وِدْجِتْ".'

			)))

			->where('slug', 'widgets')
			->update('modules');
	}

	function down() 
	{
	}
}
