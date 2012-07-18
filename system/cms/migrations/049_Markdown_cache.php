<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Markdown_cache extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('blog', array(
			'parsed' => array(
				'type'			=> 'text'
			)
		));
		
		$this->dbforge->add_column('page_chunks', array(
			'parsed' => array(
				'type'			=> 'text'
			)
		));
		
		$this->dbforge->add_column('comments', array(
			'parsed' => array(
				'type'			=> 'text'
			)
		));
	}

	public function down()
	{
		$this->dbforge->drop_column('blog', 'parsed');
		$this->dbforge->drop_column('page_chunks', 'parsed');
		$this->dbforge->drop_column('comments', 'parsed');
	}
}