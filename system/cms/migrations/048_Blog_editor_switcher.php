<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Blog_editor_switcher extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('blog', array(
			'`type`' => array(
				'type'			=> "set('html', 'markdown', 'wysiwyg-advanced','wysiwyg-simple')",
				'collate'		=> 'utf8_unicode_ci',
				'default'		=> 'wysiwyg-advanced'
			)
		));
	}

	public function down()
	{
		$this->dbforge->drop_column('blog', 'type');
	}
}