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
		
		$tables = array(
			'blog_categories' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => '', 'unique' => true, 'key' => true,),
				'title' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => '', 'unique' => true,),
			),
			'blog' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'title' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => '', 'unique' => true,),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => '',),
				'category_id' => array('type' => 'INT', 'constraint' => 11, 'key' => true,),
				'attachment' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => '',),
				'intro' => array('type' => 'TEXT',),
				'body' => array('type' => 'TEXT',),
				'parsed' => array('type' => 'TEXT',),
				'keywords' => array('type' => 'VARCHAR', 'constraint' => 32, 'default' => '',),
				'author_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
				'created_on' => array('type' => 'INT', 'constraint' => 11,),
				'updated_on' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
				'comments_enabled' => array('type' => 'INT', 'constraint' => 1, 'default' => 1,),
				'status' => array('type' => 'ENUM', 'constraint' => array('draft', 'live'), 'default' => 'draft',),
				'type' => array('type' => 'SET', 'constraint' => array('html', 'markdown', 'wysiwyg-advanced', 'wysiwyg-simple')),
			),
		);

		$this->install_tables($tables);

		return TRUE;
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
