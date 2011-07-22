<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Permissions controller
 *
 * @author 		Phil Sturgeon, Yorick Peterse - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Pages module
 * @category	Modules
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
			// register the user
			$this->permission_m->save($group_id, $this->input->post('modules'), $this->input->post('module_roles'));
			
			$this->session->set_flashdata('success', lang('permissions.message_group_saved'));

			redirect('admin/permissions/group/'.$group_id);
		}

		$group = $this->group_m->get($group_id);
		$edit_permissions = $this->permission_m->get_group($group_id);
		$permisison_modules = $this->module_m->get_all(array('is_backend' => TRUE));

		foreach ($permisison_modules as &$module)
		{
			$module['roles'] = $this->module_m->roles($module['slug']);
		}

		$this->template
			->set('edit_permissions', $edit_permissions)
			->set('permisison_modules', $permisison_modules)
			->set('group', $group)
			->build('admin/group', $this->data);
	}
}