<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This is a combo of two conflicting migrations.
 */
class Migration_Increase_mime_length extends CI_Migration
{
	public function up()
	{
        $this->dbforge->modify_column('files', array(
                'extension' => array('type' => 'VARCHAR', 'constraint' => 10,)
            )
        );

        $this->db->set_dbprefix('core_');
        $this->dbforge->modify_column('users', array(
            'email' => array('type' => 'VARCHAR',
                             'constraint' => 60,
                             'null' => FALSE,
                             'default' => '')
            )
        );
        $this->db->set_dbprefix(SITE_REF . '_');

        // Increate mime type length in the files module
        $this->dbforge->modify_column('files', array(
            'mimetype' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false),
        ));
    }

	public function down()
	{
        $this->dbforge->modify_column('files', array(
            'extension' => array('type' => 'VARCHAR', 'constraint'  => 5)
            )
        );

        $this->db->set_dbprefix('core_');
        $this->dbforge->modify_column('users', array(
                'email' => array('type' => 'VARCHAR',
                                 'constraint' => 40,
                                 'null' => FALSE,
                                 'default' => '')
            )
        );

        $this->db->set_dbprefix(SITE_REF . '_');
 
        $this->dbforge->modify_column('files', array(
            'mimetype' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => false),
        ));
    }
}
