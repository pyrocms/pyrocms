<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Galleries extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Galleries',
				'de' => 'Galerien',
				'nl' => 'Gallerijen',
				'fr' => 'Galeries',
				'zh' => '畫廊',
				'it' => 'Gallerie',
				'ru' => 'Галереи'
			),
			'description' => array(
				'en' => 'The galleries module is a powerful module that lets users create image galleries.',
				'de' => 'Mit dem Galerie Modul kannst du Bildergalerien anlegen.',
				'nl' => 'De gallerij module is een krachtige module dat gebruikers in staat stelt gallerijen te plaatsen.',
				'fr' => 'Galerie est une puissante extension permettant de créer des galeries d\'images.',
				'zh' => '這是一個功能完整的模組，可以讓用戶建立自己的相簿或畫廊。',
				'it' => 'Il modulo gallerie è un potente modulo che permette agli utenti di creare gallerie di immagini.',
				'ru' => 'Галереи - мощный модуль, который даёт пользователям возможность создавать галереи изображений.'
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => 'content'
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('galleries');
		$this->dbforge->drop_table('gallery_images');
		
		$galleries = "
			CREATE TABLE `galleries` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `title` varchar(255) NOT NULL,
			  `slug` varchar(255) NOT NULL,
			  `thumbnail_id` int(11) DEFAULT NULL,
			  `description` text,
			  `parent` int(11) DEFAULT NULL,
			  `updated_on` int(15) NOT NULL,
			  `preview` varchar(255) DEFAULT NULL,
			  `enable_comments` INT( 1 ) DEFAULT NULL,
			  `published` INT(1) DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `slug` (`slug`),
			  UNIQUE KEY `thumbnail_id` (`thumbnail_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";

		$gallery_images = "
			CREATE TABLE `gallery_images` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `gallery_id` int(11) NOT NULL,
			  `filename` varchar(255) NOT NULL,
			  `extension` varchar(255) NOT NULL,
			  `title` varchar(255) DEFAULT 'Untitled',
			  `description` text,
			  `uploaded_on` int(15) DEFAULT NULL,
			  `updated_on` int(15) DEFAULT NULL,
			  `order` INT(11) DEFAULT '0',
			  PRIMARY KEY (`id`),
			  KEY `gallery_id` (`gallery_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";

		if($this->db->query($galleries) && $this->db->query($gallery_images))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{		
		if($this->dbforge->drop_table('galleries') &&
		   $this->dbforge->drop_table('gallery_images'))
		{
			return TRUE;
		}
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
		return "No documentation has been added for this module.<br/>Contact the module developer for assistance.";
	}
}
/* End of file details.php */