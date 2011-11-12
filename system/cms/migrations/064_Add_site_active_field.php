<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_site_active_field extends CI_Migration {

	public function up()
	{
		$this->db->set_dbprefix('core_');
		
		$this->dbforge->add_column('sites', array(
			'active' => array(
				'type'			=> 'tinyint',
				'constraint'	=> 1,
				'null'			=> FALSE,
				'default'		=> 1
			)
		));
		
		$this->db->set_dbprefix(SITE_REF.'_');
	}

	public function down()
	{
		$this->db->set_dbprefix('core_');
		
		$this->dbforge->drop_column('sites', 'active');
		
		$this->db->set_dbprefix(SITE_REF.'_');
	}
}