<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Lazy_pages extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_column('pages', array(
            'strict_uri' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
                'default' => 1
            ),
        ));
    }

    public function down()
    {
		$this->dbforge->drop_column('pages', 'strict_uri');
    }
}