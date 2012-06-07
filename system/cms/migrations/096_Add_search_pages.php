<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration to add search pages and their chunks.
 */
class Migration_Add_search_pages extends CI_Migration
{
	public function up()
	{
		$this->db->insert('modules', array(
			'name' => serialize(array(
				'en' => 'Search',
			)),
			'slug' => 'search',
			'version' => '1.0.0',
			'description' => serialize(array(
				'en' => 'Search through various types of content with this modular search system.',
			)),
			'skip_xss' => false,
			'is_frontend' => false,
			'is_backend' => true,
			'menu' => 'content',
			'enabled' => true,
			'installed' => true,
			'is_core' => true,
			'updated_on' => time()
		));

 		$this->dbforge->modify_column('pages', array(
       		'js' => array('type' => 'TEXT', 'null' => true),
			'meta_title' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'meta_keywords' => array('type' => 'CHAR', 'constraint' => 32, 'null' => true),
			'meta_description' => array('type' => 'TEXT', 'null' => true),        ));

        $this->dbforge->modify_column('page_chunks', array(
			'parsed' => array('type' => 'TEXT', 'null' => true),
        ));

		$this->db->insert('pages', array(
			'slug' => 'search',
			'title' => 'Search',
			'uri' => 'search',
			'revision_id' => 1,
			'layout_id' => 1,
			'status' => 'live',
			'created_on' => time(),
			'strict_uri' => true,
			'order' => time(),
		));

		$search_id = $this->db->insert_id();

		$this->db->insert('pages', array(
			'slug' => 'results',
			'title' => 'Results',
			'uri' => 'search/results',
			'parent_id' => $search_id,
			'revision_id' => 1,
			'layout_id' => 1,
			'status' => 'live',
			'created_on' => time(),
			'strict_uri' => true,
			'order' => time(),
		));

		$results_id = $this->db->insert_id();

		$this->db->insert('page_chunks', array(
			'slug' => 'default',
			'page_id' => $search_id,
			'body' => "{{ search:form class=\"search-form\" }} \n		<input name=\"q\" placeholder=\"Search terms...\" />\n	{{ /search:form }}",
			'type' => 'html',
			'sort' => 1,
			'class' => 'search',
		));

		$this->db->insert('page_chunks', array(
			'slug' => 'default',
			'page_id' => $results_id,
			'body' => "{{ search:results }}\n\n	{{ total }} results for \"{{ query }}\".\n\n	<hr />\n\n	{{ entries }}\n\n		<article>\n			<h4>{{ singular }}: <a href=\"{{ url }}\">{{ title }}</a></h4>\n			<p>{{ description }}</p>\n		</article>\n\n	{{ /entries }}\n\n        {{ pagination }}\n\n{{ /search:results }}",
			'type' => 'html',
			'sort' => 1,
			'class' => 'search results',
		));

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
		  `entry_id` int(10) unsigned DEFAULT NULL,
		  `uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `cp_edit_uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `cp_delete_uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `unique` (`module`,`entry_key`,`entry_id`) USING BTREE,
		  FULLTEXT KEY `full search` (`title`,`description`,`keywords`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
	}

	public function down()
	{
		$this->dbforge->drop_table('search_index');

		$this->db->delete('modules', array('slug' => 'search'));
	}
}