<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_settings extends CI_Migration {

  function up()
  {
   	 $this->dbforge->modify_column('settings', array(
	      'default' => array(
	        'type'  => 'TEXT',
	        'null'  => FALSE
	      )
	    ));
	    $this->dbforge->modify_column('settings', array(
	      'value' => array(
	        'type'  => 'TEXT',
	        'null'  => FALSE
	      )
		));
  }

  function down()
  {
    $this->dbforge->modify_column('settings', array(
      'default' => array(
        'type' => 'varchar',
        'constraint' => 255,
        'null'  => FALSE
      )
    ));
    $this->dbforge->modify_column('settings', array(
      'value' => array(
        'type' => 'varchar',
        'constraint' => 255,
        'null'  => FALSE
      )
    ));
  }
}
