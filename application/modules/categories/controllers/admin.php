<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller {

    function __construct() {
        parent::Admin_Controller();
        $this->load->model('categories_m');
    }

    // Admin: List all Categories
    function index() {
        // Create pagination links
    	$total_rows = $this->categories_m->countCategories();
    	$this->data->pagination = create_pagination('admin/categories/index', $total_rows);

    	// Using this data, get the relevant results
    	$this->data->categories = $this->categories_m->getCategories(array('limit' => $this->data->pagination['limit']));
    	
        $this->layout->create('admin/index', $this->data);
        return;
    }
    
    // Admin: Create a new Category
    function create() {
        $this->load->library('validation');
        $rules['title'] = 'trim|required|max_length[20]|callback__check_title';
        $this->validation->set_rules($rules);
        $this->validation->set_fields();
        
        if ($this->validation->run())
        {
        	if (  $this->categories_m->newCategory($_POST) )
        	{
                $this->session->set_flashdata('success', 'Your category has been saved.');
            } 
            
            else
            {
            	$this->session->set_flashdata('error', 'An error occurred.');
            }
            
            redirect('admin/categories/index');
            
        }
    
        foreach(array_keys($rules) as $field) {
        	$this->data->category->$field = (isset($_POST[$field])) ? $this->validation->$field : '';
        }
        
        $this->layout->create('admin/form', $this->data);
    }
    
    // Admin: Edit a Category
    function edit($slug = ''){
    	
        if (!$slug) {
        	redirect('admin/categories/index');
        }
        $this->load->library('validation');
        $rules['title'] = 'trim|required';
        $this->validation->set_rules($rules);
        $this->validation->set_fields();

        if ($this->validation->run()) {
        	
        	if ($this->categories_m->updateCategory($_POST, $slug))
        	{
        		$this->session->set_flashdata('success', 'The category was saved.');
        	}
        	
        	else
        	{
        		$this->session->set_flashdata('error', 'An error occurred.');
        	}
        	redirect('admin/categories/index');
        }
        
        
        $this->data->category = $this->categories_m->getCategory($slug);

        foreach(array_keys($rules) as $field) {
        	if(isset($_POST[$field]))
        		$this->data->category->$field = $this->validation->$field;
        }
        
        $this->layout->create('admin/form', $this->data);
    }
    
    
	// Admin: Delete a Category
	function delete($slug = '') {

    	$slug_array = (!empty($slug)) ? array($slug) : $this->input->post('delete');

		// Delete multiple
		if(!empty($slug_array))
		{
			$deleted = 0;
			$to_delete = 0;
			foreach ($slug_array as $slug) 
			{
				if($this->categories_m->deleteCategory($slug))
				{
					$deleted++;
				}
				else
				{
					$this->session->set_flashdata('error', 'Error occurred while trying to delete category "'.$slug.'".');
				}
				$to_delete++;
			}
			
			if( $deleted > 0 )
			{
				$this->session->set_flashdata('success', $deleted.' categories out of '.$to_delete.' successfully deleted.');
			}
		}
		
		else
		{
			$this->session->set_flashdata('error', 'You need to select categories first.');
		}
		
		redirect('admin/categories/index');
	}

    
    // Callback: from create()
    function _check_title($title = '') {
        if ($this->categories_m->checkTitle($title)) {
            $this->validation->set_message('_check_title', 'A category with the name "'.$title	.'" already exists.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
}

?>