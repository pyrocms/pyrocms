<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Blog extends Module {

	public $version = '2.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Blog',
				'ar' => 'المدوّنة',
				'el' => 'Ιστολόγιο',
				'br' => 'Blog',
				'pl' => 'Blog',
				'he' => 'בלוג',
				'lt' => 'Blogas',
				'ru' => 'Блог',
				'zh' => '文章',
				'id' => 'Blog'
			),
			'description' => array(
				'en' => 'Post blog entries.',
				'nl' => 'Post nieuwsartikelen en blogs op uw site.',
				'es' => 'Escribe entradas para los artículos y blog (web log).', #update translation
				'fr' => 'Envoyez de nouveaux posts et messages de blog.', #update translation
				'de' => 'Veröffentliche neue Artikel und Blog-Einträge', #update translation
				'pl' => 'Dodawaj nowe wpisy na blogu',
				'br' => 'Escrever publicações de blog',
				'zh' => '發表新聞訊息、部落格等文章。',
				'it' => 'Pubblica notizie e post per il blog.', #update translation
				'ru' => 'Управление записями блога.',
				'ar' => 'أنشر المقالات على مدوّنتك.',
				'cs' => 'Publikujte nové články a příspěvky na blog.', #update translation
				'sl' => 'Objavite blog prispevke',
				'fi' => 'Kirjoita uutisartikkeleita tai blogi artikkeleita.', #update translation
				'el' => 'Δημιουργήστε άρθρα και εγγραφές στο ιστολόγιο σας.',
				'he' => 'ניהול בלוג',
				'lt' => 'Rašykite naujienas bei blog\'o įrašus.',
				'da' => 'Skriv blogindlæg',
				'id' => 'Post entri blog'
			),
			'frontend'	=> TRUE,
			'backend'	=> TRUE,
			'skip_xss'	=> TRUE,
			'menu'		=> 'content',

			'roles' => array(
				'put_live', 'edit_live', 'delete_live'
			),
			
			'sections' => array(
			    'posts' => array(
				    'name' => 'blog_posts_title',
				    'uri' => 'admin/blog',
				    'shortcuts' => array(
						array(
					 	   'name' => 'blog_create_title',
						    'uri' => 'admin/blog/create',
						    'class' => 'add'
						),
					),
				),
				'categories' => array(
				    'name' => 'cat_list_title',
				    'uri' => 'admin/blog/categories',
				    'shortcuts' => array(
						array(
						    'name' => 'cat_create_title',
						    'uri' => 'admin/blog/categories/create',
						    'class' => 'add'
						),
				    ),
			    ),
		    ),
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('blog_categories');
		$this->dbforge->drop_table('blog');

		$blog_categories = "
			CREATE TABLE " . $this->db->dbprefix('blog_categories') . " (
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
			CREATE TABLE " . $this->db->dbprefix('blog') . " (
			  `id` int(11) NOT NULL auto_increment,
			  `title` varchar(100) collate utf8_unicode_ci NOT NULL default '',
			  `slug` varchar(100) collate utf8_unicode_ci NOT NULL default '',
			  `category_id` int(11) NOT NULL,
			  `attachment` varchar(255) collate utf8_unicode_ci NOT NULL default '',
			  `intro` text collate utf8_unicode_ci NOT NULL,
			  `body` text collate utf8_unicode_ci NOT NULL,
			  `parsed` text collate utf8_unicode_ci NOT NULL,
			  `keywords` varchar(32) NOT NULL default '',
			  `author_id` int(11) NOT NULL default '0',
			  `created_on` int(11) NOT NULL,
			  `updated_on` int(11) NOT NULL default 0,
              `comments_enabled` INT(1)  NOT NULL default '1',
			  `status` enum('draft','live') collate utf8_unicode_ci NOT NULL default 'draft',
			  `type` set('html','markdown','wysiwyg-advanced','wysiwyg-simple') collate utf8_unicode_ci NOT NULL,
			  PRIMARY KEY  (`id`),
			  UNIQUE KEY `title` (`title`),
			  KEY `category_id - normal` (`category_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Blog posts.';
		";

		if ($this->db->query($blog_categories) && $this->db->query($blog))
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
		/**
		 * Either return a string containing help info
		 * return "Some help info";
		 *
		 * Or add a language/help_lang.php file and
		 * return TRUE;
		 *
		 * help_lang.php contents
		 * $lang['help_body'] = "Some help info";
		*/
		return TRUE;
	}
}

/* End of file details.php */
