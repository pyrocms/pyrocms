<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_site_public_lang_setting extends Migration {

	function up()
	{
		$this->migrations->verbose AND print "Added setting - site_public_lang.";

		$this->db->insert('settings', array(
			'slug'			=> 'site_public_lang',
			'title'			=> 'Public Languages',
			'description'	=> 'Which are the languages really supported and offered on the front-end of your website?',
			'type'			=> 'checkbox',
			'default'		=> 'en',
			'value'			=> '',
			'options'		=> 'func:get_supported_lang',
			'module'		=> '',
			'is_required'	=> 1,
			'is_gui'		=> 1,
			'order'			=> 996
		));
	}

	function down()
	{
		$this->db->delete('settings', array('slug' => 'site_public_lang'));
	}
}