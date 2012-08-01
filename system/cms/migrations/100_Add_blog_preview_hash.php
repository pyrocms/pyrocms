<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_blog_preview_hash extends CI_Migration {

    public function up()
    {
      if (!$this->db->field_exists('preview_hash', 'blog'))
       $result = $this->dbforge->add_column('blog', array(
            'preview_hash' => array(
            	'type'		=> 'char',
            	'constraint'=> 32,
            	'default'	=> ''
            )
        ));      
    }

    public function down()
    {
    	if ($this->db->field_exists('preview_hash', 'blog'))
        $this->dbforge->drop_column('blog','preview_hash');
    }

}