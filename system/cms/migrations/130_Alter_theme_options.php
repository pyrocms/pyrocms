<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration 130: Alter theme options
 *
 * This allows us to use larger strings for theme options
 * and adds support for WYSIWYG fields for theme options.
 */

class Migration_Alter_theme_options extends CI_Migration {

  public function up()
  {
     $this->dbforge->modify_column('theme_options', array(
        'default' => array('type'  => 'TEXT'),
        'value' => array('type'  => 'TEXT'),
        'type' => array('type' => "SET('text','textarea','password','select','select-multiple','radio','checkbox','colour-picker','wysiwyg')", 'null' => false)
      ));
  }

  public function down()
  {
    $this->dbforge->modify_column('theme_options', array(
      'default' => array('type' => 'varchar', 'constraint' => 255),
      'value' => array('type' => 'varchar', 'constraint' => 255),
      'type' => array('type' => "SET('text','textarea','password','select','select-multiple','radio','checkbox','colour-picker')", 'null' => false)
    ));
  }
}
