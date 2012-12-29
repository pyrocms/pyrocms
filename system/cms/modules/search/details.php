<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Search module
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Search
 */
class Module_Search extends Module
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
			),
			'description' => array(
				'en' => 'Search through various types of content with this modular search system.',
				'fr' => 'Rechercher parmi différents types de contenus avec système de recherche modulaire.',
				'se' => 'Sök igenom olika typer av innehåll',
				'ar' => 'ابحث في أنواع مختلفة من المحتوى باستخدام نظام البحث هذا.',
				'tw' => '此模組可用以搜尋網站中不同類型的資料內容。',
				'cn' => '此模组可用以搜寻网站中不同类型的资料内容。',
			),
			'frontend' => false,
			'backend' => true,
			'menu' => false,
		);
	}

    public function install()
    {
        $schema = $this->pdb->getSchemaBuilder();
        $schema->dropIfExists('search_index');

        $schema->create('search_index', function($table) {
            $table->increments('id');
            $table->string('title', 255)->fulltext();
            $table->text('description')->fulltext();
            $table->text('keywords')->fulltext();
            $table->text('keywords_hash');
            $table->string('module', 40);
            $table->string('entry_key', 100);
            $table->string('entry_plural', 100);
            $table->string('entry_id', 255);
            $table->string('uri', 255);
            $table->string('cp_edit_uri', 255);
            $table->string('cp_delete_uri', 255);

			//   FULLTEXT KEY `full search` (`title`,`description`,`keywords`)
			
            $table->unique(array('module', 'entry_key', 'entry_id'));
        });


		$this->load->model('search/search_index_m');
		$this->load->library('keywords/keywords');

		foreach ($this->db->get('pages')->result() as $page)
		{
			// Only index live articles
	    	if ($page->status === 'live')
	    	{
	    		$hash = $this->keywords->process($page->meta_keywords);

	    		$this->db
	    			->set('meta_keywords', $hash)
	    			->where('id', $page->id)
	    			->update('pages');

	    		$this->search_index_m->index(
	    			'pages',
	    			'pages:page', 
	    			'pages:pages', 
	    			$page->id,
	    			$page->uri,
	    			$page->title,
	    			$page->meta_description ? $page->meta_description : null, 
	    			array(
	    				'cp_edit_uri' 	=> 'admin/pages/edit/'.$page->id,
	    				'cp_delete_uri' => 'admin/pages/delete/'.$page->id,
	    				'keywords' 		=> $hash,
	    			)
	    		);
	    	}
		}

		return true;
	}

	public function admin_menu()
	{
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
