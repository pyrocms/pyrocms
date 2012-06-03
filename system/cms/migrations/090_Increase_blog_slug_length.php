<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Increase_blog_slug_length extends CI_Migration
{
	public function up()
	{
		$this->dbforge->modify_column('blog', array(
			'slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false),
			'title' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false),
		));
		$this->dbforge->modify_column('blog_categories', array(
			'slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false),
			'title' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false),
		));
	}

	public function down()
	{
		$this->dbforge->modify_column('blog', array(
			'slug' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => ''),
			'title' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => ''),
		));
		$this->dbforge->modify_column('blog_categories', array(
			'slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
			'title' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => ''),
		));
	}
}