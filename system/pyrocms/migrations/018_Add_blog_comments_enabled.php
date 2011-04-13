<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_blog_comments_enable extends Migration {

	function up()
	{
		$this->dbforge->add_column('blog', array(
			'`comments_enabled`' => array(
				'type' => 'int',
				'constraint' => 1,
				'null' => FALSE,
				'default' => 1
			)
		));
	}

	function down()
	{
		$this->dbforge->drop_column('blog', 'comments_enabled');
	}
}