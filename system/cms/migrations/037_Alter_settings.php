<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_settings extends CI_Migration {

  public function up()
  {
   	 $this->dbforge->modify_column('settings', array(
	      'default' => array(
	        'type'  => 'TEXT',
	        'null'  => false
	      )
	    ));
	    $this->dbforge->modify_column('settings', array(
	      'value' => array(
	        'type'  => 'TEXT',
	        'null'  => false
	      )
		));
  }

  public function down()
  {
    $this->dbforge->modify_column('settings', array(
      'default' => array(
        'type' => 'varchar',
        'constraint' => 255,
        'null'  => false
      )
    ));
    $this->dbforge->modify_column('settings', array(
      'value' => array(
        'type' => 'varchar',
        'constraint' => 255,
        'null'  => false
      )
    ));
  }
}
