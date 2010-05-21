<?php
class Forums_m extends MY_Model
{
	public function add_setting()
	{
		$setting = array(
			'slug'			=> 'forums_editor',
			'title'			=> 'Forum Editor',
			'description'	=> 'Which editor should the forums use?',
			'type'			=> 'select',
			'`default`'		=> 'bbcode',
			'`value`'		=> 'bbcode',
			'options'		=> 'bbcode=BBCode|textile=Textile',
			'is_required'	=> 1,
			'is_gui'		=> 1,
			'module'		=> 'forums'
		);

		$this->db->insert('settings', $setting);
	}
}
