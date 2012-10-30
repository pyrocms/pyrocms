<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_type_field_to_redirects extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('redirects', array(
			'type' => array(
				'type'			=> 'int',
				'null'			=> false,
				'default'		=> 302
			)
		));
	}

	public function down()
	{
		$this->dbforge->drop_column('redirects', 'type');
	}
}