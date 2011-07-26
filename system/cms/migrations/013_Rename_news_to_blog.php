<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Rename_news_to_blog extends Migration {

	function up()
	{
		if ($this->db->table_exists('news'))
		{
			$this->dbforge->rename_table('news', 'blog');
			$this->dbforge->rename_table('news_categories', 'blog_categories');

			$this->db->query("ALTER TABLE `blog` COMMENT ='Blog posts.';");
			$this->db->query("ALTER TABLE `blog_categories` COMMENT = 'Blog categories.'");
		}

		$this->db->query("DELETE FROM modules WHERE slug = 'blog'");

		$this->db->where('slug', 'news')->update('modules', array('slug' => 'blog'));
		$this->db->where('slug', 'latest_news')->update('widgets', array('slug' => 'latest_posts'));
		$this->db->where('slug', 'news_categories')->update('widgets', array('slug' => 'blog_categories'));

		$this->load->library('widgets/widgets');
		$this->widgets->reload_widget(array('latest_posts', 'blog_categories'));

		reload_module_details('blog');

		$this->db->query("UPDATE navigation_links SET module_name = 'blog' WHERE module_name = 'news' ");

		$this->pyrocache->delete_all('modules_m');
		$this->pyrocache->delete_all('navigation_m');
	}

	function down()
	{
		$this->dbforge->rename_table('blog', 'news');
		$this->dbforge->rename_table('blog_categories', 'news_categories');

		$this->db->query("ALTER TABLE `blog` COMMENT ='News articles.';");
		$this->db->query("ALTER TABLE `blog_categories` COMMENT = 'News categories.'");

		$this->db->query("DELETE FROM modules WHERE slug = 'news'");

		$this->db->where('slug', 'blog')->update('modules', array('slug' => 'news'));
		$this->db->where('slug', 'latest_posts')->update('widgets', array('slug' => 'latest_news'));
		$this->db->where('slug', 'blog_categories')->update('widgets', array('slug' => 'news_categories'));

		reload_module_details('news');

		$this->db->query("UPDATE navigation_links SET module_name = 'news' WHERE module_name = 'blog' ");
		
		//rename the widgets
		$this->db->where('slug', 'blog_categories')
				 ->update('widgets', array('slug' => 'news_categories',
										   'description' => 'Show a list of news categories.'));
				 
		$this->db->where('slug', 'latest_articles')
				 ->update('widgets', array('slug' => 'latest_news',
										   'description' => 'Display latest news articles with a widget.'));

		$this->pyrocache->delete_all('modules_m');
		$this->pyrocache->delete_all('navigation_m');
	}
}