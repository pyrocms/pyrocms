<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Search module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Search
 */
class Module_Search extends Module {

	public $version = '1.0';

	public $_tables = array('search_index');

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Search',
			),
			'description' => array(
				'en' => 'Search through various types of content with this modular search system.',
			),
			'frontend' => false,
			'backend'  => true,
			'menu'     => 'content',
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('search_index', true);

		return $this->install_tables(array(
			'search_index' => array(
				'id' => array('type' => 'INT', 'unsigned' => true, 'auto_increment' => true, 'primary' => true,),
				'title' => array('type' => 'VARCHAR', 'constraint' => 255, 'fulltext' => 'full search'),
				'description' => array('type' => 'text', 'fulltext' => 'full search'),
				'keywords' => array('type' => 'text', 'fulltext' => 'full search'),
				'keyword_hash' => array('type' => 'text'),
				'module' => array('type' => 'varchar', 'constraint' => 40, 'unique' => 'unique'),
				'entry_key' => array('type' => 'varchar', 'constraint' => 100, 'unique' => 'unique'),
				'entry_plural' => array('type' => 'varchar', 'constraint' => 100),
				'entry_id' => array('type' => 'varchar', 'constraint' => 10, 'unique' => 'unique'),
				'uri' => array('type' => 'varchar', 'constraint' => 255),
				'cp_edit_uri' => array('type' => 'varchar', 'constraint' => 255),
				'cp_delete_uri' => array('type' => 'varchar', 'constraint' => 255),
			),
		));

		/*
		TODO Work out how to enable this search stuff for other systems
		  UNIQUE KEY `unique` (`module`,`entry_key`,`entry_id`) USING BTREE,
		  FULLTEXT KEY `full search` (`title`,`description`,`keywords`)
		) ENGINE=MyISAM
		*/
	}

	public function uninstall()
	{
		// This is a core module, lets keep it around.
		return false;
	}

	public function upgrade($old_version)
	{
		return true;
	}

}
