<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Themes extends Module {

	public $version = '1.0';
	
	/**
	 * The modules tables.
	 *
	 * @var array
	 */
	public $tables = array(
		'theme_options' => array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
			'slug' => array('type' => 'VARCHAR', 'constraint' => 30,),
			'title' => array('type' => 'VARCHAR', 'constraint' => 100,),
			'description' => array('type' => 'TEXT', 'constraint' => 100,),
			'type' => array('type' => 'set', 'constraint' => array('text', 'textarea', 'password', 'select', 'select-multiple', 'radio', 'checkbox')),
			'default' => array('type' => 'VARCHAR', 'constraint' => 255,),
			'value' => array('type' => 'VARCHAR', 'constraint' => 255,),
			'options' => array('type' => 'VARCHAR', 'constraint' => 255,),
			'is_required' => array('type' => 'INT', 'constraint' => 1,),
			'theme' => array('type' => 'VARCHAR', 'constraint' => 50,),
		),
	);
	
	public function info()
	{
		$info = array(
			'name' => array(
				'sl' => 'Predloge',
				'en' => 'Themes',
				'nl' => "Thema&apos;s",
				'es' => 'Temas',
				'fr' => 'Thèmes',
				'de' => 'Themen',
				'pl' => 'Motywy',
				'br' => 'Temas',
				'zh' => '佈景主題',
				'it' => 'Temi',
				'ru' => 'Темы',
				'ar' => 'السّمات',
				'cs' => 'Motivy vzhledu',
				'fi' => 'Teemat',
				'el' => 'Θέματα Εμφάνισης',
				'he' => 'ערכות נושאים',
				'lt' => 'Temos',
				'da' => 'Temaer',
				'id' => 'Tema'
			),
			'description' => array(
				'sl' => 'Dovoljuje adminom in osebju spremembo izgleda spletne strani, namestitev novega izgleda in urejanja le tega v bolj vizualnem pristopu',
				'en' => 'Allows admins and staff to switch themes, upload new themes, and manage theme options.',
				'nl' => 'Maakt het voor administratoren en medewerkers mogelijk om het thema van de website te wijzigen, nieuwe thema&apos;s te uploaden en ze visueel te beheren.',
				'es' => 'Permite a los administradores y miembros del personal cambiar el tema del sitio web, subir nuevos temas y manejar los ya existentes.',
				'fr' => 'Permet aux administrateurs et au personnel de modifier le thème du site, de charger de nouveaux thèmes et de le gérer de façon plus visuelle',
				'de' => 'Ermöglicht es dem Administrator das Seiten Thema auszuwählen, neue Themen hochzulanden oder diese visuell zu verwalten.',
				'pl' => 'Umożliwia administratorowi zmianę motywu strony, wgrywanie nowych motywów oraz zarządzanie nimi.',
				'br' => 'Permite aos administradores e membros da equipe fazer upload de novos temas e gerenciá-los através de uma interface visual.',
				'zh' => '讓管理者可以更改網站顯示風貌，以視覺化的操作上傳並管理這些網站佈景主題。',
				'it' => 'Permette ad amministratori e staff di cambiare il tema del sito, carica nuovi temi e gestiscili in um modo più visuale.',
				'ru' => 'Управление темами оформления сайта, загрузка новых тем.',
				'ar' => 'تمكّن الإدارة وأعضاء الموقع تغيير سِمة الموقع، وتحميل سمات جديدة وإدارتها بطريقة مرئية سلسة.',
				'cs' => 'Umožňuje administrátorům a dalším osobám měnit vzhled webu, nahrávat nové motivy a spravovat je.',
				'fi' => 'Mahdollistaa sivuston teeman vaihtamisen, uusien teemojen lataamisen ja niiden hallinnoinnin visuaalisella käyttöliittymällä.',
				'el' => 'Επιτρέπει στους διαχειριστές να αλλάξουν το θέμα προβολής του ιστοτόπου να ανεβάσουν νέα θέματα και να τα διαχειριστούν.',
				'he' => 'ניהול של ערכות נושאים שונות - עיצוב',
				'lt' => 'Leidžiama administratoriams ir personalui keisti puslapio temą, įkraunant naują temą ir valdyti ją.',
				'da' => 'Lader administratore ændre websidens tema, uploade nye temaer og håndtére dem med en mere visual tilgang.',
				'id' => 'Memungkinkan admin dan staff untuk mengubah tema tampilan, mengupload tema baru, dan mengatur opsi tema.'
			),
			'frontend' => false,
			'backend' => true,
			'menu' => 'design'
		);

		// Check to make sure we're not running the installer or MSM. Then check perms
		if ( ! class_exists('Module_import') AND Settings::get('addons_upload'))
		{
			$info['sections'] = array(
				'themes' => array('name' => 'themes.list_title',
					'uri' => 'admin/themes',
					'shortcuts' => array(
						array('name' => 'themes.upload_title',
							'uri' => 'admin/themes/upload',
							'class' => 'add modal',
						)
					)
				),
			);
		}

		return $info;
	}

	public function uninstall()
	{
		//it's a core module, lets keep it around
		return false;
	}

	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return true;
	}
	
	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return true;
	}
}