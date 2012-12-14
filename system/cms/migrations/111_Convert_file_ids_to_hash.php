<?php defined('BASEPATH') or exit('No direct script access allowed');


class Migration_Convert_file_ids_to_hash extends CI_Migration
{
    public function up()
    {
        $files = array(
            'id' => array(
                'type' => 'CHAR',
                'constraint' => 15,
                'primary' => true
            )
        );
        $this->dbforge->modify_column('files', $files);
    }

    public function down()
    {
        return true;
    }
}