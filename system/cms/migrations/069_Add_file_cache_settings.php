<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_file_cache_settings extends CI_Migration {

	public function up()
	{
		$this->db->insert('settings', array(
			'slug'			=> 'files_cache',
			'title'			=> 'Files Cache',
			'description'	=> 'When outputting an image via site.com/files what shall we set the cache expiration for?',
			'`default`' 	=> '8-hour',
			'`value`'		=> '480',
			'type'			=> 'select',
			'`options`'		=> '0=no-cache|1=1-minute|60=1-hour|180=3-hour|480=8-hour|1440=1-day|43200=30-days',
			'is_required'	=> 1,
			'is_gui' 		=> 1,
			'module' 		=> 'files'
		));
	}

	public function down()
	{
		$this->db->delete('settings', array('slug' => 'files_cache'));
	}
}