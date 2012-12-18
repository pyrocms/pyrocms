<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Blog module
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Blog
 */
class Module_Blog extends Module
{
	public $version = '2.0.0';

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
				'tw' => '文章',
				'cn' => '文章',
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
				'fr' => 'Envoyez de nouveaux posts et messages de blog.', #update translation
				'he' => 'ניהול בלוג',
				'id' => 'Post entri blog',
				'it' => 'Pubblica notizie e post per il blog.', #update translation
				'lt' => 'Rašykite naujienas bei blog\'o įrašus.',
				'nl' => 'Post nieuwsartikelen en blogs op uw site.',
				'pl' => 'Dodawaj nowe wpisy na blogu',
				'ru' => 'Управление записями блога.',
				'tw' => '發表新聞訊息、部落格等文章。',
				'cn' => '发表新闻讯息、部落格等文章。',
				'th' => 'โพสต์รายการบล็อก',
				'hu' => 'Blog bejegyzések létrehozása.',
				'se' => 'Inlägg i bloggen.',
			),
			'frontend' => true,
			'backend' => true,
			'skip_xss' => true,
			'menu' => 'content',

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
							'class' => 'add',
						),
					),
				),
				'categories' => array(
					'name' => 'cat:list_title',
					'uri' => 'admin/blog/categories',
					'shortcuts' => array(
						array(
							'name' => 'cat:create_title',
							'uri' => 'admin/blog/categories/create',
							'class' => 'add',
						),
					),
				),
			),
		);
	}

	public function install()
	{
		$schema = $this->pdb->getSchemaBuilder();

		$schema->dropIfExists('blog');
		$schema->dropIfExists('blog_categories');

		$schema->create('blog', function($table) { 
			$table->increments('id');
			$table->string('slug', 200)->unique();
			$table->string('title', 200)->unique();
			$table->integer('category_id');
			$table->string('attachment', 255)->default('');
			$table->text('intro');
			$table->text('body');
			$table->text('parsed');
			$table->string('keywords', 32)->default('');
			$table->string('author_id', 11)->nullable();
			$table->string('comments_enabled', 1)->default(1);
			$table->enum('status', array('draft', 'live'))->default('draft');
			$table->enum('type', array('html', 'markdown', 'wysiwyg-advanced', 'wysiwyg-simple'));
	        $table->string('preview_hash', 32)->nullable();
			$table->string('created_on', 11);
			$table->string('updated_on', 11)->nullable();

			$table->index('slug');
			$table->index('category_id');
		});

		$schema->create('blog_categories', function($table) { 
			$table->increments('id');
			$table->string('slug', 100)->nullable()->unique();
			$table->string('title', 100)->nullable()->unique();
		});

		return true;
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
