<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Rename_news_to_blog extends Migration {

	function up()
	{
		$this->dbforge->rename_table('news', 'blog');
		$this->dbforge->rename_table('news_categories', 'blog_categories');

		$this->db->query("DELETE FROM modules WHERE slug = 'blog'");
		$this->db->query("UPDATE modules SET `name` = 'a:1:{s:2:\"en\";s:4:\"Blog\";}', slug = 'blog', `version` = 1.1 WHERE slug = 'news' ");

		$this->db->query("UPDATE navigation_links SET module_name = 'blog' WHERE module_name = 'news' ");
		
		//rename the widgets
		$this->db->where('slug', 'news_categories')
				 ->update('widgets', array('slug' => 'blog_categories',
										   'description' => 'Show a list of blog categories.'));
				 
		$this->db->where('slug', 'latest_news')
				 ->update('widgets', array('slug' => 'latest_articles',
										   'description' => 'Display latest blog articles with a widget.'));

		$this->cache->delete_all('modules_m');
		$this->cache->delete_all('navigation_m');
	}

	function down()
	{
		$this->dbforge->rename_table('blog', 'news');
		$this->dbforge->rename_table('blog_categories', 'news_categories');

		$this->db->query("DELETE FROM modules WHERE slug = 'news'");
		$this->db->query("UPDATE modules SET `name` = 'a:1:{s:2:\"en\";s:4:\"News\";}', slug = 'news', `version` = 1.0 WHERE slug = 'blog' ");
		
		$this->db->query("UPDATE navigation_links SET module_name = 'news' WHERE module_name = 'blog' ");
		
		//rename the widgets
		$this->db->where('slug', 'blog_categories')
				 ->update('widgets', array('slug' => 'news_categories',
										   'description' => 'Show a list of news categories.'));
				 
		$this->db->where('slug', 'latest_articles')
				 ->update('widgets', array('slug' => 'latest_news',
										   'description' => 'Display latest news articles with a widget.'));

		$this->cache->delete_all('modules_m');
		$this->cache->delete_all('navigation_m');
	}
}