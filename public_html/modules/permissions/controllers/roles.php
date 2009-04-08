<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Roles extends Admin_Controller {

    function __construct() {
        parent::Admin_Controller();
        $this->load->model('permissions_m');
    }

    function index() {
    	redirect('admin/permissions/index');
    }
    
    
    // Admin: Create a new permission role
    function create() {
        
    	$this->load->library('validation');
        $rules['title'] = 'trim|required|max_length[100]';
        $rules['abbrev'] = 'trim|required|max_length[50]';
        $this->validation->set_rules($rules);
        
        $fields['abbrev'] = 'abbreviaion';
        $this->validation->set_fields($fields);
    
        foreach(array_keys($rules) as $field) {
        	$this->data->permission_role->$field = (isset($_POST[$field])) ? $this->validation->$field : '';
        }
        
        if ($this->validation->run()) {
            if ($this->input->post('btnSave')) {
                $this->permissions_m->newRole($_POST);
                $this->session->set_flashdata('success', 'The permission role has been saved.');
                
            } else {
            	$this->session->set_flashdata('error', 'An error occurred.');
            }
            redirect('admin/permissions/index');
        }
        
        $this->layout->create('admin/roles/form', $this->data);
    }
    

    // Admin: Edit a permission role
    function edit($id = 0) {

    	if (empty($id)) redirect('admin/permissions/index');
        
        $this->data->permission_role = $this->permissions_m->getRole( $id );
        if (!$this->data->permission_role) 
        {
        	$this->session->set_flashdata('error', 'This permission role does not exist.');
        	redirect('admin/permissions/roles/create');
        }

        $this->load->library('validation');
        $rules['title'] = 'trim|required|max_length[100]';
        $this->validation->set_rules($rules);
        $this->validation->set_fields();

        foreach(array_keys($rules) as $field) {
        	if(isset($_POST[$field]))
        		$this->data->permission_role->$field = $this->validation->$field;
        }
        
        if ($this->validation->run()) {
            if ($this->input->post('btnSave')) {
            	$this->permissions_m->updateRole($id, $_POST);
                $this->session->set_flashdata('success', 'The permission role was saved.');
            } else {
            	$this->session->set_flashdata('error', 'An error occurred.');
            }
            redirect('admin/permissions/index');
        }

        $this->layout->create('admin/roles/form', $this->data);
    }
    
    // Admin: Delete permission role(s)
    function delete($id = 0) {
		
		// Delete one
		if($id):
			$this->permissions_m->deleteRole($id);
	        $this->permissions_m->deleteRule(array('permission_role_id'=>$id));
		
		// Delete multiple
		else:
			foreach (array_keys($this->input->post('delete')) as $id):
	            $this->permissions_m->deleteRole($id);
	            $this->permissions_m->deleteRule(array('permission_role_id'=>$id));
	        endforeach;
	    endif;
	    
	    $this->session->set_flashdata('success', 'The permission role has been deleted.');
        redirect('admin/permissions');
    }
    
}

?>