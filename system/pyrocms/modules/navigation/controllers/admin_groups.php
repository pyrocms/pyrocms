<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin_groups controller
 *
 * @author 		Phil Sturgeon, Yorick Peterse - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Navigation module
 * @category 	Modules
 */
class Admin_groups extends Admin_Controller
{
	/**
	 * The array containing the rules for the navigation groups
	 * @var array
	 * @access private
	 */
	private $validation_rules = array();

	/**
	 * Constructor method
	 * @access public
	 * @return void
	 */
	function __construct()
	{
		// Call the parent's contstructor
		parent::__construct();

		// Load the required classes
		$this->load->model('navigation_m');
		$this->load->library('form_validation');
		$this->lang->load('navigation');

		// Set the validation rules
		$this->validation_rules = array(
			array(
				'field' => 'title',
				'label' => lang('nav_title_label'),
				'rules' => 'trim|required|max_length[50]'
			),
			array(
				'field'	=> 'abbrev',
				'label'	=> lang('nav_abbrev_label'),
				'rules'	=> 'trim|required|max_length[20]'
			)
		);

		$this->form_validation->set_rules($this->validation_rules);
		$this->template->set_partial('shortcuts', 'admin/partials/shortcuts');
	}

	/**
	 * Index method, redirects back to navigation/index
	 * @access public
	 * @return void
	 */
	public function index()
	{
		// Redirect
		redirect('admin/navigation');
	}

	/**
	 * Create a new navigation group
	 * @access public
	 * @return void
	 */
	public function create()
	{
		// Validate
		if ($this->form_validation->run())
		{
			// Insert the new group
			if ($this->navigation_m->insert_group($_POST) > 0)
			{
				$this->session->set_flashdata('success', $this->lang->line('nav_group_add_success'));
			}
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('nav_group_add_error'));
			}

			// Redirect the user
			redirect('admin/navigation/index');
		}

		// Loop through each rule
		foreach($this->validation_rules as $rule)
		{
			$navigation_group->{$rule['field']} = $this->input->post($rule['field']);
		}

		// Render the view
		$this->data->navigation_group =& $navigation_group;
		$this->template
			->title($this->module_details['name'],lang('nav_group_label'), lang('nav_group_create_title'))
			->build('admin/groups/create', $this->data);
	}

	/**
	 * Delete a navigation group (or delete multiple ones)
	 * @access public
	 * @param int $id The ID of the group
	 * @return void
	 */
	public function delete($id = 0)
	{
		// Delete one
		if($id)
		{
			$this->navigation_m->delete_group($id);
			$this->navigation_m->delete_link(array('navigation_group_id'=>$id));
		}

		// Delete multiple
		else
		{
			foreach (array_keys($this->input->post('delete')) as $id)
			{
				$this->navigation_m->delete_group($id);
				$this->navigation_m->delete_link(array('navigation_group_id'=>$id));
			}
		}

		// Set the message and redirect
		$this->session->set_flashdata('success', $this->lang->line('nav_group_mass_delete_success'));
		redirect('admin/navigation/index');
	}
}
?>
