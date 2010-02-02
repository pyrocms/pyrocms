<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	function __construct()
	{
		parent::Admin_Controller();
		$this->load->model('categories_m');
		$this->lang->load('categories');
		
	    $this->template->set_partial('sidebar', 'admin/sidebar');
	}
	
	// Admin: List all Categories
	function index()
	{
		// Create pagination links
		$total_rows = $this->categories_m->count_all();
		$this->data->pagination = create_pagination('admin/categories/index', $total_rows);
			
		// Using this data, get the relevant results
		$this->data->categories = $this->categories_m->limit( $this->data->pagination['limit'] )->get_all();		
		$this->template->build('admin/index', $this->data);
	}
	
	// Admin: Create a new Category
	function create()
	{
		$this->load->library('validation');
		$rules['title'] = 'trim|required|max_length[20]|callback__check_title';
		$this->validation->set_rules($rules);
		$this->validation->set_fields();
		
		if ($this->validation->run())
		{
			if (  $this->categories_m->insert($_POST) )
			{
				$this->session->set_flashdata('success', $this->lang->line('cat_add_success'));
			}			
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('cat_add_error'));
			}
			redirect('admin/categories/index');		
		}
		
		foreach(array_keys($rules) as $field)
		{
			$this->data->category->$field = (isset($_POST[$field])) ? $this->validation->$field : '';
		}
				
		$this->template->build('admin/form', $this->data);
	}
	
	// Admin: Edit a Category
	function edit($id = 0)
	{	
		if (!$id)
		{
			redirect('admin/categories/index');
		}
		
		$this->load->library('validation');
		$rules['title'] = 'trim|required';
		$this->validation->set_rules($rules);
		$this->validation->set_fields();
		
		if ($this->validation->run())
		{		
			if ($this->categories_m->update($id, $_POST))
			{
				$this->session->set_flashdata('success', $this->lang->line('cat_edit_success'));
			}		
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('cat_edit_error'));
			}
			
			redirect('admin/categories/index');
		}		
		
		$category = $this->categories_m->get($id);
			
		foreach(array_keys($rules) as $field)
		{
			if($this->input->post($field)) $category->$field = $this->validation->$field;
		}
	
		$this->data->category =& $category;
		$this->template->build('admin/form', $this->data);
	}	
	
	// Admin: Delete a Category
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
				if($this->categories_m->delete($id))
				{
					$deleted++;
				}
				else
				{
					$this->session->set_flashdata('error', sprintf($this->lang->line('cat_mass_delete_error'), $id));
				}
				$to_delete++;
			}
			
			if( $deleted > 0 )
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('cat_mass_delete_success'), $deleted, $to_delete));
			}
		}		
		else
		{
			$this->session->set_flashdata('error', $this->lang->line('cat_no_select_error'));
		}		
		redirect('admin/categories/index');
	}	
	
	// Callback: from create()
	function _check_title($title = '')
	{
		if ($this->categories_m->check_title($title))
		{
			$this->validation->set_message('_check_title', sprintf($this->lang->line('cat_already_exist_error'), $title));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}
?>