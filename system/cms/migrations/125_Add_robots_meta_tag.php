<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration 125: Add robots meta tag
 *
 * This will let allow to set the robots meta tag
 * 
 * Added April 20th, 2013
 */
class Migration_Add_robots_meta_tag extends CI_Migration
{
  public function up()
	{
		// Add meta robots index
		if (! $this->db->field_exists('meta_robots_no_index', 'default_pages'))
		{
			$this->dbforge->add_column('default_pages', array(
				'meta_robots_no_index' => array(
					'type' => 'INT',
					'constraint' => 1,
					'default' => 0,
					'null' => false
				)
			));
		}
		// Add meta robots follow
		if (! $this->db->field_exists('meta_robots_no_follow', 'default_pages'))
		{
			$this->dbforge->add_column('default_pages', array(
				'meta_robots_no_follow' => array(
					'type' => 'INT',
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
