<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin controller for the variables module
 *
 * @author 	Phil Sturgeon - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Variables Module
 * @category	Modules
 */
class Admin extends Admin_Controller
{
	/**
	 * Array containing the validation rules
	 * @access private
	 * @var array
	 */
	private $validation_rules = array();

	/**
	 * Constructor method
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		// Call the parent's constructor method
		parent::__construct();

		// Load the required classes
		$this->load->library('form_validation');
		$this->load->model('variables_m');
		$this->lang->load('variables');

		// Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'name',
				'label' => lang('variables.name_label'),
				'rules' => 'trim|required|max_length[50]|callback__check_name[0]'
			),
			array(
				'field' => 'data',
				'label' => lang('variables.data_label'),
				'rules' => 'trim|max_length[250]'
			),
		);

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);

		$this->template->append_metadata( js('variables.js', 'variables') )
				->set_partial('shortcuts', 'admin/partials/shortcuts');
				
		//set template layout to false if request is of ajax type
		if($this->_is_ajax())
		{
			$this->template->set_layout(FALSE);
		}
	}

	/**
	 * List all variables
	 * @access public
	 * @return void
	 */
	public function index()
	{
        // Create pagination links
		$total_rows = $this->variables_m->count_all();
		$this->data->pagination = create_pagination('admin/variables/index', $total_rows);

		// Using this data, get the relevant results
		$this->data->variables = $this->variables_m->limit( $this->data->pagination['limit'] )->get_all();
		$this->template
			->title($this->module_details['name'])
			->build('admin/index', $this->data);
	}

	/**
	 * Create a new variable
	 * @access public
	 * @return void
	 */
	public function create()
	{
		// Got validation?
		if ($this->form_validation->run())
		{
			if ($this->variables_m->insert($_POST))
			{
				$message = lang('variables.add_success');
				$status = 'success';
			}
			else
			{
				$message = lang('variables.add_error');
				$status = 'error';
			}

			//if request is ajax return json data, otherwise do normal stuff
			if($this->_is_ajax())
			{
				$json = array('status' => $status,
					      'message' => $message
					      );
				echo json_encode($json);
				return;
			}
			else
			{
				// Redirect
				$this->session->set_flashdata($status, $message);
				redirect('admin/variables');
			}
		}
		else
		{
			// Loop through each validation rule
			foreach($this->validation_rules as $rule)
			{
				$variable->{$rule['field']} = set_value($rule['field']);
			}
		}

		$this->data->variable =& $variable;

		if($this->_is_ajax() && $_POST)
		{
			$errors = validation_errors();
			echo json_encode(array('status' => 'error',
						'message' => $errors
					       )
					 );
		}
		else
		{
			$this->template
				->title($this->module_details['name'],lang('variables.create_title'))
				->build('admin/form', $this->data);
		}
		
		
	}

	/**
	 * Edit an existing variable
	 * @access public
	 * @param int $id The ID of the variable
	 * @return void
	 */
	public function edit($id = 0)
	{
		// Got ID?
		if (!$id)
		{
			redirect('admin/variables');
		}

		// Get the variable
		$variable = $this->variables_m->get($id);

		// Modified validation rules
		$this->validation_rules[0]['rules'] = 'trim|required|max_length[50]|callback__check_name['. $id .']';
		$this->form_validation->set_rules($this->validation_rules);

		if ($this->form_validation->run())
		{
			if ($this->variables_m->update($id, $_POST))
			{
				$message = lang('variables.edit_success');
				$status = 'success';
			}
			else
			{
				$message = lang('variables.edit_error');
				$status = 'error';
			}
			
			//if request is ajax return json data, otherwise do normal stuff
			if($this->_is_ajax())
			{
				$json = array('status' => $status,
					      'message' => $message
					      );
				echo json_encode($json);
				return;
			}
			else
			{
				// Redirect
				$this->session->set_flashdata($status, $message);
				redirect('admin/variables');
			}
		}
		else
		{
			// Loop through each validation rule
			foreach($this->validation_rules as $rule)
			{
				if ($this->input->post($rule['field']) !== FALSE)
				{
					$variable->{$rule['field']} = set_value($rule['field']);
				}
			}
		}

		$this->data->variable =& $variable;
		
		if($this->_is_ajax() && $_POST)
		{
			$errors = validation_errors();
			echo json_encode(array('status' => 'error',
						'message' => $errors
					       )
					 );
		}
		elseif($this->_is_ajax() && !$_POST)
		{
			$this->template->build('admin/form_inline', $this->data);
		}
		else
		{
			$this->template
				->title($this->module_details['name'],sprintf(lang('variables.edit_title'), $variable->name))
				->build('admin/form', $this->data);
		}
	}

	/**
	 * Delete an existing variable
	 * @access public
	 * @param int $id The ID of the variable
	 * @return void
	 */
	public function delete($id = 0)
	{
		$id_array = (!empty($id)) ? array($id) : $this->input->post('action_to');

		// Delete multiple
		if(!empty($id_array))
		{
			$deleted = 0;
			$to_delete = 0;
			foreach ($id_array as $id)
			{
				if($this->variables_m->delete($id))
				{
					$deleted++;
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('variables.mass_delete_error'), $id));
				}
				$to_delete++;
			}

			if( $deleted > 0 )
			{
				$this->session->set_flashdata('success', sprintf(lang('variables.mass_delete_success'), $deleted, $to_delete));
			}
		}
		else
		{
			$this->session->set_flashdata('error', lang('var_no_select_error'));
		}

		// Redirect
		redirect('admin/variables');
	}

	/**
	 * Callback method for validating the variable's name
	 * @access public
	 * @param str $name The name of the variable
	 * @param int $id the ID of the variable
	 * @return bool
	 */
	public function _check_name($name = '', $id = 0)
	{
		if ($this->variables_m->check_name($id, $name))
		{
			$this->form_validation->set_message('_check_name', sprintf(lang('variables.already_exist_error'), $name));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	private function _is_ajax()
	{
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') ? TRUE : FALSE;
	}
}
?>
