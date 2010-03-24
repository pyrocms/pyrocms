<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	function __construct()
	{
		parent::Admin_Controller();
		$this->load->model('variables_m');
		$this->lang->load('variables');
		
	    $this->template->set_partial('sidebar', 'admin/sidebar');
	}
	
	// Admin: List Al Variables
	function index()
	{
        // Create pagination links
		$total_rows = $this->variables_m->count_all();
		$this->data->pagination = create_pagination('admin/variables/index', $total_rows);
		
		// Using this data, get the relevant results
		$this->data->variables = $this->variables_m->limit( $this->data->pagination['limit'] )->get_all();		
		$this->template->build('admin/index', $this->data);
	}
	
	// Admin: Create a new Variable
	function create()
	{
		$this->load->library('validation');
		$rules['name'] = 'trim|required|max_length[50]|callback__check_name[0]';
		$rules['data'] = 'trim|max_length[250]';
		$this->validation->set_rules($rules);
		$this->validation->set_fields();
		
		if ($this->validation->run())
		{
			if (  $this->variables_m->insert($_POST) )
			{
				$this->session->set_flashdata('success', $this->lang->line('var_add_success'));
			}			
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('var_add_error'));
			}
			redirect('admin/variables/index');		
		}
		
		foreach(array_keys($rules) as $field)
		{
			$this->data->variable->$field = (isset($_POST[$field])) ? $this->validation->$field : '';
		}
				
		$this->template->build('admin/form', $this->data);
	}
	
	// Admin: Edit a variable
	function edit($id = 0)
	{	
		if (!$id)
		{
			redirect('admin/variables/index');
		}
		
		$this->load->library('validation');
		$rules['name'] = 'trim|required|max_length[50]|callback__check_name['. $id .']';
		$rules['data'] = 'trim|max_length[250]';
		$this->validation->set_rules($rules);
		$this->validation->set_fields();
		
		if ($this->validation->run())
		{		
			if ($this->variables_m->update($id, $_POST))
			{
				$this->session->set_flashdata('success', $this->lang->line('var_edit_success'));
			}		
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('var_edit_error'));
			}
			
			redirect('admin/variables/index');
		}		
		
		$variable = $this->variables_m->get($id);
			
		foreach(array_keys($rules) as $field)
		{
			if($this->input->post($field)) $variable->$field = $this->validation->$field;
		}
	
		$this->data->variable =& $variable;
		$this->template->build('admin/form', $this->data);
	}	
	
	// Admin: Delete a variable
	function delete($id = 0)
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
					$this->session->set_flashdata('error', sprintf($this->lang->line('var_mass_delete_error'), $id));
				}
				$to_delete++;
			}
			
			if( $deleted > 0 )
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('var_mass_delete_success'), $deleted, $to_delete));
			}
		}		
		else
		{
			$this->session->set_flashdata('error', $this->lang->line('var_no_select_error'));
		}		
		redirect('admin/variables/index');
	}	
	
	// Callback: with additional ID value :). so that during edit user can't create a duplicate value :)
	function _check_name( $name = '', $id = 0)
	{
		if ($this->variables_m->check_name($id, $name))
		{
			$this->validation->set_message('_check_name', sprintf($this->lang->line('var_already_exist_error'), $name));
			return FALSE;
		}
		else
		{
            return TRUE;
		}
	}
}
?>