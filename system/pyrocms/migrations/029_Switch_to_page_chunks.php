<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Switch_to_page_chunks extends Migration {

	public function up()
	{
		$this->dbforge->drop_table('page_chunks');

		$page_chunks = "
			CREATE TABLE " . $this->db->dbprefix('page_chunks') . " (
			  `id` int(11) NOT NULL auto_increment,
			  `slug` varchar(30) collate utf8_unicode_ci NOT NULL,
			  `page_id` int(11) NOT NULL,
			  `body` text collate utf8_unicode_ci NOT NULL,
			  `type` set('html','wysiwyg-advanced','wysiwyg-simple') collate utf8_unicode_ci NOT NULL,
			  `sort` int(11) NOT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `unique - slug` (`slug`, `page_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";
		
		$import_chunks = "
			INSERT INTO " . $this->db->dbprefix('page_chunks') . " (
			  `slug` ,
			  `page_id` ,
			  `body` ,
			  `type` ,
			  `sort`
			)
			SELECT 'default', owner_id, body, 'wysiwyg-advanced', 0 FROM `" . $this->db->dbprefix('revisions') . "` t1 WHERE revision_date = (
				SELECT MAX(t2.revision_date) FROM `" . $this->db->dbprefix('revisions') . "` t2 WHERE t1.owner_id = t2.owner_id
			) ORDER BY owner_id
		";
		
		if ($this->db->query($page_chunks) &&
			$this->db->query($import_chunks))
		{
			$this->dbforge->drop_table('revisions');
		}
	}

	public function down()
	{
		if ($this->db->table_exists('revisions'))
		{
			$revisions = "
				CREATE TABLE " . $this->db->dbprefix('revisions') . " (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `owner_id` int(11) NOT NULL,
				  `table_name` varchar(100)  COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pages',
				  `body` text COLLATE utf8_unicode_ci,
				  `revision_date` int(11) NOT NULL,
				  `author_id` int(11) NOT NULL default 0,
				  PRIMARY KEY (`id`),
				  KEY `Owner ID` (`owner_id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;
			";
			
			$revert_chunks = "
				INSERT INTO " . $this->db->dbprefix('revisions') . " (
				  `id`,
				  `owner_id` ,
				  `table_name` ,
				  `body` ,
				  `revision_date` ,
				  `author_id`
				)
				SELECT id, page_id, 'pages', body, " . now() . ", 1 FROM `" . $this->db->dbprefix('page_chunks') . "`
			";
		
			if ($this->db->query($revisions) &&
				$this->db->query($revert_chunks))
			{
				$this->dbforge->drop_table($this->db->dbprefix('page_chunks'));
			}
		}
	}

}