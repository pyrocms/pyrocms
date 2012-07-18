<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Comment_parsed_default extends CI_Migration {

	public function up()
	{
		$this->db->query('ALTER TABLE '.$this->db->dbprefix('comments').' CHANGE `parsed` `parsed` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci');
	}

	public function down()
	{
	}
}