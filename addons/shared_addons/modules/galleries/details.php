<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Galleries extends Module {

	public $version = '1.1';

	public function info()
	{
		return array(
			'name' => array(
				'sl' => 'Galerija',
				'en' => 'Galleries',
				'de' => 'Galerien',
				'nl' => 'Gallerijen',
				'fr' => 'Galeries',
				'zh' => '畫廊',
				'it' => 'Gallerie',
				'ru' => 'Галереи',
				'ar' => 'معارض الصّور',
				'pt' => 'Galerias',
				'cs' => 'Galerie',
				'es' => 'Galerías',
				'fi' => 'Galleriat',
				'lt' => 'Galerijos'
			),
			'description' => array(
				'sl' => 'Modul galerije je mogočen modul ki dovoljuje uporabnikom ustavrjanje galerije slik',
				'en' => 'The galleries module is a powerful module that lets users create image galleries.',
				'de' => 'Mit dem Galerie Modul kannst du Bildergalerien anlegen.',
				'nl' => 'De gallerij module is een krachtige module dat gebruikers in staat stelt gallerijen te plaatsen.',
				'fr' => 'Galerie est une puissante extension permettant de créer des galeries d\'images.',
				'zh' => '這是一個功能完整的模組，可以讓用戶建立自己的相簿或畫廊。',
				'it' => 'Il modulo gallerie è un potente modulo che permette agli utenti di creare gallerie di immagini.',
				'ru' => 'Галереи - мощный модуль, который даёт пользователям возможность создавать галереи изображений.',
				'ar' => 'هذه الوحدة تمُكّنك من إنشاء معارض الصّور بسهولة.',
				'pt' => 'O módulo de galerias é um poderoso módulo que permite aos usuários criar galerias de imagens.',
			    'cs' => 'Silný modul pro vytváření a správu galerií obrázků.',
				'es' => 'Galerías es un potente módulo que permite a los usuarios crear galerías de imágenes.',
				'fi' => 'Galleria moduuli antaa käyttäjien luoda kuva gallerioita.',
				'lt' => 'Galerijos modulis leidžia vartotojams kurti nuotraukų galerijas'
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
			CREATE TABLE ".$this->db->dbprefix('galleries')." (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `title` varchar(255) NOT NULL,
			  `slug` varchar(255) NOT NULL,
			  `folder_id` int(11) NOT NULL,
			  `thumbnail_id` int(11) DEFAULT NULL,
			  `description` text,
			  `updated_on` int(15) NOT NULL,
			  `preview` varchar(255) DEFAULT NULL,
			  `enable_comments` int(1) DEFAULT NULL,
			  `published` int(1) DEFAULT NULL,
			  `css` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
			  `js` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `slug` (`slug`),
			  UNIQUE KEY `thumbnail_id` (`thumbnail_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8
		";

		$gallery_images = "
			CREATE TABLE ".$this->db->dbprefix('gallery_images')." (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `file_id` int(11) NOT NULL,
			  `gallery_id` int(11) NOT NULL,
			  `order` int(11) DEFAULT '0',
			  PRIMARY KEY (`id`),
			  KEY `gallery_id` (`gallery_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8
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
		return "<h4>Overview</h4>
		<p>The galleries module is a basic photo management tool. Features include drag & drop sorting and sub galleries.</p>
		<h4>Creating Galleries</h4>
		<p>To create a gallery go to Content->Files and create a new folder. Come back to Galleries and click \"Create a new gallery\" and select the folder of images that you just created in the File manager.
		Fill out the title, slug, and the (optional) Description. (The Description shows
		beside the gallery thumbnail at http://example.com/galleries). Choose whether you want to enable comments for this gallery or not
		and select Publish if you wish for the gallery to show in the list of galleries. Note: selecting Unpublish does not disable the gallery, it just
		removes it from the list at http://example.com/galleries. You can still create a navigation link directly to it and the
		gallery will be viewable. For example: http://example.com/galleries/gallery-title</p>
		<h4>Uploading Images</h4>
		<p>For instructions on how to upload images refer to the Files documentation.</p>
		<h4>Manage Gallery</h4>
		<p>Click on List Galleries->Manage. Here you may change the gallery's title, slug, description, etc. If you want a thumbnail to represent this
		gallery in the gallery list you may choose one from the dropdown and click Save. To change the order that the images are displayed in on the front-end
		simply grab the images and drag them into the proper order.</p>
		<h4>Editing an Image</h4>
		<p>From the Manage page click on the image that you would like to edit. A modal window will appear and you may change
		the title and the description of the image. You may also move the image to a different folder.</p>";
	}
}
/* End of file details.php */