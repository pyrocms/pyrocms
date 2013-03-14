<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration 121: Add IPv6 Support (Again)
 *
 * Basically switches any IP db columns from
 * 16 characters to 45 for IPv6. This was done in 
 * September 120 but looks like the installer was 
 * not updated to match, meaning some 2.2 fresh 
 * installs will not have this change.
 * 
 * Added September 12, 2012
 */
class Migration_Add_ipv_six_support_again extends CI_Migration
{
	public function up()
	{
		// Sessions
		$this->dbforge->modify_column('ci_sessions', array(
			'ip_address' => array(
				'type' => 'VARCHAR',
				'constraint' => 45,
				'null' => false
			)
		));

		// Comments
		$this->dbforge->modify_column('comments', array(
			'ip_address' => array(
				'type' => 'VARCHAR',
				'constraint' => 45,
				'null' => false
			)
		));

		// Contact Log
		$this->dbforge->modify_column('contact_log', array(
			'sender_agent' => array('type' => 'VARCHAR', 'constraint' => 255),
			'sender_ip' => array('type' => 'VARCHAR', 'constraint' => 45),
			'sender_os' => array('type' => 'VARCHAR', 'constraint' => 255),
		));

		// Stream Searches, if we have that table
		if ($this->db->table_exists('data_stream_searches'))
		{
			$this->dbforge->modify_column('data_stream_searches', array(
				'ip_address' => array(
					'type' => 'VARCHAR',
					'constraint' => 45,
					'null' => false
				)
			));
		}

		// Users
		$this->dbforge->modify_column('users', array(
			'ip_address' => array(
				'type' => 'VARCHAR',
				'constraint' => 45,
				'null' => false
			)
		));

		// Now our core users table
		$this->db->set_dbprefix('core_');

		$this->dbforge->modify_column('users', array(
			'ip_address' => array(
				'type' => 'VARCHAR',
				'constraint' => 45,
				'null' => true
			),
		));

		$this->db->set_dbprefix(SITE_REF.'_');
	}
	
	public function down()
	{
		
	}
}