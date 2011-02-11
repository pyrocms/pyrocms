<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_News extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'News',
				'nl' => 'Nieuws',
				'es' => 'Artículos',
				'fr' => 'Actualités',
				'de' => 'News',
				'pl' => 'Aktualności',
				'pt' => 'Novidades',
				'zh' => '新聞',
				'it' => 'Notizie',
				'ru' => 'Новости',
				'ar' => 'الأخبار',
				'cs' => 'Novinky',
				'fi' => 'Uutiset'
			),
			'description' => array(
				'en' => 'Post news articles and blog entries.',
				'nl' => 'Post nieuwsartikelen en blogs op uw site.',
				'es' => 'Escribe entradas para los artículos y blogs (web log).',
				'fr' => 'Envoyez de nouveaux articles et messages de blog.',
				'de' => 'Veröffentliche neue Artikel und Blog-Einträge',
				'pl' => 'Postuj nowe artykuły oraz wpisy w blogu',
				'pt' => 'Escrever novos artigos e publicações de blog',
				'zh' => '發表新聞訊息、部落格文章。',
				'it' => 'Pubblica notizie e post per il blog.',
				'ru' => 'Управление новостными статьями и записями блога.',
				'ar' => 'أنشر مقالات الأخبار والمُدوّنات.',
				'cs' => 'Publikujte nové články a příspěvky na blog.',
				'fi' => 'Kirjoita uutisartikkeleita tai blogi artikkeleita.'
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'skip_xss' => TRUE,
			'menu' => 'content'
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('news_categories');
		$this->dbforge->drop_table('news');
		
		$news_categories = "
			CREATE TABLE `news_categories` (
			  `id` int(11) NOT NULL auto_increment,
			  `slug` varchar(20) collate utf8_unicode_ci NOT NULL default '',
			  `title` varchar(20) collate utf8_unicode_ci NOT NULL default '',
			  PRIMARY KEY  (`id`),
			  UNIQUE KEY `slug - unique` (`slug`),
			  UNIQUE KEY `title - unique` (`title`),
			  KEY `slug - normal` (`slug`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='News Categories';
		";

		$news = "
			CREATE TABLE `news` (
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
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='News articles or blog posts.';
		";
		
		if($this->db->query($news_categories) && $this->db->query($news))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{		
		if($this->dbforge->drop_table('news_categories') &&
		   $this->dbforge->drop_table('news'))
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
				<p>The News module is a simple tool for publishing blog entries or news articles.</p>
				<h4>Categories</h4>
				<p>You may create as many categories as you like to organize your posts. If you would like your visitors to
				be able to browse by category simply embed the News Categories widget on the front-end.</p>
				<h4>Articles</h4>
				<p>Choose a good title for your posts as they will be displayed on the main News page (along with the introduction)
				and will also be used as the title in search engine results. After creating a post you may either save it as Live to publish it or
				you may save it as a Draft if you want to come back and edit it later. You may also save it as Live but set the date
				in the future and your post will not show until that date is reached.</p>";
	}
}

/* End of file details.php */
