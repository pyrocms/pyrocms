<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Module_Variables extends Module {

	public $version = '0.3.1';
	
	public function info()
	{
		return array(
			'name' => array(
				'sl' => 'Spremenljivke',
				'en' => 'Variables',
				'nl' => 'Variabelen',
				'pl' => 'Zmienne',
				'es' => 'Variables',
				'fr' => 'Variables',
				'de' => 'Variablen',
				'pt' => 'Variáveis',
				'zh' => '系統變數',
				'it' => 'Variabili',
				'ru' => 'Переменные',
				'ar' => 'المتغيّرات',
				'cs' => 'Proměnné',
				'fi' => 'Muuttujat',
				'el' => 'Μεταβλητές',
				'he' => 'משתנים',
				'lt' => 'Kintamieji'
			),
			'description' => array(
				'sl' =>	'Urejanje globalnih spremenljivk za dostop od kjerkoli',
				'en' => 'Manage global variables to access from everywhere.',
				'nl' => 'Beheer globale variabelen die overal beschikbaar zijn.',
				'pl' => 'Zarządzaj globalnymi zmiennymi do których masz dostęp z każdego miejsca aplikacji.',
				'es' => 'Manage global variables to access from everywhere.',
				'fr' => 'Manage global variables to access from everywhere.',
				'de' => 'Verwaltet globale Variablen, auf die von überall zugegriffen werden kann.',
				'pt' => 'Gerencia as variáveis globais acessíveis de qualquer lugar.',
				'zh' => '管理此網站內可存取的全局變數。',
				'it' => 'Gestisci le variabili globali per accedervi da ogni parte.',
				'ru' => 'Управление глобальными переменными, которые доступны в любом месте сайта.',
				'ar' => 'إدارة المُتغيّرات العامة لاستخدامها في أرجاء الموقع.',
				'cs' => 'Spravujte globální proměnné přístupné odkudkoliv.',
				'fi' => 'Hallitse globaali muuttujia, joihin pääsee käsiksi mistä vain.',
				'el' => 'Διαχείριση μεταβλητών που είναι προσβάσιμες από παντού στον ιστότοπο.',
				'he' => 'ניהול משתנים גלובליים אשר ניתנים להמרה בכל חלקי האתר',
				'lt' => 'Globalių kintamujų tvarkymas kurie yra pasiekiami iš bet kur.'
			),
			'frontend'	=> FALSE,
			'backend'	=> TRUE,
			'menu'		=> 'content'
		);
	}
	
	public function install()
	{
		$this->dbforge->drop_table('variables');
		
		$variables = "
			CREATE TABLE " . $this->db->dbprefix('variables') . " (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
			  `data` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";
		
		if($this->db->query($variables))
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
		return "<h4>Overview</h4>
		<p>With the Variables module you can add simple values and display them anywhere on the site.</p>
		<h4>Adding Global Variables</h4><hr>
		<p>To use Variables simply choose a short name and assign a value. You can then embed the
			generated tag in page content, blog posts, etc. and the assigned value will be displayed.</p>";
	}
}

/* End of file details.php */
