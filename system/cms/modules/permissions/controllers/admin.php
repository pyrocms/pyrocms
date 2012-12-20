<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Permissions controller
 *
 * @author		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Permissions\Controllers
 */
class Admin extends Admin_Controller
{

	/**
	 * Constructor method.
	 *
	 * As well as everything in the Admin_Controller::__construct(),
	 * this additionally loads the models and language strings for
	 * permission and group.
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
	 * The main index page in the administration.
	 *
	 * Shows a list of the groups.
	 */
	public function index()
	{
		$this->template
			->set('admin_group', $this->config->item('admin_group', 'ion_auth'))
			->set('groups', $this->group_m->get_all())
			->title($this->module_details['name'])
			->build('admin/index');
	}

	/**
	 * Shows the permissions for a specific user group.
	 *
	 * @param int $group_id The id of the group to show permissions for.
	 */
	public function group($group_id)
	{

		$this->load->library('form_validation');

		if ($_POST)
		{
			$modules = $this->input->post('modules');
			$roles = $this->input->post('module_roles');

			// Save the permissions.
			if ( $this->permission_m->save($group_id, $modules, $roles)){

				// Fire an event. Permissions have been saved.
				Events::trigger('permissions_saved', array($group_id, $modules, $roles));

				$this->session->set_flashdata('success', lang('permissions:message_group_saved_success'));
			}
			else
			{
				$this->session->set_flashdata('error', lang('permissions:message_group_saved_error'));
			}

			$this->input->post('btnAction') === 'save_exit' 
				? redirect('admin/permissions')
				: redirect('admin/permissions/group/'.$group_id);
		}
		// Get the group data
		$group = $this->group_m->get($group_id);
		// If the group data could not be retrieved
		if ( ! $group) {
			// Set a message to notify the user.
			$this->session->set_flashdata('error', lang('permissions:message_no_group_id_provided'));
			// Send him to the main index to select a proper group.
			redirect('admin/permissions');
		}

		// See if this is the admin group
		$group_is_admin = (bool) ($this->config->item('admin_group', 'ion_auth') == $group->name);
		// Get the groups permission rules (no need if this is the admin group)
		$edit_permissions = ($group_is_admin) ? array() : $this->permission_m->get_group($group_id);
		// Get all the possible permission rules from the installed modules
		$permission_modules = $this->module_m->get_all(array('is_backend' => true, 'installed' => true));

		foreach ($permission_modules as &$permission_module)
		{
			$permission_module['roles'] = $this->module_m->roles($permission_module['slug']);
		}

		$this->template
			->append_js('module::group.js')
			->set('edit_permissions', $edit_permissions)
			->set('group_is_admin', $group_is_admin)
			->set('permission_modules', $permission_modules)
			->set('group', $group)
			->build('admin/group');
	}
}