<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_widget_instance_context extends CI_Migration {

    public function up()
    {
        if ( ! $this->db->field_exists('page_slugs', 'widget_instances'))
        {
            $this->dbforge->add_column('widget_instances', array(
                'page_slugs' => array(
    				'type' => 'VARCHAR',
    				'constraint' => 255,
    				'default' => ''
    			),
    			'show_or_hide' => array(
					'type' => 'TINYINT',
					'constraint' => 1,
					'default' => 1
				)
            ));
        }
    }

    public function down()
    {
        return true;
    }
}