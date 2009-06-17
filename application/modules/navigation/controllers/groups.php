<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends Admin_Controller
{
	function __construct()
	{
		parent::Admin_Controller();
		$this->load->model('navigation_m');
		$this->lang->load('navigation');
	}
	
	function index()
	{
		redirect('admin/navigation/index');
	}
	
	// Admin: Create a new navigation group
	function create()
	{	
		$this->load->library('validation');
		$rules['title'] = 'trim|required|max_length[50]';
		$rules['abbrev'] = 'trim|required|max_length[20]';
		$this->validation->set_rules($rules);
		$this->validation->set_fields();
		
		if ($this->validation->run())
		{
			if ($this->navigation_m->newGroup($_POST) > 0)
			{
				$this->session->set_flashdata('success', $this->lang->line('nav_group_add_success'));			
			}
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('nav_group_add_error'));
			}
			redirect('admin/navigation/index');
		}
		
		$this->data->titleLabel = $this->lang->line('title_label');
		$this->data->groupLabel = $this->lang->line('group_label');
		$this->data->abbrevLabel = $this->lang->line('abbrev_label');	
		$this->layout->create('admin/groups/create', $this->data);
	}
	
	// Admin: Delete navigation group(s)
	function delete($id = 0)
	{	
		// Delete one
		if($id)
		{
			$this->navigation_m->deleteGroup($id);
			$this->navigation_m->deleteLink(array('navigation_group_id'=>$id));
		}	
		// Delete multiple
		else
		{
			foreach (array_keys($this->input->post('delete')) as $id)
			{
				$this->navigation_m->deleteGroup($id);
				$this->navigation_m->deleteLink(array('navigation_group_id'=>$id));
			}
		}		
		$this->session->set_flashdata('success', $this->lang->line('nav_group_mass_delete_success'));
		redirect('admin/navigation/index');
	}
}
?>