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
				'en' => 'Maintain a central list of keywords to label and organize your content.',
			),
			'frontend' => false,
			'backend'  => true,
			'menu'     => 'content',
			'shortcuts' => array(
				array(
			 	   'name' => 'keywords:add_title',
				   'uri' => 'admin/keywords/add',
				   'class' => 'add',
				),
			),
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('search_index');

		return true; $this->install_tables(array(
			'keywords' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'name' => array('type' => 'VARCHAR', 'constraint' => 50,),
			),
			'keywords_applied' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'hash' => array('type' => 'CHAR', 'constraint' => 32, 'default' => '',),
				'keyword_id' => array('type' => 'INT', 'constraint' => 11,),
			),
		));
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
