<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Redirects extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'nl' => 'Verwijzingen',
				'en' => 'Redirects',
				'fr' => 'Redirections',
				'it' => 'Reindirizzi',
				'ru' => 'Перенаправления',
				'ar' => 'التوجيهات',
				'pt' => 'Redirecionamentos',
				'cs' => 'Přesměrování',
				'fi' => 'Uudelleenohjaukset'
			),
			'description' => array(
				'nl' => 'Verwijs vanaf een URL naar een andere.',
				'en' => 'Redirect from one URL to another.',
				'fr' => 'Redirection d\'une URL à un autre.',
				'it' => 'Reindirizza da una URL ad un altra.',
				'ru' => 'Перенаправления с одного адреса на другой.',
				'ar' => 'التوجيه من رابط URL إلى آخر.',
				'pt' => 'Redirecionamento de uma URL para outra.',
				'cs' => 'Přesměrujte z jedné adresy URL na jinou.',
				'fi' => 'Uudelleenohjaa käyttäjän paikasta toiseen.'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => 'utilities'
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('redirects');
		
		$revisions = "
			CREATE TABLE `redirects` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `from` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
			  `to` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  KEY `request` (`from`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		";


		return (bool) $this->db->query($revisions);
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
