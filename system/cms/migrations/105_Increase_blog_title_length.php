<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Increase_blog_title_length extends CI_Migration
{
    public function up()
    {
        $this->dbforge->modify_column('blog', array(
            'title' => array('type' => 'VARCHAR', 'constraint' => 200, 'null' => false),
            'slug' => array('type' => 'VARCHAR', 'constraint' => 200, 'null' => false),
        ));
    }

    public function down()
    {
        $this->dbforge->modify_column('blog', array(
            'title' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false),
            'slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false),
        ));
    }
}