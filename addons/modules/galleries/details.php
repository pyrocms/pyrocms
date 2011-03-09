<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Galleries extends Module {

	public $version = '1.1';

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
				'ru' => 'Галереи',
				'ar' => 'معارض الصّور',
				'pt' => 'Galerias',
				'cs' => 'Galerie',
				'es' => 'Galerías',
				'fi' => 'Galleriat'
			),
			'description' => array(
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
				'fi' => 'Galleria moduuli antaa käyttäjien luoda kuva gallerioita.'
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
			  `folder_id` int(11) NOT NULL,
			  `thumbnail_id` int(11) DEFAULT NULL,
			  `description` text,
			  `parent` int(11) DEFAULT NULL,
			  `updated_on` int(15) NOT NULL,
			  `preview` varchar(255) DEFAULT NULL,
			  `enable_comments` int(1) DEFAULT NULL,
			  `published` int(1) DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `slug` (`slug`),
			  UNIQUE KEY `thumbnail_id` (`thumbnail_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8
		";

		$gallery_images = "
			CREATE TABLE `gallery_images` (
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
		<p>The galleries module is a basic photo management tool. Features include drag & drop sorting, a crop tool, and sub galleries.</p>
		<h4>Creating Galleries</h4>
		<p>Click \"Create a new Gallery\" in the shortcut menu. Fill out the title, slug, and the (optional) Description. (The Description shows
		beside the gallery thumbnail at http://example.com/galleries). Choose whether you want to enable comments for this gallery or not
		and select Publish if you wish for the gallery to show in the list of galleries. Note: selecting Unpublish does not disable the gallery, it just
		removes it from the list at http://example.com/galleries. You can still create a navigation link directly to it and the
		gallery will be viewable. For example: http://example.com/galleries/gallery-title</p>
		<h4>Uploading Images</h4>
		<p>After saving the gallery select the Upload button to upload images. Fill out the title, select an image, choose which gallery to upload to, and
		fill in an (optional) caption. If the upload is not successful check your image size. Many hosts do not allow file uploads over 2MB. Many modern cameras
		produce images in exess of 5MB. To remedy this limitation you may either ask your host to change the upload limit or you may wish to
		resize your images before uploading. Resizing has the added advantage of faster upload times.</p>
		<h4>Manage Gallery</h4>
		<p>Click on List Galleries->Manage. Here you may change the gallery's title, slug, description, etc. If you want a thumbnail to represent this
		gallery in the gallery list you may choose one from the dropdown. To change the order that the images are displayed in on the front-end
		simply grab the images and drag them into the proper order.</p>
		<h4>Editing an Image</h4>
		<p>From the Manage page click on the image that you would like to edit. From the edit page you may change all of the image's info or crop the image.
		To crop simply click the Crop button, draw a box with your mouse where you would like the crop to be, close the modal window, and click Save. To
		delete the image check the Delete checkbox and click Save.</p>";
	}
}
/* End of file details.php */
