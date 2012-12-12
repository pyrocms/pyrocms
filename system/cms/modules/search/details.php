<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Search module
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Search
 */
class Module_Search extends Module
{

	public $version = '1.0';

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
				'cn' => '搜寻'
			),
			'description' => array(
				'en' => 'Search through various types of content with this modular search system.',
				'fr' => 'Rechercher parmi différents types de contenus avec système de recherche modulaire.',
				'se' => 'Sök igenom olika typer av innehåll',
				'ar' => 'ابحث في أنواع مختلفة من المحتوى باستخدام نظام البحث هذا.',
				'tw' => '此模組可用以搜尋網站中不同類型的資料內容。',
				'cn' => '此模组可用以搜寻网站中不同类型的资料内容。'
			),
			'frontend' => false,
			'backend' => false,
			'menu' => 'content',
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
		  UNIQUE KEY `unique` (`module`,`entry_key`,`entry_id`(190)) USING BTREE,
		  FULLTEXT KEY `full search` (`title`,`description`,`keywords`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
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
