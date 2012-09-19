<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Merge_modules_themes extends CI_Migration
{
	public function up()
	{
		$this->db->insert('modules', array(
			'name' => serialize(array(
				'en' => 'Add-ons',
				'ar' => 'الإضافات',
				'br' => 'Complementos',
				'pt' => 'Complementos',
				'cs' => 'Doplňky',
				'da' => 'Add-ons',
				'de' => 'Erweiterungen',
				'el' => 'Πρόσθετα',
				'es' => 'Agregados',
				'fi' => 'Lisäosat',
				'fr' => 'Extensions',
				'he' => 'תוספות',
				'id' => 'Pengaya',
				'it' => 'Add-ons',
				'lt' => 'Priedai',
				'nl' => 'Add-ons',
				'pl' => 'Rozszerzenia',
				'ru' => 'Дополнения',
				'sl' => 'Razširitve',
				'zh' => '附加模組',
				'hu' => 'Bővítmények',
				'th' => 'ส่วนเสริม',
            	'se' => 'Add-ons',
			)),
			'slug'			=> 'addons',
			'version'		=> '2.0.0',
			'description'	=> serialize(array(
				'en' => 'Install, upload, configure and manage Modules, Themes and Widgets.'
			)),
			'skip_xss'		=> true,
			'is_frontend'	=> false,
			'is_backend'	=> true,
			'menu'			=> false,
			'enabled'		=> true,
			'installed'		=> true,
			'is_core'		=> true,
			'updated_on'	=> time()
		));

		$this->db
			->where_in('slug', array('modules', 'themes'))
			->delete('modules');
	}
	
	public function down()
	{
		
	}
}