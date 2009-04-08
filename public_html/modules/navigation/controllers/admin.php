<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller {

    function __construct() {
        parent::Admin_Controller();
        $this->load->model('navigation_m');
        $this->load->module_model('pages', 'pages_m');
		$this->load->module_helper('pages', 'pages');
        
        $this->load->helper('array');
        
		// Get Navigation Groups
		$this->data->groups = $this->navigation_m->getGroups();
		$this->data->groups_select = array_for_select($this->data->groups, 'id', 'title');
		
		$modules = $this->modules_m->getModules(array('is_frontend'=>true));
		$this->data->modules_select = array_for_select($modules, 'slug', 'name');
		
		 // Get Pages and create pages tree
    	$tree = array();
    	foreach($this->pages_m->getPages() AS $page)
    	{
    		$tree[$page->parent][] = $page;
    	}
    	$this->data->pages_select = $tree;
    }

    // Admin: List all Pages
    function index() {
        
    	// Go through all the groups 
    	foreach($this->data->groups as $group):
	    	//... and get navigation links for each one
    		$this->data->navigation[$group->abbrev] = $this->navigation_m->getLinks(array('group'=>$group->id, 'order'=>'position, title'));
    	endforeach;

    	$this->layout->create('admin/index', $this->data);
    }
    
    // Admin: Create a new Page
    function create() {
	
        $this->load->library('validation');
        $rules['title'] = 'trim|required|max_length[40]';
        $rules['url'] = 'trim';
        $rules['uri'] = 'trim';
        $rules['module_name'] = 'trim|alpha_dash';
        $rules['page_id'] = 'trim|numeric';
        $rules['navigation_group_id'] = 'trim|numeric|required';
        $rules['position'] = 'trim|numeric|required';
        
        $this->validation->set_rules($rules);
        
        $fields['module_name'] = 'Module';
        $fields['page_id'] = 'Page';
        $fields['navigation_group_id'] = 'Group';
        $this->validation->set_fields($fields);
    
        foreach(array_keys($rules) as $field) {
        	$this->data->navigation_link->$field = (isset($_POST[$field])) ? $this->validation->$field : '';
        }
        
        if ($this->validation->run()) {
        	
            if ($this->input->post('btnSave')) {
                $this->navigation_m->newLink($_POST);
                $this->session->set_flashdata('success', 'The navigation link was added.');
               
            } else {
            	$this->session->set_flashdata('error', 'An unexpected error occurred.');
            }
            redirect('admin/navigation/index');
        }
        
        $this->layout->create('admin/links/form', $this->data);
    }

    // Admin: Edit a Page
    function edit($id = 0) {
    	
    	if (empty($id)) redirect('admin/navigation/index');
        
        $this->data->navigation_link = $this->navigation_m->getLink( $id );
        if (!$this->data->navigation_link) 
        {
        	$this->session->set_flashdata('error', 'This navigation link does not exist.');
        	redirect('admin/navigation/create');
        }

        $this->load->library('validation');
        $rules['title'] = 'trim|required|max_length[40]';
        $rules['url'] = 'trim';
        $rules['uri'] = 'trim';
        $rules['module_name'] = 'trim|alpha_dash';
        $rules['page_id'] = 'trim|numeric';
        $rules['navigation_group_id'] = 'trim|numeric|required';
        $rules['position'] = 'trim|numeric|required';
        
        $this->validation->set_rules($rules);
        
        $fields['module_name'] = 'Module';
        $fields['page_id'] = 'Page';
        $fields['navigation_group_id'] = 'Group';
        $this->validation->set_fields($fields);

        foreach(array_keys($rules) as $field) {
        	if(isset($_POST[$field]))
        		$this->data->navigation_link->$field = $this->validation->$field;
        }
        
        if ($this->validation->run()) {
            if ($this->input->post('btnSave')) {
            	$this->navigation_m->updateLink($id, $_POST);
                $this->session->set_flashdata('success', 'The navigation link was saved.');
            } else {
            	$this->session->set_flashdata('error', 'An error occurred.');
            }
            redirect('admin/navigation/index');
        }

        $this->layout->create('admin/links/form', $this->data);
    }
    
    // Admin: Delete Pages
    function delete($id = 0) {
		
		// Delete one
		if($id):
			$this->navigation_m->deleteLink($id);
		
		// Delete multiple
		else:
		
			foreach (array_keys($this->input->post('delete')) as $id):
				$this->navigation_m->deleteLink($id);
			endforeach;
			
		endif;

		$this->session->set_flashdata('success', 'The navigation link has been deleted.');
		redirect('admin/navigation/index');
    }

}

?>