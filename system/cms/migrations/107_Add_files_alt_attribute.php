<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Migration_Add_files_alt_attribute extends CI_Migration {

    public function up()
    {
        if ( ! $this->db->field_exists('alt_attribute', 'files'))
        {
            $this->dbforge->add_column('files', array(
                'alt_attribute' => array(
    				'type' => 'VARCHAR',
    				'constraint' => 255,
    				'null' => true
    			)
            ));
        }
    }

    public function down()
    {
        return true;
    }
}