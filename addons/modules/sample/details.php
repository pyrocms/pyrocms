<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Sample extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Sample'
			),
			'description' => array(
				'en' => 'This is a PyroCMS module sample.'
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => 'content'
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('sample_items');
		$this->db->delete('settings', array('module' => 'Sample'));
		
		$sample_items = "
			CREATE TABLE `sample_items` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) NOT NULL,
			  `slug` varchar(255) NOT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `slug` (`slug`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";
		
		$sample_setting = array(
			'slug' => 'sample_setting',
			'title' => 'Sample Setting',
			'description' => 'A Yes or No option for the Sample module',
			'`default`' => '1',
			'`value`' => '1',
			'type' => 'select',
			'`options`' => '1=Yes|0=No',
			'is_required' => 1,
			'is_gui' => 1,
			'module' => 'Sample'
		);

		if($this->db->query($sample_items) &&
		   $this->db->insert('settings', $sample_setting) &&
		   is_dir('uploads/sample') OR mkdir('uploads/sample',0777,TRUE))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('sample_items');
		$this->db->delete('settings', array('module' => 'Sample'));
		{
			return TRUE;
		}
	}


	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
	}
}
/* End of file details.php */