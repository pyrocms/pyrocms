<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Widgets Module
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Widgets
 */
class Module_Widgets extends Module
{

	public $version = '1.2.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Widgets',
				'br' => 'Widgets',
				'pt' => 'Widgets',
				'cs' => 'Widgety',
				'da' => 'Widgets',
				'de' => 'Widgets',
				'el' => 'Widgets',
				'es' => 'Widgets',
				'fi' => 'Widgetit',
				'fr' => 'Widgets',
				'id' => 'Widget',
				'it' => 'Widgets',
				'lt' => 'Papildiniai',
				'nl' => 'Widgets',
				'ru' => 'Виджеты',
				'sl' => 'Vtičniki',
				'tw' => '小組件',
				'cn' => '小组件',
				'hu' => 'Widget-ek',
				'th' => 'วิดเจ็ต',
				'se' => 'Widgetar',
				'ar' => 'الودجتس',
			),
			'description' => array(
				'en' => 'Manage small sections of self-contained logic in blocks or "Widgets".',
				'ar' => 'إدارة أقسام صغيرة من البرمجيات في مساحات الموقع أو ما يُسمّى بالـ"ودجتس".',
				'br' => 'Gerenciar pequenas seções de conteúdos em bloco conhecidos como "Widgets".',
				'pt' => 'Gerir pequenas secções de conteúdos em bloco conhecidos como "Widgets".',
				'cs' => 'Spravujte malé funkční části webu neboli "Widgety".',
				'da' => 'Håndter små sektioner af selv-opretholdt logik i blokke eller "Widgets".',
				'de' => 'Verwaltet kleine, eigentständige Bereiche, genannt "Widgets".',
				'el' => 'Διαχείριση μικρών τμημάτων αυτόνομης προγραμματιστικής λογικής σε πεδία ή "Widgets".',
				'es' => 'Manejar pequeñas secciones de lógica autocontenida en bloques o "Widgets"',
				'fi' => 'Hallitse pieniä osioita, jotka sisältävät erillisiä lohkoja tai "Widgettejä".',
				'fr' => 'Gérer des mini application ou "Widgets".',
				'id' => 'Mengatur bagian-bagian kecil dari blok-blok yang memuat sesuatu atau dikenal dengan istilah "Widget".',
				'it' => 'Gestisci piccole sezioni di logica a se stante in blocchi o "Widgets".',
				'lt' => 'Nedidelių, savarankiškų blokų valdymas.',
				'nl' => 'Beheer kleine onderdelen die zelfstandige logica bevatten, ofwel "Widgets".',
				'ru' => 'Управление небольшими, самостоятельными блоками.',
				'sl' => 'Urejanje manjših delov blokov strani ti. Vtičniki (Widgets)',
				'tw' => '可將小段的程式碼透過小組件來管理。即所謂 "Widgets"，或稱為小工具、部件。',
				'cn' => '可将小段的程式码透过小组件来管理。即所谓 "Widgets"，或称为小工具、部件。',
				'hu' => 'Önálló kis logikai tömbök vagy widget-ek kezelése.',
				'th' => 'จัดการส่วนเล็ก ๆ ในรูปแบบของตัวเองในบล็อกหรือวิดเจ็ต',
				'se' => 'Hantera små sektioner med egen logik och innehåll på olika delar av webbplatsen.',
			),
			'frontend' => false,
			'backend' => true,
			'menu' => 'content',
			'skip_xss' => true,

			'sections' => array(

			    'instances' => array(
				    'name' => 'widgets:instances',
				    'uri' => 'admin/widgets',
				),
				'areas' => array(
				    'name' => 'widgets:areas',
				    'uri' => 'admin/widgets/areas',
				    'shortcuts' => array(
						array(
						    'name' => 'widgets:add_area',
						    'uri' => 'admin/widgets/areas/create',
						),
					),
				),
			),
		);
	}

	public function install()
	{
		$schema = $this->pdb->getSchemaBuilder();

		$schema->dropIfExists('widget_areas');
		$schema->create('widget_areas', function ($table)
		{
			$table->increments('id');
			$table->string('slug')->nullable();
			$table->string('title')->nullable();
		});

		$schema->dropIfExists('widget_instances');
		$schema->create('widget_instances', function ($table)
		{
			$table->increments('id');
			$table->string('title')->nullable();
			$table->integer('widget_id')->nullable();
			$table->integer('widget_area_id')->nullable();
			$table->text('options');
			$table->integer('order')->default(0);
			$table->integer('created_on');
			$table->integer('updated_on')->nullable();

			// $table->foreign('widget_id'); // TODO: Need more documentation to make this work.
			// $table->foreign('widget_area_id'); // TODO: Need more documentation to make this work.
		});

		$schema->dropIfExists('widget_instances');
		$schema->create('widget_instances', function ($table)
		{
			$table->increments('id');
			$table->string('slug')->default('');
			$table->string('title');
			$table->text('description');
			$table->string('author')->default('');
			$table->string('website')->default('');
			$table->string('version')->default('');
			$table->boolean('enabled')->default(true);
			$table->integer('order')->default(0);
			$table->integer('created_on');
			$table->integer('updated_on')->nullable();
		});

		// Add the default data
		$this->pdb->table('widget_areas')->insert(array(
			'title' => 'Sidebar',
			'slug' => 'sidebar',
		));

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
