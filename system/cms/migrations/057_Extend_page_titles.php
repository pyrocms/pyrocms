<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Extend_page_titles extends CI_Migration {

	public function up()
	{
		$this->db->query('ALTER TABLE '.$this->db->dbprefix('pages').' 
			CHANGE `title` `title` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
			CHANGE `slug` `slug` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci');
	}

	public function down()
	{
	}
}