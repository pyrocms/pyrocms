<?php
/**
 * @name 		Modules admin controller
 * @author 		Yorick Peterse - PyroCMS Development Team
 * @package 	PyroCMS
 * @subpackage 	Core modules
 * @since 		v0.9.7
 */
class Admin extends Admin_Controller
{
	function __construct()
	{
		parent::Admin_Controller();
		$this->lang->load('modules');
	}
	
	function index()
	{
 		$this->data->modules = $this->modules_m->getModules();
			  
		$this->template->build('admin/index', $this->data);
	}
}
?>