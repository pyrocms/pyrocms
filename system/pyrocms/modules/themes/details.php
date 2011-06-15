<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Themes extends Module {

	public $version = '1.0';
	
	public function info()
	{
		return array(
			'name' => array(
				'sl' => 'Predloge',
				'en' => 'Themes',
				'nl' => "Thema&apos;s",
				'es' => 'Temas',
				'fr' => 'Thèmes',
				'de' => 'Themen',
				'pl' => 'Motywy',
				'pt' => 'Temas',
				'zh' => '佈景主題',
				'it' => 'Temi',
				'ru' => 'Темы',
				'ar' => 'السّمات',
				'cs' => 'Motivy vzhledu',
				'fi' => 'Teemat',
				'el' => 'Θέματα Εμφάνισης',
				'he' => 'ערכות נושאים',
				'lt' => 'Temos'
			),
			'description' => array(
				'sl' => 'Dovoljuje adminom in osebju spremembo izgleda spletne strani, namestitev novega izgleda in urejanja le tega v bolj vizualnem pristopu',
				'en' => 'Allows admins and staff to change website theme, upload new themes and manage them in a more visual approach.',
				'nl' => 'Maakt het voor administratoren en medewerkers mogelijk om het thema van de website te wijzigen, nieuwe thema&apos;s te uploaden en ze visueel te beheren.',
				'es' => 'Permite a los administradores y miembros del personal cambiar el tema del sitio web, subir nuevos temas y manejar los ya existentes.',
				'fr' => 'Permet aux administrateurs et au personnel de modifier le thème du site, de charger de nouveaux thèmes et de le gérer de façon plus visuelle',
				'de' => 'Ermöglicht es dem Administrator das Seiten Thema auszuwählen, neue Themen hochzulanden oder diese visuell zu verwalten.',
				'pl' => 'Umożliwia administratorowi zmianę motywu strony, wgrywanie nowych motywów oraz zarządzanie nimi.',
				'pt' => 'Permite aos administradores e membros da equipe fazer upload de novos temas e gerenciá-los através de uma interface visual.',
				'zh' => '讓管理者可以更改網站顯示風貌，以視覺化的操作上傳並管理這些網站佈景主題。',
				'it' => 'Permette ad amministratori e staff di cambiare il tema del sito, carica nuovi temi e gestiscili in um modo più visuale.',
				'ru' => 'Управление темами оформления сайта, загрузка новых тем.',
				'ar' => 'تمكّن الإدارة وأعضاء الموقع تغيير سِمة الموقع، وتحميل سمات جديدة وإدارتها بطريقة مرئية سلسة.',
				'cs' => 'Umožňuje administrátorům a dalším osobám měnit vzhled webu, nahrávat nové motivy a spravovat je.',
				'fi' => 'Mahdollistaa sivuston teeman vaihtamisen, uusien teemojen lataamisen ja niiden hallinnoinnin visuaalisella käyttöliittymällä.',
				'el' => 'Επιτρέπει στους διαχειριστές να αλλάξουν το θέμα προβολής του ιστοτόπου να ανεβάσουν νέα θέματα και να τα διαχειριστούν.',
				'he' => 'ניהול של ערכות נושאים שונות - עיצוב',
				'lt' => 'Leidžiama administratoriams ir personalui keisti puslapio temą, įkraunant naują temą ir valdyti ją.'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => 'design'
		);
	}
	
	public function install()
	{
		$this->dbforge->drop_table('theme_options');

		$theme_options = "
			CREATE TABLE " . $this->db->dbprefix('theme_options') . " (
			  `id` int(5) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			  `slug` varchar(30) collate utf8_unicode_ci NOT NULL,
			  `title` varchar(100) collate utf8_unicode_ci NOT NULL,
			  `description` text collate utf8_unicode_ci NOT NULL,
			  `type` set('text','textarea','password','select','select-multiple','radio','checkbox') collate utf8_unicode_ci NOT NULL,
			  `default` varchar(255) collate utf8_unicode_ci NOT NULL,
			  `value` varchar(255) collate utf8_unicode_ci NOT NULL,
			  `options` varchar(255) collate utf8_unicode_ci NOT NULL,
			  `is_required` tinyint(1) NOT NULL,
			  `theme` varchar(50) collate utf8_unicode_ci NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Stores theme options.';
		";

		if ($this->db->query($theme_options))
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
		return TRUE;
	}
}
/* End of file details.php */
