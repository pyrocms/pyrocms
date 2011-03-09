<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Blog extends Module {

	public $version = '2.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Blog',
				'ar' => 'المدوّنة'
			),
			'description' => array(
				'en' => 'Post blog entries.',
				'nl' => 'Post nieuwsartikelen en blog op uw site.', #update translation
				'es' => 'Escribe entradas para los artículos y blog (web log).', #update translation
				'fr' => 'Envoyez de nouveaux posts et messages de blog.', #update translation
				'de' => 'Veröffentliche neue Artikel und Blog-Einträge', #update translation
				'pl' => 'Postuj nowe artykuły oraz wpisy w blogu', #update translation
				'pt' => 'Escrever publicações de blog',
				'zh' => '發表新聞訊息、部落格文章。', #update translation
				'it' => 'Pubblica notizie e post per il blog.', #update translation
				'ru' => 'Управление новостными статьями и записями блога.', #update translation
				'ar' => 'أنشر مقالات الأخبار والمُدوّنات.', #update translation
				'cs' => 'Publikujte nové články a příspěvky na blog.', #update translation
				'fi' => 'Kirjoita uutisartikkeleita tai blogi artikkeleita.' #update translation
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'skip_xss' => TRUE,
			'menu' => 'content'
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('blog_categories');
		$this->dbforge->drop_table('blog');
		
		$blog_categories = "
			CREATE TABLE `blog_categories` (
			  `id` int(11) NOT NULL auto_increment,
			  `slug` varchar(20) collate utf8_unicode_ci NOT NULL default '',
			  `title` varchar(20) collate utf8_unicode_ci NOT NULL default '',
			  PRIMARY KEY  (`id`),
			  UNIQUE KEY `slug - unique` (`slug`),
			  UNIQUE KEY `title - unique` (`title`),
			  KEY `slug - normal` (`slug`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Blog Categories.';
		";

		$blog = "
			CREATE TABLE `blog` (
			  `id` int(11) NOT NULL auto_increment,
			  `title` varchar(100) collate utf8_unicode_ci NOT NULL default '',
			  `slug` varchar(100) collate utf8_unicode_ci NOT NULL default '',
			  `category_id` int(11) NOT NULL,
			  `attachment` varchar(255) collate utf8_unicode_ci NOT NULL default '',
			  `intro` text collate utf8_unicode_ci NOT NULL,
			  `body` text collate utf8_unicode_ci NOT NULL,
			  `created_on` int(11) NOT NULL,
			  `updated_on` int(11) NOT NULL default 0,
			  `status` enum('draft','live') collate utf8_unicode_ci NOT NULL default 'draft',
			  PRIMARY KEY  (`id`),
			  UNIQUE KEY `title` (`title`),
			  KEY `category_id - normal` (`category_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Blog posts.';
		";
		
		if($this->db->query($blog_categories) && $this->db->query($blog))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{		
		if($this->dbforge->drop_table('blog_categories') &&
		   $this->dbforge->drop_table('blog'))
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
				<p>The Blog module is a simple tool for publishing blog entries.</p>
				<h4>Categories</h4>
				<p>You may create as many categories as you like to organize your posts. If you would like your visitors to
				be able to browse by category simply embed the Blog Categories widget on the front-end.</p>
				<h4>Posts</h4>
				<p>Choose a good title for your posts as they will be displayed on the main Blog page (along with the introduction)
				and will also be used as the title in search engine results. After creating a post you may either save it as Live to publish it or
				you may save it as a Draft if you want to come back and edit it later. You may also save it as Live but set the date
				in the future and your post will not show until that date is reached.</p>";
	}
}

/* End of file details.php */
