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

	/**
	 * Install
	 *
	 * Installs a third_party module
	 *
	 * @access	public
	 * @return	void
	 */
	public function install()
	{

	}

	/**
	 * Uninstall
	 *
	 * Uninstalls a third_party module
	 *
	 * @param	string	$module_slug	The slug of the module to uninstall
	 * @access	public
	 * @return	void
	 */
	public function uninstall($module_slug)
	{

	}

	/**
	 * Enable
	 *
	 * Enables a third_party module
	 *
	 * @param	string	$module_slug	The slug of the module to enable
	 * @access	public
	 * @return	void
	 */
	public function enable($module_slug)
	{

	}

	/**
	 * Disable
	 *
	 * Disables a third_party module
	 *
	 * @param	string	$module_slug	The slug of the module to disable
	 * @access	public
	 * @return	void
	 */
	public function disable($module_slug)
	{

	}

}
?>