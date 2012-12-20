<?php defined('BASEPATH') or exit('No direct script access allowed');


class Migration_Add_hidden_stream_option extends CI_Migration
{
    public function up()
    {
       if ( ! $this->db->field_exists('is_hidden', 'data_streams'))
       {
            $columns = array(
                'is_hidden' => array(
                            'type' => 'ENUM',
                            'null' => true,
                            'constraint' => array('yes', 'no'),
                            'default' => 'no'
                        ),

            );
            $this->dbforge->add_column('data_streams', $columns);
        }

       if ( ! $this->db->field_exists('permissions', 'data_streams'))
       {
            $columns = array(
                'permissions' => array(
                            'type' => 'TEXT',
                            'null' => true
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