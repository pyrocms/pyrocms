<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin controller for the variables module
 *
 * @author		Phil Sturgeon - PyroCMS Dev Team
 * @package		PyroCMS
 * @subpackage 	Variables Module
 * @category	Modules
 * @copyright	Copyright (c) 2008 - 2011, PyroCMS
 */
class Admin extends Admin_Controller
{
	/**
	 * Variable's ID
	 * 
	 * @access	public
	 * @var		int
	 */
	public	$id = 0;

	/**
	 * Array containing the validation rules
	 * 
	 * @access	private
	 * @var		array
	 */
	private	$_validation_rules = array(
		array(
			'field' => 'name',
			'label' => 'lang:variables.name_label',
			'rules' => 'trim|required|alpha_dash|max_length[50]|callback__check_name[0]'
		),
		array(
			'field' => 'data',
			'label' => 'lang:variables.data_label',
			'rules' => 'trim|max_length[250]'
		),
	);

	/**
	 * Constructor method
	 * 
	 * @access	public
	 * @return	void
	 */
	public function __construct()
	{
		// Call the parent's constructor method
		parent::__construct();

		// Load the required classes
		$this->load->library('form_validation');
		$this->load->model('variables_m');
		$this->lang->load('variables');

		// Set the validation rules
		$this->form_validation->set_rules($this->_validation_rules);

		$this->template
			->append_metadata( js('variables.js', 'variables') )
			->set_partial('shortcuts', 'admin/partials/shortcuts');

		// Set template layout to false if request is of ajax type
		if ($this->input->is_ajax_request())
		{
			$this->template->set_layout(FALSE);
		}
	}

	/**
	 * List all variables
	 * 
	 * @access	public
	 * @return	void
	 */
	public function index()
	{
        // Create pagination links
		$this->data->pagination = create_pagination('admin/variables/index', $this->variables_m->count_all());

		// Using this data, get the relevant results
		$this->data->variables = $this->variables_m
			->limit( $this->data->pagination['limit'] )
			->get_all();
	
		$this->template
			->title($this->module_details['name'])
			->build('admin/index', $this->data);
	}

	/**
	 * Create a new variable
	 * 
	 * @access	public
	 * @return	void
	 */
	public function create()
	{
		// Got validation?
		if ($this->form_validation->run())
		{
			$name = $this->input->post('name');

			if ($this->variables_m->insert($this->input->post()))
			{
				$message	= sprintf(lang('variables.add_success'), $name);
				$status		= 'success';
			}
			else
			{
				$message	= sprintf(lang('variables.add_error'), $name);
				$status		= 'error';
			}

			// If request is ajax return json data, otherwise do normal stuff
			if ($this->input->is_ajax_request())
			{
				$data = array();
				$data['messages'][$status] = $message;
				$message = $this->load->view('admin/partials/notices', $data, TRUE);

				return print ( json_encode((object) array(
					'status'	=> $status,
					'message'	=> $message
				)) );
			}

			// Redirect
			$this->session->set_flashdata($status, $message);
			redirect('admin/variables' . ($status === 'error' ? '/create': ''));
		}
		elseif (validation_errors())
		{
			// if request is ajax return json data, otherwise do normal stuff
			if ($this->input->is_ajax_request())
			{
				$message = $this->load->view('admin/partials/notices', array(), TRUE);

				return $this->template->build_json(array(
					'status'	=> 'error',
					'message'	=> $message
				));
			}
		}

		// Loop through each validation rule
		foreach ($this->_validation_rules as $rule)
		{
			$variable->{$rule['field']} = set_value($rule['field']);
		}

		$this->data->variable =& $variable;

		$this->template
			->title($this->module_details['name'], lang('variables.create_title'))
			->build('admin/form', $this->data);
	}

