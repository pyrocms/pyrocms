<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Pages Module
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Pages
 */
class Module_Pages extends Module
{
	public $version = '2.2.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Pages',
				'ar' => 'الصفحات',
				'br' => 'Páginas',
				'pt' => 'Páginas',
				'cs' => 'Stránky',
				'da' => 'Sider',
				'de' => 'Seiten',
				'el' => 'Σελίδες',
				'es' => 'Páginas',
				'fi' => 'Sivut',
				'fr' => 'Pages',
				'he' => 'דפים',
				'id' => 'Halaman',
				'it' => 'Pagine',
				'lt' => 'Puslapiai',
				'nl' => 'Pagina&apos;s',
				'pl' => 'Strony',
				'ru' => 'Страницы',
				'sl' => 'Strani',
				'zh' => '頁面',
				'hu' => 'Oldalak',
				'th' => 'หน้าเพจ',
				'se' => 'Sidor',
			),
			'description' => array(
				'en' => 'Add custom pages to the site with any content you want.',
				'ar' => 'إضافة صفحات مُخصّصة إلى الموقع تحتوي أية مُحتوى تريده.',
				'br' => 'Adicionar páginas personalizadas ao site com qualquer conteúdo que você queira.',
				'pt' => 'Adicionar páginas personalizadas ao seu site com qualquer conteúdo que você queira.',
				'cs' => 'Přidávejte vlastní stránky na web s jakýmkoliv obsahem budete chtít.',
				'da' => 'Tilføj brugerdefinerede sider til dit site med det indhold du ønsker.',
				'de' => 'Füge eigene Seiten mit anpassbaren Inhalt hinzu.',
				'el' => 'Προσθέστε και επεξεργαστείτε σελίδες στον ιστότοπό σας με ό,τι περιεχόμενο θέλετε.',
				'es' => 'Agrega páginas customizadas al sitio con cualquier contenido que tu quieras.',
				'fi' => 'Lisää mitä tahansa sisältöä sivustollesi.',
				'fr' => "Permet d'ajouter sur le site des pages personalisées avec le contenu que vous souhaitez.",
				'he' => 'ניהול דפי תוכן האתר',
				'id' => 'Menambahkan halaman ke dalam situs dengan konten apapun yang Anda perlukan.',
				'it' => 'Aggiungi pagine personalizzate al sito con qualsiesi contenuto tu voglia.',
				'lt' => 'Pridėkite nuosavus puslapius betkokio turinio',
				'nl' => "Voeg aangepaste pagina&apos;s met willekeurige inhoud aan de site toe.",
				'pl' => 'Dodaj własne strony z dowolną treścią do witryny.',
				'ru' => 'Управление информационными страницами сайта, с произвольным содержимым.',
				'sl' => 'Dodaj stran s kakršno koli vsebino želite.',
				'zh' => '為您的網站新增自定的頁面。',
				'th' => 'เพิ่มหน้าเว็บที่กำหนดเองไปยังเว็บไซต์ของคุณตามที่ต้องการ',
				'hu' => 'Saját oldalak hozzáadása a weboldalhoz, akármilyen tartalommal.',
				'se' => 'Lägg till egna sidor till webbplatsen.',
			),
			'frontend' => true,
			'backend' => true,
			'skip_xss' => true,
			'menu' => 'content',

			'roles' => array(
				'put_live', 'edit_live', 'delete_live'
			),

			'sections' => array(
				'pages' => array(
					'name' => 'pages:list_title',
					'uri' => 'admin/pages',
					'shortcuts' => array(
						array(
							'name' => 'pages:create_title',
							'uri' => 'admin/pages/create',
							'class' => 'add'
						),
					),
				),
				'layouts' => array(
					'name' => 'pages:layouts_list_title',
					'uri' => 'admin/pages/layouts',
					'shortcuts' => array(
						array(
							'name' => 'pages:layouts_create_title',
							'uri' => 'admin/pages/layouts/create',
							'class' => 'add'
						),
					),
				),
			),
		);
	}

	public function install()
	{
		$schema = $this->pdb->getSchemaBuilder();

		$schema->drop('page_chunks');

		$schema->create('keywords', function (\Illuminate\Database\Schema\Blueprint $table)
		{
			$table->increments('id');
			$table->string('slug');
			$table->string('class')->default('');
			$table->integer('page_id');
			$table->text('body');
			$table->text('parsed')->nullable();
			$table->enum('type', array('html', 'markdown', 'wysiwyg-advanced', 'wysiwyg-simple'));
			$table->integer('sort');

			$table->primary('id');
			// $table->foreign('page_id'); // TODO: Surely more documentation is needed to make this work.
		});

		$schema->drop('page_layouts');

		$schema->create('page_layouts', function (\Illuminate\Database\Schema\Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->text('body');
			$table->text('css')->nullable();
			$table->text('js')->nullable();
			$table->string('theme_layout')->default('default');
			$table->timestamp('updated_on');

			$table->primary('id');
		});

		$schema->drop('pages');

		$schema->create('pages', function (\Illuminate\Database\Schema\Blueprint $table)
		{
			$table->increments('id');
			$table->string('slug')->default('');
			$table->string('class')->default('');
			$table->string('title')->default('');
			$table->text('uri')->nullable();
			$table->integer('parent_id')->default(0);
			$table->string('revision_id')->default('1');
			$table->string('layout_id');
			$table->text('css')->nullable();
			$table->text('js')->nullable();
			$table->string('meta_title')->nullable();
			$table->string('meta_keywords')->nullable();
			$table->string('meta_description')->nullable();
			$table->boolean('rss_enabled')->default(false);
			$table->boolean('comments_enabled')->default(false);
			$table->enum('status', array('draft', 'live'))->default('draft');
			$table->timestamps();
			$table->string('restricted_to')->nullable();
			$table->boolean('is_home');
			$table->boolean('strict_uri')->default(true);
			$table->integer('order')->default(0);

			$table->primary('id');
			$table->index('slug');
			$table->index('parent_id');
		});

		$schema->drop('revisions');


		// We will need to get now() later on.
		$this->load->helper('date');

		$this->pdb->table('page_layouts')->insert(array(
			'id' => 1,
			'title' => 'Default',
			'body' => '<h2>{{ page:title }}</h2>'.PHP_EOL.'{{ page:body }}',
			'css' => '',
			'js' => '',
			'updated_on' => now(),
		));

		$this->pdb->table('pages')->insert(array(
			/* The home page. */
			array(
				'slug' => 'home',
				'title' => 'Home',
				'uri' => 'home',
				'revision_id' => 1,
				'parent_id' => 0,
				'layout_id' => 1,
				'status' => 'live',
				'restricted_to' => '',
				'created_on' => now(),
				'is_home' => 1,
				'order' => now()
			),
			/* The 404 page. */
			array(
				'slug' => '404',
				'title' => 'Page missing',
				'uri' => '404',
				'revision_id' => 1,
				'parent_id' => 0,
				'layout_id' => 1,
				'status' => 'live',
				'restricted_to' => '',
				'created_on' => now(),
				'is_home' => 0,
				'order' => now()
			),
			/* The contact page. */
			array(
				'slug' => 'contact',
				'title' => 'Contact',
				'uri' => 'contact',
				'revision_id' => 1,
				'parent_id' => 0,
				'layout_id' => 1,
				'status' => 'live',
				'restricted_to' => '',
				'created_on' => now(),
				'is_home' => 0,
				'order' => now()
			),
		));

		$this->pdb->table('page_chunks')->insert(array(
			/* The home page chunk. */
			array(
				'slug' => 'default',
				'page_id' => 1,
				'body' => '<p>Welcome to our homepage. We have not quite finished setting up our website yet, but please add us to your bookmarks and come back soon.</p>',
				'parsed' => '',
				'type' => 'wysiwyg-advanced',
				'sort' => 1,
			),
			/* The 404 page chunk. */
			array(
				'slug' => 'default',
				'page_id' => 2,
				'body' => '<p>We cannot find the page you are looking for, please click <a title="Home" href="{{ pages:url id=\'1\' }}">here</a> to go to the homepage.</p>',
				'parsed' => '',
				'type' => 'html',
				'sort' => 1,
			),
			/* The contact page chunk. */
			array(
				'slug' => 'default',
				'page_id' => 3,
				'body' => '<p>To contact us please fill out the form below.</p>
					{{ contact:form name="text|required" email="text|required|valid_email" subject="dropdown|Support|Sales|Feedback|Other" message="textarea" attachment="file|zip" }}
						<div><label for="name">Name:</label>{{ name }}</div>
						<div><label for="email">Email:</label>{{ email }}</div>
						<div><label for="subject">Subject:</label>{{ subject }}</div>
						<div><label for="message">Message:</label>{{ message }}</div>
						<div><label for="attachment">Attach  a zip file:</label>{{ attachment }}</div>
					{{ /contact:form }}',
				'parsed' => '',
				'type' => 'html',
				'sort' => 1,
			),
		));

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