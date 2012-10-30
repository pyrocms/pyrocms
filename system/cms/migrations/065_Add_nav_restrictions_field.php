<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_nav_restrictions_field extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('navigation_links', array(
			'restricted_to' => array(
				'type'			=> 'varchar',
				'constraint'	=> 255,
				'null'			=> true,
				'default'		=> null
			)
		));
	}

	public function down()
	{
		$this->dbforge->drop_column('navigation_links', 'restricted_to');
	}
}