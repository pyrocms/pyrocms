<?php
/**
 * Modules controller, lists all installed modules
 * 
 * @author 		Yorick Peterse - PyroCMS Development Team
 * @package 	PyroCMS
 * @subpackage 	Core modules
 * @category 	Modules
 * @since 		v0.9.7
 */
class Admin extends Admin_Controller
{
	/**
	 * Constructor method
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::Admin_Controller();
		$this->lang->load('modules');
	}
	
	/**
	 * Index method
	 * @access public
	 * @return void
	 */
	public function index()
	{
 		$this->data->modules = $this->modules_m->get_modules();
			  
		$this->template->build('admin/index', $this->data);
	}
}
?>