<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	function __construct()
	{
		parent::Admin_Controller();
		$this->load->model('packages_m');
		$this->lang->load('packages');
	}
	
	function index()
	{
		$this->load->helper('text');
				
		// Create pagination links
		$total_rows = $this->packages_m->countPackages();
		$this->data->pagination = create_pagination('admin/packages/index', $total_rows);
		
		// Using this data, get the relevant results
		$this->data->packages = $this->packages_m->getPackages(array('limit' => $this->data->pagination['limit']));		
		$this->layout->create('admin/index', $this->data);
	}
	
	// Admin: Create a New package
	function create()
	{
		$this->load->library('validation');
		$rules['title'] = 'trim|required|callback__createTitleCheck';
		$rules['description'] = 'trim|required';
		
		$this->validation->set_rules($rules);
		$this->validation->set_fields();
		
		if ($this->validation->run())
		{
			if ($this->packages_m->newPackage($_POST))
			{
				$this->session->set_flashdata('success', $this->lang->line('pack_add_success'));
			}            
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('pack_add_error'));
			}
			redirect('admin/packages/index');
		}
		
		// Set values for data fields
		foreach(array_keys($rules) as $field)
		{
			$this->data->package->$field = (isset($_POST[$field])) ? $this->validation->$field : '';
		}
		
		// Load WYSIWYG editor
		$this->layout->extra_head( $this->load->view('fragments/wysiwyg', $this->data, TRUE) );		
		$this->layout->create('admin/form', $this->data);
	}
	
	// Admin: Edit a package
	function edit($slug = '')
	{
		if (!$slug)
		{
			redirect('admin/packages/index');
		}
		
		$this->load->library('validation');
		$rules['title'] = 'trim|required';
		$rules['description'] = 'trim|required';
		$this->validation->set_rules($rules);
		$this->validation->set_fields();		
		$this->data->package = $this->packages_m->getPackage($slug);
		
		foreach(array_keys($rules) as $field)
		{
			if(isset($_POST[$field]))
			{
				$this->data->package->$field = $this->validation->$field;
			}
		}    	 
		
		if ($this->validation->run())
		{
			if ($this->packages_m->updatePackage($_POST, $slug))
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('pack_edit_success'), $this->input->post('title')));
			}    		
			else
			{
				$this->session->set_flashdata(array('error'=> $this->lang->line('pack_edit_error')));
			}			
			redirect('admin/packages/index', $this->data);
		}
		
		// Load WYSIWYG editor
		$this->layout->extra_head( $this->load->view('fragments/wysiwyg', $this->data, TRUE) );		
		$this->layout->create('admin/form', $this->data);
	}
	
	// Admin: Delete a package
	function delete($slug = '')
	{
		// Delete one
		if($slug)
		{
			$this->packages_m->deletePackage($slug);
		}		
		// Delete multiple
		else
		{
			foreach ($this->input->post('delete') as $category => $value)
			{
				$this->packages_m->deletePackage($category);
			}
		}
		
		$this->session->set_flashdata('success', $this->lang->line('pack_delete_success'));
		redirect('admin/packages/index');	
	}
	
	// Admin: List all packages
	function show()
	{
		if ($this->input->post('btnSave'))
		{
			$this->packages_m->updateFeatured($this->input->post('featured'));
		}
		
		$this->data->packages = $this->packages_m->getPackages();
		$this->layout->create('admin/index', $this->data);
	}
		
	// Callback: from create()
	function _createTitleCheck($title = '')
	{
		if ($this->packages_m->checkTitle($title))
		{
			$this->validation->set_message('_createTitleCheck', $this->lang->line('pack_already_exist_error'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}
?>