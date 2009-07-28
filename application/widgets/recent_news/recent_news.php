<?php
/*
 * @name 	Recent News Widget
 * @author 	Yorick Peterse
 * @link	http://www.yorickpeterse.com/
 * @package PyroCMS
 * @license MIT License
 * 
 * This widget displays a list of recent articles
 */
class Recent_news extends Widgets {
	
	
	// Run function
	function run()
	{
		// First retrieve all the settings for the Recent News widget
		$data['title'] 		= $this->get_data('recent_news','title');
		$data['limit'] 		= $this->get_data('recent_news','article_limit');
		$data['display'] 	= $this->get_data('recent_news','display');
		$data['intro'] 		= $this->get_data('recent_news','show_intro');
		
		// Load the view file, based on the display type (all, category or archive)
		switch($data['display'])
		{
			// Show all articles, regardless of archive or category
			case "all":
				$this->display('recent_news','news_all',$data); 
			break;
			// Show only a list of articles for a specified category
			case "category":
				// Get the category and load the view file 
				$data['category'] = $this->get_data('recent_news','category');
				$this->display('recent_news','news_category',$data); 
			break;
			// Show only a list of articles for a specified year (e.g. 2008)
			case "archive_year":
				// Get the arhive year (e.g. 2008)
				$data['year']  = $this->get_data('recent_news','archive_year');
				$this->display('recent_news','news_archive_year',$data); 
			break;
			// Show articles for a single month
			case "archive_month":
				$data['month'] = $this->get_data('recent_news','archive_month');
				$this->display('recent_news','news_archive_month',$data);
			break;
		}		
	}
	
	
	// Install function (executed when the user installs the widget)
	function install() 
	{
		$name = 'recent_news';
		$body = '{"title":"Recent News","article_limit":"2","show_intro":"false"}';
		$this->install_widget($name,$body);
	}
	
	
	// Uninstall function (executed when the user uninstalls the widget)
	function uninstall()
	{
		$name = 'recent_news';
		$this->uninstall_widget($name);
	}
}
?>
