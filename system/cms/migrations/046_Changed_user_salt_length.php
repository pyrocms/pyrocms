<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Changed_user_salt_length extends CI_Migration {

	public function up()
	{
		$this->dbforge->modify_column('users', array(
			'salt' => array(
				'type'			=> 'varchar',
				'constraint'	=> 6,
				'collate'		=> 'utf8_unicode_ci',
				'default'		=> ''
			)
		));
	}

	public function down()
	{
		$this->dbforge->modify_column('users', array(
			'salt' => array(
				'type'			=> 'varchar',
				'constraint'	=> 5,
				'collate'		=> 'utf8_unicode_ci',
				'default'		=> ''
			)
		));
	}
}