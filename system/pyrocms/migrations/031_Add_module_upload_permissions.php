<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Addons_upload_permissions extends Migration {

	function up()
	{
		$this->db->insert('settings',
			array('slug' 			=> 'addons_upload',
					'title'			=> 'Addons Upload Permissions',
					'description'	=> 'Keeps mere admins from uploading addons by default',
					'type'			=> 'text',
					'default'		=> '0',
					'value'			=> '1',// admins can upload by default on the first site only
					'is_required'	=> '1',
					'is_gui'		=> '0')
			);
	}

	function down()
	{
		$this->db->delete('settings', array('slug' => 'addons_upload'));
	}
}