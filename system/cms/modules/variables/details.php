<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Variables Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Variables
 */
class Module_Variables extends Module {

	public $version = '0.4';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Variables',
				'ar' => 'المتغيّرات',
				'br' => 'Variáveis',
				'pt' => 'Variáveis',
				'cs' => 'Proměnné',
				'da' => 'Variable',
				'de' => 'Variablen',
				'el' => 'Μεταβλητές',
				'es' => 'Variables',
				'fi' => 'Muuttujat',
				'fr' => 'Variables',
				'he' => 'משתנים',
				'id' => 'Variabel',
				'it' => 'Variabili',
				'lt' => 'Kintamieji',
				'nl' => 'Variabelen',
				'pl' => 'Zmienne',
				'ru' => 'Переменные',
				'sl' => 'Spremenljivke',
				'zh' => '系統變數',
				'hu' => 'Változók',
				'th' => 'ตัวแปร',
                                'se' => 'Variabler'
			),
			'description' => array(
				'en' => 'Manage global variables that can be accessed from anywhere.',
				'ar' => 'إدارة المُتغيّرات العامة لاستخدامها في أرجاء الموقع.',
				'br' => 'Gerencia as variáveis globais acessíveis de qualquer lugar.',
				'pt' => 'Gerir as variáveis globais acessíveis de qualquer lugar.',
				'cs' => 'Spravujte globální proměnné přístupné odkudkoliv.',
				'da' => 'Håndtér globale variable som kan tilgås overalt.',
				'de' => 'Verwaltet globale Variablen, auf die von überall zugegriffen werden kann.',
				'el' => 'Διαχείριση μεταβλητών που είναι προσβάσιμες από παντού στον ιστότοπο.',
				'es' => 'Manage global variables to access from everywhere.',
				'fi' => 'Hallitse globaali muuttujia, joihin pääsee käsiksi mistä vain.',
				'fr' => 'Manage global variables to access from everywhere.',
				'he' => 'ניהול משתנים גלובליים אשר ניתנים להמרה בכל חלקי האתר',
				'id' => 'Mengatur variabel global yang dapat diakses dari mana saja.',
				'it' => 'Gestisci le variabili globali per accedervi da ogni parte.',
				'lt' => 'Globalių kintamujų tvarkymas kurie yra pasiekiami iš bet kur.',
				'nl' => 'Beheer globale variabelen die overal beschikbaar zijn.',
				'pl' => 'Zarządzaj globalnymi zmiennymi do których masz dostęp z każdego miejsca aplikacji.',
				'ru' => 'Управление глобальными переменными, которые доступны в любом месте сайта.',
				'sl' =>	'Urejanje globalnih spremenljivk za dostop od kjerkoli',
				'th' => 'จัดการตัวแปรทั่วไปโดยที่สามารถเข้าถึงได้จากทุกที่.',
				'zh' => '管理此網站內可存取的全局變數。',
                                'hu' => 'Globális változók kezelése a hozzáféréshez, bárhonnan.',
                                'se' => 'Hantera globala variabler som kan avändas över hela webbplatsen.'

			),
			'frontend'	=> false,
			'backend'	=> true,
			'menu'		=> 'content',
			'shortcuts' => array(
				array(
				    'name' => 'variables.create_title',
				    'uri' => 'admin/variables/create',
					'class' => 'add',
				),
		    ),
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('variables');

		$tables = array(
			'variables' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'name' => array('type' => 'VARCHAR', 'constraint' => 250, 'null' => true,),
				'data' => array('type' => 'VARCHAR', 'constraint' => 250, 'null' => true,),
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
		return true;
	}

}