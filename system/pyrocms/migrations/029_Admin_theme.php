<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Admin_theme extends Migration {

	function up()
	{
		$default_admin = "
			INSERT INTO " . $this->db->dbprefix('settings') . " (`slug`, `title`, `description`, `type`, `default`, `value`, `options`, `is_required`, `is_gui`, `module`, `order`)
			VALUES 					('admin_theme','Admin Theme','Select the theme for the admin panel.','','admin_theme','admin_theme','get_themes','1','0','','0');
		";
		
		$this->db->query($default_admin);
	}

	function down()
	{
		$this->db->delete('settings', array('slug' => 'admin_theme'));
	}
}