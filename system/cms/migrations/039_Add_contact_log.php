<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_contact_log extends Migration {

	public function up()
	{
		$contact_log = "
			CREATE TABLE ".$this->db->dbprefix('contact_log')." (
			  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
			  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
			  `subject` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
		 	  `message` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
			  `company_name` VARCHAR( 255 ) NOT NULL,
			  `sender_agent` varchar(100)  DEFAULT NULL,
			  `sender_ip` varchar(20),
			  `sender_os` varchar(100)  NOT NULL,
			  `sent_at` int(13) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8
		";
		
		$this->db->where('slug', 'contact');
		$this->db->update('modules', array(
			'version' => 0.9,
			'is_frontend' => 0,
			'is_backend' => 1,
		));

		if ($this->db->query($contact_log))
		{
			return TRUE;
		}
	}

	public function down()
	{
		$this->dbforge->drop_table('contact_log');
		
		$this->db->where('slug', 'contact');
		$this->db->update('modules', array(
			'version' => 0.6,
			'is_frontend' => 1,
			'is_backend' => 0,
		));
	}
}
