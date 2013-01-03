<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Needed to add this as a result of migration 114 possibly not firing.
 */
class Migration_Add_is_hidden_field extends CI_Migration
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
    }

    public function down()
    {
        return true;
    }
}