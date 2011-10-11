<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Roles controller for the groups module
 *
 * @author Phil Sturgeon - PyroCMS Dev Team
 * @package PyroCMS
 * @subpackage Groups Module
 * @category Modules
 *
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
		parent::__construct();

		// Load the required classes
		$this->load->model('group_m');
		$this->load->library('form_validation');
		$this->lang->load('group');

		// Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'name',
				'label' => lang('groups.name'),
				'rules' => 'trim|required|max_length[100]'
			),
			array(
				'field' => 'description',
				'label' => lang('groups.description'),
				'rules' => 'trim|required|max_length[250]'
			)
		);

	    $this->template->set_partial('shortcuts', 'admin/partials/shortcuts');
	}

	/**
	 * Create a new group role
	 *
	 * @access public
	 * @return void
	 */
	public function index()
	{
    	$groups = $this->group_m->get_all();

    	$this->template
    		->title($this->module_details['name'])
			->set('groups', $groups)
    		->build('admin/index', $this->data);
	}

	/**
	 * Create a new group role
	 *
	 * @access public
	 * @return void
	 */
	public function add()
	{
		if ($_POST)
		{
			$this->form_validation->set_rules($this->validation_rules);

			if ($this->form_validation->run())
			{
				$this->group_m->insert($this->input->post())
					? $this->session->set_flashdata('success', sprintf(lang('groups.add_success'), $this->input->post('name')))
					: $this->session->set_flashdata('error', sprintf(lang('groups.add_error'), $this->input->post('name')));

				redirect('admin/groups');
			}
		}

		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$group->{$rule['field']} = set_value($rule['field']);
		}

		$this->template
			->title($this->module_details['name'], lang('groups.add_title'))
			->set('group', $group)
			->build('admin/form', $this->data);
	}


	/**
	 * Edit a group role
	 *
	 * @access public
	 * @param int $id The ID of the group to edit
	 * @return void
	 */
	public function edit($id = 0)
	{
		$group = $this->group_m->get($id);

		// Make sure we found something
		$group or redirect('admin/groups');

		if ($_POST)
		{
			// Got validation?
			if ($group->name == 'admin' OR $group->name == 'user')
			{
				//if they're changing description on admin or user save the old name
				$_POST['name'] = $group->name;
				$this->form_validation->set_rules('description', lang('groups.description'), 'trim|required|max_length[250]');
			}
			else
			{
				$this->form_validation->set_rules($this->validation_rules);
			}
			
			if ($this->form_validation->run())
			{
				$this->group_m->update($id, $this->input->post())
					? $this->session->set_flashdata('success', sprintf(lang('groups.edit_success'), $this->input->post('name')))
					: $this->session->set_flashdata('error', sprintf(lang('groups.edit_error'), $this->input->post('name')));

				// Redirect
				redirect('admin/groups');
			}
		}

		$this->template
			->title($this->module_details['name'], sprintf(lang('groups.edit_title'), $group->name))
			->set('group', $group)
			->build('admin/form', $this->data);
	}

	/**
	 * Delete group role(s)
	 *
	 * @access public
	 * @param int $id The ID of the group to delete
	 * @return void
	 */
	public function delete($id = 0)
	{
		$this->group_m->delete($id)
			? $this->session->set_flashdata('success', lang('groups.delete_success'))
			: $this->session->set_flashdata('error', lang('groups.delete_error'));

		redirect('admin/groups');
	}
}
