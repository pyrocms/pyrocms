<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration 131: Add custom to navigation
 *
 * Add the custom column to navigation
 * 
 * Added October 20th, 2015
 */

class Migration_Add_custom_to_navigation extends CI_Migration {

  public function up()
  {
	  $this->dbforge->add_column('navigation_links', array('custom' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => '')));
  }

  public function down()
  {
	  $this->dbforge->drop-column('navigation_links', 'custom');
  }
}
