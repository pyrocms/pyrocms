<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_comments_markdown_setting extends CI_Migration {

	public function up()
	{
		$this->db->insert('settings', array(
			'slug'			=> 'comment_markdown',
			'title'			=> 'Allow Markdown',
			'description'	=> 'Do you want to allow visitors to post comments using Markdown?',
			'type'			=> 'select',
			'default'		=> '0',
			'value'			=> '0',
			'options'		=> '0=Text Only|1=Allow Markdown',
			'module'		=> 'comments',
			'is_required'	=> 1,
			'is_gui'		=> 1,
			'order'			=> 966
		));
	}

	public function down()
	{
		$this->db->delete('settings', array('slug' => 'comment_markdown'));
	}
}