<?php

use Pyro\Module\Addons\AbstractModule;
use Pyro\Module\Search\Model\Search;

/**
 * Search module
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Search
 */
class Module_Search extends AbstractModule
{
    public $version = '1.0.0';

    public $_tables = array('search_index');

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Search',
				'fr' => 'Recherche',
				'se' => 'Sök',
				'ar' => 'البحث',
				'tw' => '搜尋',
				'cn' => '搜寻',
				'it' => 'Ricerca',
				'fa' => 'جستجو',
				'fi' => 'Etsi',
			),
			'description' => array(
				'en' => 'Search through various types of content with this modular search system.',
				'fr' => 'Rechercher parmi différents types de contenus avec système de recherche modulaire.',
				'se' => 'Sök igenom olika typer av innehåll',
				'ar' => 'ابحث في أنواع مختلفة من المحتوى باستخدام نظام البحث هذا.',
				'tw' => '此模組可用以搜尋網站中不同類型的資料內容。',
				'cn' => '此模组可用以搜寻网站中不同类型的资料内容。',
				'it' => 'Cerca tra diversi tipi di contenuti con il sistema di reicerca modulare',
				'fa' => 'توسط این ماژول می توانید در محتواهای مختلف وبسایت جستجو نمایید.',
				'fi' => 'Etsi eri tyypistä sisältöä tällä modulaarisella hakujärjestelmällä.',
			),
		);
	}

    public function install($pdb, $schema)
    {
        $schema->dropIfExists('search_index');

        $schema->create('search_index', function($table) {
            $table->increments('id');
            $table->string('title', 255)->fulltext();
            $table->text('description')->fulltext();
            $table->text('keywords')->fulltext();
            $table->text('keywords_hash');
            $table->string('module', 40);
            $table->string('scope', 100);
            $table->string('entry_singular', 100);
            $table->string('entry_plural', 100);
            $table->string('entry_id', 193);
            $table->string('uri', 255);
            $table->string('cp_uri', 255);
            $table->text('group_access')->nullable();
            $table->text('user_access')->nullable();

			//   FULLTEXT KEY `full search` (`title`,`description`,`keywords`)

            $table->unique(array('module', 'scope', 'entry_id'));
        });

		ci()->load->library('keywords/keywords');

		foreach (ci()->pdb->table('pages')->get() as $page) {
			// Only index live articles
	    	if ($page->status === 'live') {
	    		$hash = ci()->keywords->process($page->meta_keywords);

	    		$pdb
	    			->table('pages')
	    			->where('id', $page->id)
	    			->update(array('meta_keywords' => $hash));

	    		Search::index(
	    			$module = 'pages',
	    			$scope = 'def_page_fields.pages',
	    			$singular = 'pages:page',
	    			$plural = 'pages:pages',
	    			$entry_id = $page->id,
	    			$title = $page->title,
	    			$description = $page->meta_description,
	    			$keywords = $page->meta_keywords,
	    			$uri = $page->uri,
	    			$cp_uri = 'admin/pages/edit/'.$page->id,
	    			$group_access = null,
	    			$user_access = null
	    			);
	    	}
		}

		return true;
	}

	public function admin_menu()
	{
        return true;
    }

    public function uninstall($pdb, $schema)
    {
        // This is a core module, lets keep it around.
        return false;
    }

    public function upgrade($old_version)
    {
        return true;
    }
}
