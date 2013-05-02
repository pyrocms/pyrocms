<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration 127: Alter settings options
 *
 * This will allow us to set use larger option strings
 * 
 * Added April 30th, 2013
 */

class Migration_Alter_settings_options extends CI_Migration {

  public function up()
  {
   	 $this->dbforge->modify_column('settings', array(
	      'options' => array(
	        'type'  => 'TEXT'
	      )
	    ));
  }

  public function down()
  {
    $this->dbforge->modify_column('settings', array(
      'options' => array(
        'type' => 'varchar',
        'constraint' => 255
      )
    ));
  }
}
