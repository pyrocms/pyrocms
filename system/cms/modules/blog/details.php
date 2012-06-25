<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Blog module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Blog
 */
class Module_Blog extends Module {

	public $version = '2.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Blog',
				'ar' => 'المدوّنة',
				'br' => 'Blog',
				'pt' => 'Blog',
				'el' => 'Ιστολόγιο',
				'he' => 'בלוג',
				'id' => 'Blog',
				'lt' => 'Blogas',
				'pl' => 'Blog',
				'ru' => 'Блог',
				'zh' => '文章',
				'hu' => 'Blog',
				'fi' => 'Blogi',
				'th' => 'บล็อก',
            	'se' => 'Blogg',
			),
			'description' => array(
				'en' => 'Post blog entries.',
				'ar' => 'أنشر المقالات على مدوّنتك.',
				'br' => 'Escrever publicações de blog',
				'pt' => 'Escrever e editar publicações no blog',
				'cs' => 'Publikujte nové články a příspěvky na blog.', #update translation
				'da' => 'Skriv blogindlæg',
				'de' => 'Veröffentliche neue Artikel und Blog-Einträge', #update translation
				'sl' => 'Objavite blog prispevke',
				'fi' => 'Kirjoita blogi artikkeleita.',
				'el' => 'Δημιουργήστε άρθρα και εγγραφές στο ιστολόγιο σας.',
				'es' => 'Escribe entradas para los artículos y blog (web log).', #update translation
				'fi' => 'Kirjoita blogi artikkeleita.',
				'fr' => 'Envoyez de nouveaux posts et messages de blog.', #update translation
				'he' => 'ניהול בלוג',
				'id' => 'Post entri blog',
				'it' => 'Pubblica notizie e post per il blog.', #update translation
				'lt' => 'Rašykite naujienas bei blog\'o įrašus.',
				'nl' => 'Post nieuwsartikelen en blogs op uw site.',
				'pl' => 'Dodawaj nowe wpisy na blogu',
				'ru' => 'Управление записями блога.',
				'sl' => 'Objavite blog prispevke',
				'zh' => '發表新聞訊息、部落格等文章。',
				'th' => 'โพสต์รายการบล็อก',
	            'hu' => 'Blog bejegyzések létrehozása.',
	            'se' => 'Inlägg i bloggen.',
			),
			'frontend'	=> true,
			'backend'	=> true,
			'skip_xss'	=> true,
			'menu'		=> 'content',

			'roles' => array(
				'put_live', 'edit_live', 'delete_live'
			),

			'sections' => array(
			    'posts' => array(
				    'name' => 'blog:posts_title',
				    'uri' => 'admin/blog',
				    'shortcuts' => array(
						array(
					 	   'name' => 'blog:create_title',
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
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false, 'unique' => true, 'key' => true),
				'title' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false, 'unique' => true),
			),
			'blog' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
				'title' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false, 'unique' => true),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false),
				'category_id' => array('type' => 'INT', 'constraint' => 11, 'key' => true),
				'attachment' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
				'intro' => array('type' => 'TEXT'),
				'body' => array('type' => 'TEXT'),
				'parsed' => array('type' => 'TEXT'),
				'keywords' => array('type' => 'VARCHAR', 'constraint' => 32, 'default' => ''),
				'author_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
				'created_on' => array('type' => 'INT', 'constraint' => 11),
				'updated_on' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
				'comments_enabled' => array('type' => 'INT', 'constraint' => 1, 'default' => 1),
				'status' => array('type' => 'ENUM', 'constraint' => array('draft', 'live'), 'default' => 'draft'),
				'type' => array('type' => 'SET', 'constraint' => array('html', 'markdown', 'wysiwyg-advanced', 'wysiwyg-simple')),
                'preview_hash' => array('type' => 'CHAR', 'constraint' => 32,'default'=>''),
			),
		);

		return $this->install_tables($tables);
	}

	public function uninstall()
	{
		// This is a core module, lets keep it around.
		return false;
	}

	public function upgrade($old_version)
	{
		return true;
	}
}
