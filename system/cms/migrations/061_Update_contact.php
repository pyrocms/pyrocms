<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update_contact extends CI_Migration {

	public function up()
	{
		$this->dbforge->drop_column('contact_log', 'company_name');
		$this->dbforge->drop_column('contact_log', 'name');
		$this->dbforge->add_column('contact_log', array('attachments' => array('type' => 'text')));
		
		return true;
	}

	public function down()
	{
		$this->dbforge->drop_column('contact_log', 'attachments');
		$this->dbforge->add_column('contact_log', array('company_name' => array('type' => 'varchar',
																				'constraint' => 255,
																				'default' => ''
																				)
														));
		$this->dbforge->add_column('contact_log', array('name' => array('type' => 'varchar',
																		'constraint' => 255,
																		'default' => ''
																		)
														));
		
		return true;
	}
}