	/**
	 * Edit an existing variable
	 * 
	 * @access	public
	 * @param	int $id The ID of the variable
	 * @return	void
	 */
	public function edit($id = 0)
	{
		// Got ID?
		$id OR redirect('admin/variables');

		// Get the variable
		$variable = $this->variables_m->get($id);
		$variable OR redirect('admin/variables');

		$this->id = $id;

		if ($this->form_validation->run())
		{
			$name = $this->input->post('name');

			if ($this->variables_m->update($id, $this->input->post()))
			{
				$message	= sprintf(lang('variables.edit_success'), $name);
				$status		= 'success';
			}
			else
			{
				$message	= sprintf(lang('variables.edit_error'), $name);
				$status		= 'error';
			}
			
			// If request is ajax return json data, otherwise do normal stuff
			if ($this->input->is_ajax_request())
			{
				$data = array();
				$data['messages'][$status] = $message;
				$message = $this->load->view('admin/partials/notices', $data, TRUE);

				return $this->template->build_json(array(
					'status'	=> $status,
					'message'	=> $message,
					'title'		=> sprintf(lang('variables.edit_title'), $name)
				));
			}

			// Redirect
			$this->session->set_flashdata($status, $message);
			redirect('admin/variables' . ($status === 'error' ? '/edit': ''));
		}
		elseif (validation_errors())
		{
			if ($this->input->is_ajax_request())
			{
				$message = $this->load->view('admin/partials/notices', array(), TRUE);

				return $this->template->build_json(array(
					'status'	=> 'error',
					'message'	=> $message
				));
			}
		}

		// Loop through each validation rule
		foreach($this->_validation_rules as $rule)
		{
			if ($this->input->post($rule['field']) !== FALSE)
			{
				$variable->{$rule['field']} = set_value($rule['field']);
			}
		}

		$this->data->variable =& $variable;

		if ($this->input->is_ajax_request())
		{
			return $this->template->build('admin/form_inline', $this->data);
		}

		$this->template
			->title($this->module_details['name'], sprintf(lang('variables.edit_title'), $variable->name))
			->build('admin/form', $this->data);
	}

	/**
	 * Delete an existing variable
	 * 
	 * @access	public
	 * @param	int $id The ID of the variable
	 * @return	void
	 */
	public function delete($id = 0)
	{
		$ids		= $id ? array($id): $this->input->post('action_to');
		$total		= sizeof($ids);
		$deleted	= array();

		// Try do deletion
		foreach ($ids as $id)
		{
			// Get the row to use a value.. as title, name
			if ($variable = $this->variables_m->get($id))
			{
				// Make deletion retrieving an status and store an value to display in the messages
				$deleted[($this->variables_m->delete($id) ? 'success': 'error')][] = $variable->name;
			}
		}

		// Set status messages
		foreach ($deleted as $status => $values)
		{
			// Mass deletion
			if (($status_total = sizeof($values)) > 1)
			{
				$last_value		= array_pop($values);
				$first_values	= implode(', ', $values);

				// Success / Error message
				$this->session->set_flashdata($status, sprintf(lang('variables.mass_delete_' . $status), $status_total, $total, $first_values, $last_value));
			}

			// Single deletion
			else
			{
				// Success / Error messages
				$this->session->set_flashdata($status, sprintf(lang('variables.delete_' . $status), $values[0]));
			}
		}

		// He arrived here but it was not done nothing, certainly valid ids not were selected
		if ( ! $deleted)
		{
			$this->session->set_flashdata('error', lang('variables.no_select_error'));
		}

		// Redirect
		redirect('admin/variables');
	}

	/**
	 * Callback method for validating the variable's name
	 * 
	 * @access	public
	 * @param	str $name The name of the variable
	 * @return	bool
	 */
	public function _check_name($name = '')
	{
		if ($this->variables_m->check_name($name, (int) $this->id))
		{
			$this->form_validation->set_message('_check_name', sprintf(lang('variables.already_exist_error'), $name));
			return FALSE;
		}

		return TRUE;
	}
}

/* End of file admin.php */