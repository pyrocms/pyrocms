<?php defined('BASEPATH') or exit('No direct script access allowed');


class Migration_Add_menu_stream_field extends CI_Migration
{
    public function up()
    {
       if ( ! $this->db->field_exists('menu_path', 'data_streams'))
       {
            $columns = array(
                'menu_path' => array(
                            'type' => 'VARCHAR',
                            'null' => true,
                            'constraint' => 255
                        ),

            );
            $this->dbforge->add_column('data_streams', $columns);
        }
    }

    public function down()
    {
        return true;
    }
}