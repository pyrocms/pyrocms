<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Permissions controller
 *
 * @author 		Phil Sturgeon
 * @author 		Yorick Peterse
 * @author		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Permissions\Controllers
 */
class Admin extends Admin_Controller
{
	/**
	 * Constructor method
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
	    parent::__construct();
	
	    $this->load->model('permission_m');
	    $this->load->model('groups/group_m');
	    $this->lang->load('permissions');
	    $this->lang->load('groups/group');
	}

	/**
	* Index methods, lists all permissions
	* @access public
	* @return void
	*/
	public function index()
	{
		$this->template->groups = $this->group_m->get_all();
	
		$this->template
			->title($this->module_details['name'])
			->build('admin/index', $this->data);
	}

	public function group($group_id)
	{
		$this->load->library('form_validation');

		if ($_POST)
		{
			$modules = $this->input->post('modules');
			$roles = $this->input->post('module_roles');

			// save the permissions
			$this->permission_m->save($group_id, $modules, $roles);

			// Fire an event. Permissions have been saved.
			Events::trigger('permissions_saved', array($group_id, $modules, $roles));

			$this->session->set_flashdata('success', lang('permissions.message_group_saved'));

			redirect('admin/permissions/group/'.$group_id);
		}

		$group = $this->group_m->get($group_id);
		$edit_permissions = $this->permission_m->get_group($group_id);
		$permission_modules = $this->module_m->get_all(array('is_backend' => TRUE));

		foreach ($permission_modules as &$module)
		{
			$module['roles'] = $this->module_m->roles($module['slug']);
		}

		$this->template
			->set('edit_permissions', $edit_permissions)
			->set('permission_modules', $permission_modules)
			->set('group', $group)
			->build('admin/group', $this->data);
	}
}