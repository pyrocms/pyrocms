<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_site_active_field extends CI_Migration {

	public function up()
	{
		$this->db->set_dbprefix('core_');
		
		$sites = $this->db->get('sites')->row();
		
		if ( ! isset($sites->active))
		{
		
			$this->dbforge->add_column('sites', array(
				'active' => array(
					'type'			=> 'tinyint',
					'constraint'	=> 1,
					'null'			=> false,
					'default'		=> 1
				)
			));
		
			$this->dbforge->modify_column('settings', array(
				'default' => array(
					'type' => 'text'
				)			
			));
		
			$this->dbforge->modify_column('settings', array(
				'value' => array(
					'type' => 'text'
				)			
			));
		
			$this->db->insert('settings', array('slug' 		=> 'status_message',
												'default' 	=> 'This site has been disabled by a super-administrator.',
												'value' 	=> 'This site has been disabled by a super-administrator.'
												)
							  );
		}

		$this->db->set_dbprefix(SITE_REF.'_');
	}

	public function down()
	{
		$this->db->set_dbprefix('core_');
		
		$this->dbforge->drop_column('sites', 'active');
		
		$this->db->where('slug', 'status_message')
			->delete('settings');
		
		$this->db->set_dbprefix(SITE_REF.'_');
	}
}