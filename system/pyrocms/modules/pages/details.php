<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Pages extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Pages',
				'nl' => 'Pagina&apos;s',
				'es' => 'Páginas',
				'fr' => 'Pages',
				'de' => 'Seiten',
				'pl' => 'Strony',
				'br' => 'Páginas',
				'zh' => '頁面',
				'it' => 'Pagine',
				'ru' => 'Страницы',
				'ar' => 'الصفحات'
			),
			'description' => array(
				'en' => 'Add custom pages to the site with any content you want.',
				'nl' => "Voeg aangepaste pagina&apos;s met willekeurige inhoud aan de site toe.",
				'pl' => 'Dodaj własne strony z dowolną treścią do witryny.',
				'es' => 'Agrega páginas customizadas al sitio con cualquier contenido que tu quieras.',
				'fr' => "Permet d'ajouter sur le site des pages personalisées avec le contenu que vous souhaitez.",
				'de' => 'Füge eigene Seiten mit anpassbaren Inhalt hinzu.',
				'br' => 'Adicionar páginas personalizadas ao site com qualquer conteúdo que você queira.',
				'zh' => '為您的網站新增自定的頁面。',
				'it' => 'Aggiungi pagine personalizzate al sito con qualsiesi contenuto tu voglia.',
				'ru' => 'Управление информационными страницами сайта, с произвольным содержимым.',
				'ar' => 'إضافة صفحات مُخصّصة إلى الموقع تحتوي أية مُحتوى تريده.'
			),
			'frontend' => TRUE,
			'backend'  => TRUE,
			'menu'	  => 'content'
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('page_layouts');
		$this->dbforge->drop_table('pages');
		$this->dbforge->drop_table('pages_lookup');
		$this->dbforge->drop_table('revisions');

		$page_layouts = "
			CREATE TABLE `page_layouts` (
			`id` INT( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`title` VARCHAR( 60 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`body` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
			`css` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
			`theme_layout` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
			`updated_on` INT( 11 ) NOT NULL
			) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Store shared page layouts & CSS';
		";

		$pages = "
			CREATE TABLE `pages` (
			 `id` int(11) unsigned NOT NULL auto_increment,
			 `slug` varchar(255) collate utf8_unicode_ci NOT NULL default '',
			 `title` varchar(255) collate utf8_unicode_ci NOT NULL default '',
			 `parent_id` int(11) default '0',
			 `revision_id` varchar(255) collate utf8_unicode_ci NOT NULL default '1',
			 `layout_id` varchar(255) collate utf8_unicode_ci NOT NULL,
			 `css` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
			 `js` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
			 `meta_title` varchar(255) collate utf8_unicode_ci NOT NULL default '',
			 `meta_keywords` varchar(255) collate utf8_unicode_ci NOT NULL default '',
			 `meta_description` text collate utf8_unicode_ci,
			 `rss_enabled` INT(1)  NOT NULL default '0',
			 `comments_enabled` INT(1)  NOT NULL default '0',
			 `status` ENUM( 'draft', 'live' ) collate utf8_unicode_ci NOT NULL DEFAULT 'draft',
			 `created_on` INT(11) NOT NULL default '0',
			 `updated_on` INT(11) NOT NULL default '0',
			 PRIMARY KEY  (`id`),
			 UNIQUE KEY `Unique` (`slug`,`parent_id`),
			 KEY `slug` (`slug`),
			 KEY `parent` (`parent_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User Editable Pages';
		";

		$pages_lookup = "
			CREATE TABLE `pages_lookup` (
			  `id` int(11) NOT NULL,
			  `path` text character set utf8 collate utf8_unicode_ci NOT NULL,
			  PRIMARY KEY  (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Lookup table for page IDs and page paths.';
		";

		$revisions = "
			CREATE TABLE `revisions` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `owner_id` int(11) NOT NULL,
			  `table_name` varchar(100)  COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pages',
			  `body` text COLLATE utf8_unicode_ci,
			  `revision_date` int(11) NOT NULL,
			  `author_id` int(11) NOT NULL default 0,
			  PRIMARY KEY (`id`),
			  KEY `Owner ID` (`owner_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;
		";

		$default_page_layouts = "
			INSERT INTO `page_layouts` (`id`, `title`, `body`, `css`, `updated_on`) VALUES
			(1, 'Default', '<h2>{pyro:page:title}</h2>\n\n\n{pyro:page:body}', '', ".time().");
		";

		$default_pages = "
			INSERT INTO `pages` (`id`, `slug`, `title`, `revision_id`, `parent_id`, `layout_id`, `status`, `created_on`, `updated_on`) VALUES
			('1','home', 'Home', 1, 0, 1, 'live', ".time().", ".time()."),
			('2', '404', 'Page missing', 1, 0, '1', 'live', ".time().", ".time().");
		";

		$default_revisions = "
			INSERT INTO `revisions` (`id`, `owner_id`, `body`, `revision_date`) VALUES
			  ('1', '1', 'Welcome to our homepage. We have not quite finished setting up our website yet, but please add us to your bookmarks and come back soon.', ".time()."),
			  ('2', '2', '<p>We cannot find the page you are looking for, please click <a title=\"Home\" href=\"{page_url(1)}\">here</a> to go to the homepage.</p>', ".time().");
		";

		if($this->db->query($page_layouts) &&
		   $this->db->query($pages) &&
		   $this->db->query($pages_lookup) &&
		   $this->db->query($revisions) &&
		   $this->db->query($default_page_layouts) &&
		   $this->db->query($default_pages) &&
		   $this->db->query($default_revisions))
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
		// Return a string containing help info
		// You could include a file and return it here.
		return "<h4>Overview</h4>
		<p>The pages module is a simple but powerful way to manage static content on your site.
		Page layouts can be managed and widgets embedded without ever editing the template files.</p>
		<h4>Managing Pages</h4><hr>
		<h6>Page Content</h6>
		<p>When choosing your page title remember that the default page layout will display the page title
		above the page content. Now create your page content
		using the WYSIWYG editor. When you are ready for the page to be visible to visitors set the
		status to Live and it will be accessible at the URL shown. <strong>You must also go to Design -> Navigation and create a new
		navigation link if you want your page to show up in the menu.</strong></p>
		<h6>Meta data</h6>
		<p>The meta title is generally used as the title in search results and is believed to carry significant weight in page rank.<br />
		Meta keywords are words that describe your site content and are for the benefit of search engines only.<br />
		The meta description is a short description of this page and may be used as the search snippet if the search engine deems it relevant to the search.</p>
		<h6>Design</h6>
		<p>The design tab allows you to select a custom page layout and optionally apply different css styles to it on this page only. Refer to the Page Layouts
		section below for instructions on how to best use Page Layouts.</p>
		<h6>Script</h6>
		<p>You may place javascript here that you would like appended to the < head > of the page.</p>
		<h6>Options</h6>
		<p>Allows you to turn on comments and an rss feed for this page. If the rss feed is enabled a visitor can subscribe to this page and they
		will receive each child page in their rss reader.</p>
		<h6>Revisions</h6>
		<p>Revisions is a very powerful and handy feature for editing an existing page. Let's say a new employee really messes up a page edit. Just select a date that you would
		like to revert the page to and click Save! You can even compare revisions to see what has changed.</p>
		<h4>Page Layouts</h4><hr>
		<p>Page layouts allows you to control the layout of the page without modifying the theme files. You can embed tags into the page layout
		instead of placing them in every page. For example: If you have a twitter feed widget that you want to display at the bottom of every page you can just place
		the widget tag in the page layout:
<pre><code>
{pyro:page:title}
{pyro:page:body}

< div class=\"my-twitter-widget\" >
	{pyro:widgets:instance id=\"1\"}
< /div >
</code></pre>
		Now you can apply css styling to the \"my-twitter-widget\" class in the CSS tab.</p>";
	}
}
/* End of file details.php */
