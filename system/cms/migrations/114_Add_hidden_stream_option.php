<?php defined('BASEPATH') or exit('No direct script access allowed');


class Migration_Add_hidden_stream_option extends CI_Migration
{
    public function up()
    {
        $columns = array(
            'is_hidden' => array(
                        'type' => 'ENUM',
                        'null' => true,
                        'constraint' => array('yes', 'no'),
                        'default' => 'no'
                    )
        );
        $this->dbforge->add_column('data_streams', $columns);
    }

    public function down()
    {
        return true;
    }
}