<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Addeddateformat extends Migration {

	function up()
	{
		$this->migrations->verbose AND print "Added setting - date_format.";

		//can you set default to null with dbforge?
		$this->db->insert('settings', array(
			'slug' => 'date_format',
			'title' => 'Date Format',
			'description' => 'How should dates be displayed accross the website and control panel? Using PHP date format.',
			'type' => 'text',
			'default' => 'Y-m-d',
			'value' => '',
			'options' => '',
			'module' => '',
			'is_required' => 1,
			'is_gui' => 1
		));
	}

	function down()
	{
		$this->db->delete('settings', array('slug' => 'date_format'));
	}
}