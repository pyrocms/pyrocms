<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * The Maintenance Module - currently only remove/empty cache folder(s)
 *
 * @author		Donald Myers
 * @package		PyroCMS
 * @subpackage	Maintenance Module
 * @category	Modules
 */
class Module_Maintenance extends Module 
{

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Maintenance',
				'el' => 'Συντήρηση',
				'ar' => 'الصيانة',
			),
			'description' => array(
				'en' => 'Manually delete cache items via the admin interface.',
				'el' => 'Διαγραφή αντικειμένων προσωρινής αποθήκευσης μέσω της σελίδας διαχείρισης.',
				'ar' => 'حذف عناصر الذاكرة المخبأة عبر واجهة الإدارة.',
			),
			'frontend' => FALSE,
			'backend' => TRUE,
			'menu' => 'utilities'
		);
	}


	public function install()
	{
		return TRUE;
	}


	public function uninstall()
	{
		return TRUE;
	}


	public function upgrade($old_version)
	{
		return TRUE;
	}


	public function help()
	{
		return "This module will clean up and/or remove cache files and folders.";
	}


}

/* End of file details.php */
