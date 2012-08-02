<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Fix_user_group extends CI_Migration
{
	public function up()
	{
		// Change the default "users" group name back to the singular form. Since the ion_auth default was set to "user"
		// this caused users to be created with a group_id of 0 when the group id wasn't provided during registration
		$this->db
			->set('name', 'user')
			->where('name', 'users')
			->where('id', 2)
			->update('groups');
	}

	public function down()
	{
		$this->db
			->set('name', 'users')
			->where('name', 'user')
			->where('id', 2)
			->update('groups');
	}
}