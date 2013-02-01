<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin_groups controller
 *
 * @author		PyroCMS Dev Team
 * @package	 PyroCMS\Core\Modules\Navigation\Controllers
 */
class Admin_groups extends Admin_Controller
{

	/**
	 * The current active section.
	 *
	 * @var int
	 */
	protected $section = 'groups';

	/**
	 * The array containing the rules for the navigation groups.
	 *
	 * @var array
	 */
	private $validation_rules = array(
		array(
			'field' => 'title',
			'label' => 'lang:global:title',
			'rules' => 'trim|required|max_length[50]'
		),
		array(
			'field' => 'abbrev',
			'label' => 'lang:nav_abbrev_label',
			'rules' => 'trim|required|max_length[50]'
		)
	);

	/**
	 * Constructor method
	 */
	public function __construct()
	{
		// Call the parent's contstructor
		parent::__construct();

		// Load the required classes
		$this->load->model('navigation_m');
		$this->load->library('form_validation');
		$this->lang->load('navigation');

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);
	}

	/**
	 * Index method, redirects back to navigation/index.
	 */
	public function index()
	{
		redirect('admin/navigation');
	}

	/**
	 * Create a new navigation group.
	 */
	public function create()
	{
		// Validate
		if ($this->form_validation->run())
		{
			// Insert the new group
			if ($id = $this->navigation_m->insert_group($_POST) > 0)
			{
				$this->session->set_flashdata('success', $this->lang->line('nav:group_add_success'));
				// Fire an event. A new navigation group has been created.
				Events::trigger('navigation_group_created', $id);
			}
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('nav:group_add_error'));
			}

			// Redirect the user
			redirect('admin/navigation/index');
		}

		// Loop through each rule
		foreach ($this->validation_rules as $rule)
		{
			$navigation_group[$rule['field']] = $this->input->post($rule['field']);
		}

		// Render the view
		$this->template
			->title($this->module_details['name'], lang('nav:group_label'), lang('nav:group_create_title'))
			->set('navigation_group', $navigation_group)
			->append_js('module::navigation.js')
			->build('admin/groups/create');
	}

	/**
	 * Delete a navigation group (or delete multiple ones).
	 *
	 * @param int $id The id of the group.
	 */
	public function delete($id = 0)
	{
		$deleted_ids = false;

		// Delete one
		if ($id)
		{
			if ($this->navigation_m->delete_group($id))
			{
				$deleted_ids[] = $id;
				$this->navigation_m->delete_link(array('navigation_group_id' => $id));
			}
		}

		// Delete multiple
		else
		{
			foreach (array_keys($this->input->post('delete')) as $id)
			{
				if ($this->navigation_m->delete_group($id))
				{
					$deleted_ids[] = $id;
					$this->navigation_m->delete_link(array('navigation_group_id' => $id));
				}
			}
		}

		// Fire an event. One or more navigation groups have been deleted.
		if ( ! empty($deleted_ids))
		{
			Events::trigger('navigation_group_deleted', $deleted_ids);
		}

		// Set the message and redirect
		$this->session->set_flashdata('success', $this->lang->line('nav:group_mass_delete_success'));
		redirect('admin/navigation/index');
	}
}