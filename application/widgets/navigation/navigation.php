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
class Navigation extends Widgets {
	
	
	// Run function
	function run()
	{
		$this->CI->load->module_model('navigation','navigation_m');
		print_r($this->CI->navigation_m->getLinks(array('group' => 2)));
	}
	
	
	// Install function (executed when the user installs the widget)
	function install() 
	{
		$name = 'navigation';
		$body = '';
		$this->install_widget($name,$body);
	}
	
	
	// Uninstall function (executed when the user uninstalls the widget)
	function uninstall()
	{
		$name = 'navigation';
		$this->uninstall_widget($name);
	}
}
?>
