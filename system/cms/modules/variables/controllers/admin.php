<?php 

use Pyro\Module\Variables\Model\Variable;

/**
 * Admin controller for the variables module
 *
 * @author		PyroCMS Dev Team
 * @package	 	PyroCMS\Core\Modules\Variables\Controllers
 */
class Admin extends Admin_Controller
{
	/**
	 * Variable's ID
	 *
	 * @var		int
	 */
	public $id = 0;

	public $temp;

	/**
	 * Array containing the validation rules
	 *
	 * @var		array
	 */
	private $_validation_rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'lang:global:name',
			'rules' => 'trim|required|alpha_dash|max_length[50]|callback__check_name'
		),
		array(
			'field' => 'data',
			'label' => 'lang:variables:data_label',
			'rules' => 'trim|max_length[250]'
		),
	);

	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->library('form_validation');
		$this->lang->load('variables');

		// Set template layout to false if request is of ajax type
		if ($this->input->is_ajax_request()) {
			$this->template->set_layout(false);
		}
	}

	/**
	 * List all variables
	 */
	public function index()
	{
		// Create pagination links
		$this->template->pagination = create_pagination('admin/variables/index', Variable::all()->count());

		// Using this data, get the relevant results
		$this->template->variables = Variable::skip($this->template->pagination['offset'])->take($this->template->pagination['limit'])->get();

		$this->template
			->title($this->module_details['name'])
			->append_js('module::variables.js')
			->build('admin/index');
	}

	/**
	 * Create a new variable
	 */
	public function create()
	{
		$variable = new stdClass();

		// Set the validation rules
		$this->form_validation->set_rules($this->_validation_rules);

		// Got validation?
		if ($this->form_validation->run()) {
			$name = $this->input->post('name');

			$result = Variable::create(array(
				'name' => $this->input->post('name'),
				'data' => $this->input->post('data')
			));

			if ($result) {
				$message = sprintf(lang('variables:add_success'), $name);
				$status = 'success';
			} else {
				$message = sprintf(lang('variables:add_error'), $name);
				$status = 'error';
			}

			// If request is ajax return json data, otherwise do normal stuff
			if ($this->input->is_ajax_request()) {
				$data = array();
				$data['messages'][$status] = $message;
				$message = $this->load->view('admin/partials/notices', $data, true);

				return print (json_encode((object)array(
					'status' => $status,
					'message' => $message
				)));
			}

			$this->session->set_flashdata($status, $message);
			redirect('admin/variables'.($status === 'error' ? '/create' : ''));
		} elseif (validation_errors()) {
			// if request is ajax return json data, otherwise do normal stuff
			if ($this->input->is_ajax_request()) {
				$message = $this->load->view('admin/partials/notices', array(), true);

				return $this->template->build_json(array(
					'status' => 'error',
					'message' => $message
				));
			}
		}

		$variable = new Variable;

		// Loop through each validation rule
		foreach ($this->_validation_rules as $rule) {
			$variable->{$rule['field']} = set_value($rule['field']);
		}

		$this->template
			->title($this->module_details['name'], lang('variables:create_title'))
			->set('variable', $variable)
			->build('admin/form');
	}

	/**
	 * Edit an existing variable
	 *
	 * @param int $id The ID of the variable
	 */
	public function edit($id = 0)
	{
		// Get the variable
		$variable = Variable::find($id);
		$variable OR redirect('admin/variables');

		$this->form_validation->set_rules(array_merge($this->_validation_rules, array(
			'name' => array(
				'field' => 'name',
				'label' => 'lang:global:name',
				'rules' => 'trim|required|alpha_dash|max_length[50]|callback__check_name['.$id.']'
			)
        )));

		if ($this->form_validation->run()) {
			$variable->name = $this->input->post('name');
			$variable->data = $this->input->post('data');

			if ($variable->save()) {
				$message = sprintf(lang('variables:edit_success'), $variable->name);
				$status = 'success';
			} else {
				$message = sprintf(lang('variables:edit_error'), $variable->name);
				$status = 'error';
			}

			// If request is ajax return json data, otherwise do normal stuff
			if ($this->input->is_ajax_request()) {
				$data = array();
				$data['messages'][$status] = $message;
				$message = $this->load->view('admin/partials/notices', $data, true);

				return $this->template->build_json(array(
					'status' => $status,
					'message' => $message,
					'title' => sprintf(lang('variables:edit_title'), $variable->name)
				));
			}

			$this->session->set_flashdata($status, $message);
			redirect('admin/variables'.($status === 'error' ? '/edit' : ''));
		} elseif (validation_errors()) {
			if ($this->input->is_ajax_request()) {
				$message = $this->load->view('admin/partials/notices', array(), true);

				return $this->template->build_json(array(
					'status' => 'error',
					'message' => $message
				));
			}
		}

		$this->template->set('variable', $variable);

		if ($this->input->is_ajax_request()) {
			return $this->template->build('admin/form_inline');
		}

		$this->template
			->title($this->module_details['name'], sprintf(lang('variables:edit_title'), $variable->name))
			->build('admin/form');
	}

	/**
	 * Delete an existing variable
	 *
	 * @param	int $id The ID of the variable
	 */
	public function delete($id = 0)
	{
		$ids = $id ? array($id) : $this->input->post('action_to');
		$total = count($ids);
		$deleted = array();

		// Try do deletion
		foreach ($ids as $id) {
			// Get the row to use a value.. as title, name
			if ($variable = Variable::find($id)) {
				// Make deletion retrieving an status and store an value to display in the messages
				$deleted[(Variable::find($id)->delete() ? 'success' : 'error')][] = $variable->name;
			}
		}

		// Set status messages
		foreach ($deleted as $status => $values) {
			// Mass deletion
			if (($status_total = sizeof($values)) > 1) {
				$last_value = array_pop($values);
				$first_values = implode(', ', $values);

				// Success / Error message
				$this->session->set_flashdata($status, sprintf(lang('variables:mass_delete_'.$status), $status_total, $total, $first_values, $last_value));
			} else {
				// Success / Error messages
				$this->session->set_flashdata($status, sprintf(lang('variables:delete_'.$status), $values[0]));
			}
		}

		// He arrived here but it was not done nothing, certainly valid ids not were selected
		if (! $deleted) {
			$this->session->set_flashdata('error', lang('variables:no_select_error'));
		}

		redirect('admin/variables');
	}

	/**
	 * Callback method for validating the variable's name
	 *
	 * @param str|string $name The name of the variable
	 *
	 * @return	bool
	 */
	public function _check_name($name = '', $id = null)
	{
		$this->form_validation->set_message('_check_name', sprintf(lang('variables:already_exist_error'), $name));

		return ! Variable::findByNameWithId($from, (int)$id);
	}
}