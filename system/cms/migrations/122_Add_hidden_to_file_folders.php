<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration 122: Add hidden column to file_folders table
 *
 * This will let devs keep folders hidden from general
 * files module viewing.
 * 
 * Added March 26th, 2013
 */
class Migration_Add_hidden_to_file_folders extends CI_Migration
{
  public function up()
	{
		// Add it..
		if (! $this->db->field_exists('hidden', 'file_folders'))
		{
			$this->dbforge->add_column('file_folders', array(
				'hidden' => array(
					'type' => 'TINYINT',
					'constraint' => 1,
					'default' => 0,
					'null' => false
				)
			));
		}
	}
	
	public function down()
	{
		
	}
}
