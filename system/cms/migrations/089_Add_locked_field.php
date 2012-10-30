<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Update the fields table with a locked column
 */
class Migration_Add_locked_field extends CI_Migration {

    public function up()
    {
    	$this->load->config('streams_core/streams');

        if ( ! $this->db->field_exists('is_locked', $this->config->item('streams:fields_table')))
        {
            $this->dbforge->add_column($this->config->item('streams:fields_table'), array(
                'is_locked' => array(
    				'type' => 'ENUM',
    				'constraint' => array('yes', 'no'),
    				'default' => 'no'
    			)
            ));
        }
    }

    public function down()
    {
        return true;
    }
}