<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_js_and_css_to_galleries extends Migration {

	function up()
	{
		$this->dbforge->add_column('galleries', array(
			'css' => array(
				'type'		=> 'text',
				'null'		=> TRUE,
				'collation'	=> 'utf8_unicode_ci'
			),
			'js' => array(
				'type'		=> 'text',
				'null'		=> TRUE,
				'collation'	=> 'utf8_unicode_ci'
			)
		));
	}

	function down()
	{
		$this->dbforge->drop_column('galleries', 'css');
		$this->dbforge->drop_column('galleries', 'js');
	}
}