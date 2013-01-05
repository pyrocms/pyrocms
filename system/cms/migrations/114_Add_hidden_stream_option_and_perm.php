<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_hidden_stream_option_and_perm extends CI_Migration
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
 
            // Since this is a new feature, we are going to give accesss
            // to all use groups first so people all the sudden
            // don't see any streams.
            $groups = $this->db
                            ->select('*, groups.id as group_id')
                            ->from('groups, permissions')
                            ->where('groups.id', 'permissions.group_id')
                            ->where('permissions.module', 'streams')
                            ->where('groups.name !=', 'admin')->get()->result();

            $groups_arr = array();
            foreach ($groups as $g)
            {
                $groups_arr[] = $g->group_id;
            }
            $this->db->update('data_streams', array('permissions' => serialize($groups_arr)));
        }
    }

    public function down()
    {
        return true;
    }
}