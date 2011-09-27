<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_markdown_support extends CI_Migration {

	public function up()
	{
		$this->dbforge->modify_column('page_chunks', array(
			'`type`' => array(
				'type'			=> "set('html', 'markdown', 'wysiwyg-advanced','wysiwyg-simple')",
				'collate'		=> 'utf8_unicode_ci',
			)
		));
	}

	public function down()
	{
		$this->dbforge->modify_column('page_chunks', array(
			'`type`' => array(
				'type'			=> "set('html', 'wysiwyg-advanced','wysiwyg-simple')",
				'collate'		=> 'utf8_unicode_ci',
			)
		));
	}
}