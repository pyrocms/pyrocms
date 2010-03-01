<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_layouts extends Admin_Controller
{
	// Validation rules to be used for create and edita
	private $rules = array(
	    'title'	=> 'trim|required|max_length[60]',
	    'body'	=> 'trim|required',
	    'css'	=> 'trim'
	);
	
	function __construct()
	{
		parent::Admin_Controller();
		
		$this->load->model('page_layouts_m');
		$this->lang->load('pages');
		$this->lang->load('page_layouts');
		
	    $this->template->set_partial('sidebar', 'admin/sidebar');
	}


	// Admin: List all Pages
	function index()
	{
		$this->data->page_layouts = $this->page_layouts_m->get_all();
		
		$this->template->build('admin/layouts/index', $this->data);
	}
	
	// Admin: Create a new Page
	function create()
	{
		$this->load->library('validation');
		$this->validation->set_rules($this->rules);
		$this->validation->set_fields();
	
		// Validate the page
		if ($this->validation->run())
	    {
	    	$id = $this->page_layouts_m->insert(array(
				'title' => $this->input->post('title'),
				'body' => $this->input->post('body', FALSE),
				'css' => $this->input->post('css')
			));
			
			if ( $id > 0 )
			{
				$this->session->set_flashdata('success', $this->lang->line('page_layout_create_success'));
			}
		      
			else
			{
				$this->session->set_flashdata('notice', $this->lang->line('page_layout_create_error'));
			}
			
			redirect('admin/pages/layouts');
	    }
		
		// Get the data back to the form
	    foreach(array_keys($this->rules) as $field)
	    {
			$page_layout->$field = isset($this->validation->$field) ? $this->validation->$field : '';
	    }

	    // Assign data for display
	    $this->data->page_layout =& $page_layout;
	    
	    // Load WYSIWYG editor
		$this->template->append_metadata( js('codemirror/codemirror.js') );
	    $this->template->build('admin/layouts/form', $this->data);
	}

	// Admin: Edit a Page
	function edit($id = 0)
	{
		if (empty($id))
	    {
			redirect('admin/pages/layouts');
	    }
		
	    // We use this controller property for a validation callback later on
	    $this->page_layout_id = $id;
	    
	    // Set data, if it exists
	    if (!$page_layout = $this->page_layouts_m->get($id)) 
	    {
			$this->session->set_flashdata('error', $this->lang->line('page_layout_page_not_found_error'));
			redirect('admin/pages/layouts/create');
	    }

	    $this->load->library('validation');
	    $this->validation->set_rules($this->rules);
	    $this->validation->set_fields();
		
	    // Auto-set data for the page if a post variable overrides it
	    foreach(array_keys($this->rules) as $field)
	    {
			if($this->input->post($field)) $page_layout->$field = $this->validation->$field;
	    }
	    
	    // Give validation a try, who knows, it just might work!
		if ($this->validation->run())
	    {
			// Run the update code with the POST data	
			$this->page_layouts_m->update($id, array(
				'title' => $this->input->post('title'),
				'body' => $this->input->post('body', FALSE),
				'css' => $this->input->post('css')
			));			
				
			// Wipe cache for this model as the data has changed
			$this->cache->delete_all('page_layouts_m');	
					
			$this->session->set_flashdata('success', sprintf($this->lang->line('page_layout_edit_success'), $this->input->post('title')));
			redirect('admin/pages/layouts');
	    }

	    // Assign data for display
	    $this->data->page_layout =& $page_layout;
		
	    // Load WYSIWYG editor
		$this->template->append_metadata( js('codemirror/codemirror.js') );
	    $this->template->build('admin/layouts/form', $this->data);
	}
    
	// Admin: Delete Pages
	function delete($id = 0)
	{
		// Attention! Error of no selection not handeled yet.
		$ids = ($id) ? array($id) : $this->input->post('action_to');
		
		// Go through the array of slugs to delete
		foreach ($ids as $id)
		{
			if ($id !== 1)
			{
				$deleted_ids = $this->page_layouts_m->delete($id);
				
				// Wipe cache for this model, the content has changd
				$this->cache->delete_all('page_layouts_m');
			}
				
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('page_layout_delete_home_error'));
			}
		}
		
		// Some pages have been deleted
		if(!empty($deleted_ids))
		{
			// Only deleting one page
			if( count($deleted_ids) == 1 )
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('page_layout_delete_success'), $deleted_ids[0]));
			}			
			else // Deleting multiple pages
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('page_layout_mass_delete_success'), count($deleted_ids)));
			}
		}
			
		else // For some reason, none of them were deleted
		{
			$this->session->set_flashdata('notice', $this->lang->line('page_layout_delete_none_notice'));
		}
			
		redirect('admin/pages/layouts');
	}
    
}
