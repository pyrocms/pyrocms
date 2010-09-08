<?php defined('BASEPATH') or exit('No direct script access allowed');

class Details_Redirects extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Redirects'
			),
			'description' => array(
				'en' => 'Redirect from one URL to another.'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => 'utilities'
		);
	}

	public function install()
	{
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
		return "Some Help Stuff";
	}
}
/* End of file details.php */