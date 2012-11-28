<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_files_keywords extends CI_Migration {

    public function up()
    {
        if ( ! $this->db->field_exists('keywords', 'files'))
        {
            $this->dbforge->add_column('files', array(
                'keywords' => array(
    				'type' => 'CHAR',
    				'constraint' => 32,
    				'default' => ''
    			)
            ));
        }
    }

    public function down()
    {
        return true;
    }
}