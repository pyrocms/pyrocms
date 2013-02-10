<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Needed to add the new page type description field
 */
class Migration_Add_page_types_description_field extends CI_Migration
{
    public function up()
    {
       if ( ! $this->db->field_exists('description', 'page_types'))
       {
            $columns = array(
                'description' => array(
                            'type' => 'TEXT',
                            'null' => true
                        ),
            );
            $this->dbforge->add_column('page_types', $columns, 'title');
        }
    }

    public function down()
    {
        return true;
    }
}