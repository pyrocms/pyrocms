<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_updated_on_to_widgets extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('widgets', array(
			'updated_on' => array(
				'type'			=> 'int',
				'constraint'	=> 11,
				'null'			=> false,
				'default'		=> 0
			)
		));
	}

	public function down()
	{
		$this->dbforge->drop_column('widgets', 'updated_on');
	}
}