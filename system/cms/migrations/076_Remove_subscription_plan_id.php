<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Remove_subscription_plan_id extends CI_Migration {

	public function up()
	{
		if ($this->db->field_exists('subscription_plan_id', 'groups'))
		{
			$this->dbforge->drop_column('groups', 'subscription_plan_id');
		}
	}

	public function down()
	{
		$this->dbforge->add_column('groups', array(
			'subscription_plan_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'null' => true,
			),
		));
	}
}