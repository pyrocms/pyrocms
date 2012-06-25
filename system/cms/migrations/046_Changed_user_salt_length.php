<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Changed_user_salt_length extends CI_Migration {

	public function up()
	{
		$this->dbforge->modify_column('users', array(
			'salt' => array(
				'type'			=> 'varchar',
				'constraint'	=> 6,
				'collate'		=> 'utf8_unicode_ci',
				'default'		=> ''
			)
		));
		
		// switch the prefix so we can update core_users
		$this->db->set_dbprefix('core_');
		
		$this->dbforge->modify_column('users', array(
			'salt' => array(
				'type'			=> 'varchar',
				'constraint'	=> 6,
				'collate'		=> 'utf8_unicode_ci',
				'default'		=> ''
			)
		));
		
		// now put it back for following migrations
		$this->db->set_dbprefix(SITE_REF . '_');
	}

	public function down()
	{
		$this->dbforge->modify_column('users', array(
			'salt' => array(
				'type'			=> 'varchar',
				'constraint'	=> 5,
				'collate'		=> 'utf8_unicode_ci',
				'default'		=> ''
			)
		));
		
		$this->db->set_dbprefix('core_');
		
		$this->dbforge->modify_column('users', array(
			'salt' => array(
				'type'			=> 'varchar',
				'constraint'	=> 5,
				'collate'		=> 'utf8_unicode_ci',
				'default'		=> ''
			)
		));
		
		$this->db->set_dbprefix(SITE_REF . '_');
	}
}