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
			'frontend' => false,
			'backend' => false,
			'menu' => false,
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('search_index');

		$this->db->query("
		CREATE TABLE ".$this->db->dbprefix('search_index')." (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `title` char(255) COLLATE utf8_unicode_ci NOT NULL,
		  `description` text COLLATE utf8_unicode_ci,
		  `keywords` text COLLATE utf8_unicode_ci,
		  `keyword_hash` char(32) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `module` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `entry_key` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `entry_plural` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `entry_id` varchar(255) DEFAULT NULL,
		  `uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `cp_edit_uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `cp_delete_uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `unique` (`module`,`entry_key`,`entry_id`(190)),
		  FULLTEXT KEY `full search` (`title`,`description`,`keywords`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");

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
