<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_blog_author_field extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('blog', array(
			'author_id' => array(
				'type'			=> 'int',
				'constraint'	=> 11,
				'null'			=> FALSE,
				'default'		=> 0
			)
		));
	}

	public function down()
	{
		$this->dbforge->drop_column('blog', 'author_id');
	}
}