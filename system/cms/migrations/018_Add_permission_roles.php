<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_permission_roles extends Migration {

	function up()
	{
		$this->dbforge->add_column('permissions', array(
			'roles' => array(
				'type' => 'text',
				'null' => TRUE
			)
		));
	}

	function down()
	{
		$this->dbforge->drop_column('permissions', 'roles');
	}
}