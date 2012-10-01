<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_keywords extends CI_Migration {

	public function up()
	{	
		$this->dbforge->drop_table('keywords, keywords_applied');

		$keywords = "
			CREATE TABLE " . $this->db->dbprefix('keywords') . " (
			  `id` int unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";
		
		$keywords_applied = "
			CREATE TABLE " . $this->db->dbprefix('keywords_applied') . " (
			  `id` int unsigned NOT NULL AUTO_INCREMENT,
			  `hash` char(32) NOT NULL,
			  `keyword_id` int unsigned COLLATE utf8_unicode_ci NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";

		if ($this->db->query($keywords) && $this->db->query($keywords_applied))
		{
			return true;
		}
	}

	public function down()
	{
		$this->dbforge->drop_table('keywords, keywords_applied');
	}
}