<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update_settings_xss extends CI_Migration {

	public function up()
	{
		$this->db
			->set('skip_xss', '1')
			->where('slug', 'settings')
			->update('modules');
	}

	public function down()
	{
		$this->db
			->set('skip_xss', '0')
			->where('slug', 'settings')
			->update('modules');
	}
}
