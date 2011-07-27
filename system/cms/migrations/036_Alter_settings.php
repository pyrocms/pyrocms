<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_settings extends Migration {

  function up()
  {
		$this->migrations->verbose AND print "Alter Settings - Changing varchar to text";

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
