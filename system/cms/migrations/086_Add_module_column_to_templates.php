<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_module_column_to_templates extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_column('email_templates', array(
            'module' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'default' => ''
            ),
        ));

        $this->db->where('slug', 'comments')->update('email_templates', array('module' => 'comments'));
        $this->db->where('slug', 'contact')->update('email_templates', array('module' => 'pages'));
        $this->db->where('slug', 'registered')->update('email_templates', array('module' => 'users'));
        $this->db->where('slug', 'activation')->update('email_templates', array('module' => 'users'));
        $this->db->where('slug', 'forgotten_password')->update('email_templates', array('module' => 'users'));
        $this->db->where('slug', 'new_password')->update('email_templates', array('module' => 'users'));
    }

    public function down()
    {
		$this->dbforge->drop_column('email_templates', 'module');
    }
}