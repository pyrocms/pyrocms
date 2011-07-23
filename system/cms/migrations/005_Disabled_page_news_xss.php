<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Disabled_page_news_xss extends Migration {

	function up()
	{
		$this->db
			->where_in('slug', array('news', 'pages'))
			->update('modules', array('skip_xss' => 1));
	}

	function down()
	{
		$this->db
			->where_in('slug', array('news', 'pages'))
			->update('modules', array('skip_xss' => 0));
	}
}