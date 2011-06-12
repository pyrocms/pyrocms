<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_theme_options extends Migration {

	function up()
	{
		$this->dbforge->drop_table('theme_options');

		$theme_options = "
			CREATE TABLE `theme_options` (
			  `slug` varchar(30) collate utf8_unicode_ci NOT NULL,
			  `title` varchar(100) collate utf8_unicode_ci NOT NULL,
			  `description` text collate utf8_unicode_ci NOT NULL,
			  `type` set('text','textarea','password','select','select-multiple','radio','checkbox') collate utf8_unicode_ci NOT NULL,
			  `default` varchar(255) collate utf8_unicode_ci NOT NULL,
			  `value` varchar(255) collate utf8_unicode_ci NOT NULL,
			  `options` varchar(255) collate utf8_unicode_ci NOT NULL,
			  `is_required` tinyint(1) NOT NULL,
			  `theme` varchar(50) collate utf8_unicode_ci NOT NULL,
			PRIMARY KEY  (`slug`),
			UNIQUE KEY `unique - slug` (`slug`),
			KEY `index - slug` (`slug`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Stores theme options.';
		";

		if ($this->db->query($theme_options))
		{
			return TRUE;
		}
	}

	function down()
	{
		$this->dbforge->drop_table('theme_options');
	}
}