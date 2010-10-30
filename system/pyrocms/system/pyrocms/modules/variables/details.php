<?php defined('BASEPATH') or exit('No direct script access allowed');

class Details_Variables extends Module {

	public $version = '0.3';
	
	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Variables',
				'nl' => 'Variabelen',
				'pl' => 'Zmienne',
				'es' => 'Variables',
				'fr' => 'Variables',
				'de' => 'Variablen',
				'br' => 'Variáveis',
				'zh' => '系統變數'
			),
			'description' => array(
				'en' => 'Manage global variables to access from everywhere.',
				'nl' => 'Beheer globale variabelen die overal beschikbaar zijn.',
				'pl' => 'Zarządzaj globalnymi zmiennymi do których masz dostęp z każdego miejsca aplikacji.',
				'es' => 'Manage global variables to access from everywhere.',
				'fr' => 'Manage global variables to access from everywhere.',
				'de' => 'Verwaltet globale Variablen, auf die von überall zugegriffen werden kann.',
				'br' => 'Gerencia as variáveis globais acessíveis de qualquer lugar.',
				'zh' => '管理此網站內可存取的全局變數。'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => 'content'
		);
	}
	
	public function install()
	{
		$this->dbforge->drop_table('variables');
		
		$variables = "
			CREATE TABLE `variables` (
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
		return "No documentation has been added for this module.";
	}
}
/* End of file details.php */