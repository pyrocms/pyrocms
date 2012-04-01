<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Themes Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Themes
 */
class Module_Themes extends Module {

	public $version = '1.0';

	public function info()
	{
		$info = array(
			'name' => array(
				'en' => 'Themes',
				'ar' => 'السّمات',
				'br' => 'Temas',
				'cs' => 'Motivy vzhledu',
				'da' => 'Temaer',
				'de' => 'Themen',
				'el' => 'Θέματα Εμφάνισης',
				'es' => 'Temas',
				'fi' => 'Teemat',
				'fr' => 'Thèmes',
				'he' => 'ערכות נושאים',
				'id' => 'Tema',
				'it' => 'Temi',
				'lt' => 'Temos',
				'nl' => 'Thema\'s',
				'pl' => 'Motywy',
				'ru' => 'Темы',
				'sl' => 'Predloge',
				'zh' => '佈景主題',
				'hu' => 'Sablonok',
                                'se' => 'Teman'
			),
			'description' => array(
				'en' => 'Allows admins and staff to switch themes, upload new themes, and manage theme options.',
				'ar' => 'تمكّن الإدارة وأعضاء الموقع تغيير سِمة الموقع، وتحميل سمات جديدة وإدارتها بطريقة مرئية سلسة.',
				'br' => 'Permite aos administradores e membros da equipe fazer upload de novos temas e gerenciá-los através de uma interface visual.',
				'cs' => 'Umožňuje administrátorům a dalším osobám měnit vzhled webu, nahrávat nové motivy a spravovat je.',
				'da' => 'Lader administratore ændre websidens tema, uploade nye temaer og håndtére dem med en mere visual tilgang.',
				'de' => 'Ermöglicht es dem Administrator das Seiten Thema auszuwählen, neue Themen hochzulanden oder diese visuell zu verwalten.',
				'el' => 'Επιτρέπει στους διαχειριστές να αλλάξουν το θέμα προβολής του ιστοτόπου να ανεβάσουν νέα θέματα και να τα διαχειριστούν.',
				'es' => 'Permite a los administradores y miembros del personal cambiar el tema del sitio web, subir nuevos temas y manejar los ya existentes.',
				'fi' => 'Mahdollistaa sivuston teeman vaihtamisen, uusien teemojen lataamisen ja niiden hallinnoinnin visuaalisella käyttöliittymällä.',
				'fr' => 'Permet aux administrateurs et au personnel de modifier le thème du site, de charger de nouveaux thèmes et de le gérer de façon plus visuelle',
				'he' => 'ניהול של ערכות נושאים שונות - עיצוב',
				'id' => 'Memungkinkan admin dan staff untuk mengubah tema tampilan, mengupload tema baru, dan mengatur opsi tema.',
				'it' => 'Permette ad amministratori e staff di cambiare il tema del sito, carica nuovi temi e gestiscili in um modo più visuale.',
				'lt' => 'Leidžiama administratoriams ir personalui keisti puslapio temą, įkraunant naują temą ir valdyti ją.',
				'nl' => 'Maakt het voor administratoren en medewerkers mogelijk om het thema van de website te wijzigen, nieuwe thema&apos;s te uploaden en ze visueel te beheren.',
				'pl' => 'Umożliwia administratorowi zmianę motywu strony, wgrywanie nowych motywów oraz zarządzanie nimi.',
				'ru' => 'Управление темами оформления сайта, загрузка новых тем.',
				'sl' => 'Dovoljuje adminom in osebju spremembo izgleda spletne strani, namestitev novega izgleda in urejanja le tega v bolj vizualnem pristopu',
				'zh' => '讓管理者可以更改網站顯示風貌，以視覺化的操作上傳並管理這些網站佈景主題。',
                                'hu' => 'Az adminok megváltoztathatják az oldal kinézetét, feltölthetnek új kinézeteket és kezelhetik őket.',
                                'se' => 'Hantera webbplatsens utseende genom teman, ladda upp nya teman och hantera temainställningar.'
			),
			'frontend' => false,
			'backend'  => true,
			'menu'	  => 'design'
		);

		// Check to make sure we're not running the installer or MSM. Then check perms
		if ( ! class_exists('Module_import') AND Settings::get('addons_upload'))
		{
			$info['sections'] = array(
				'themes' => array(
					'name' => 'themes.list_title',
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

	public function install()
	{
		$this->dbforge->drop_table('theme_options');

		$tables = array(
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

		if ( ! $this->install_tables($tables))
		{
			return false;
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
		return TRUE;
	}

}