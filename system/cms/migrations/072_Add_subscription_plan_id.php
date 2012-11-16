<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_subscription_plan_id extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('groups', array(
			'subscription_plan_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'null' => true,
			),
		));
	}

	public function down()
	{
		$this->dbforge->drop_column('groups', 'subscription_plan_id');
	}
}