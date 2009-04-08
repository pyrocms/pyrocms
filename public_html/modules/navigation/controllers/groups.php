<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends Admin_Controller {

    function __construct() {
        parent::Admin_Controller();
        $this->load->model('navigation_m');
    }

    function index() {
    	redirect('admin/navigation/index');
    }
    
    // Admin: Create a new navigation group
    function create() {
        
    	$this->load->library('validation');
        $rules['title'] = 'trim|required|max_length[50]';
        $rules['abbrev'] = 'trim|required|max_length[20]';
        $this->validation->set_rules($rules);
        $this->validation->set_fields();
        
        if ($this->validation->run()) {
            if ($this->input->post('btnSave')) {
                $this->navigation_m->newGroup($_POST);
                $this->session->set_flashdata('success', 'Your navigation group has been saved.');
                
            } else {
            	$this->session->set_flashdata('error', 'An error occurred.');
            }
            redirect('admin/navigation/index');
        }
        
        $this->layout->create('admin/groups/create', $this->data);
    }
    
    // Admin: Delete navigation group(s)
    function delete($id = 0) {
		
		// Delete one
		if($id):
			$this->navigation_m->deleteGroup($id);
	        $this->navigation_m->deleteLink(array('navigation_group_id'=>$id));
		
		// Delete multiple
		else:
			foreach (array_keys($this->input->post('delete')) as $id):
	            $this->navigation_m->deleteGroup($id);
	            $this->navigation_m->deleteLink(array('navigation_group_id'=>$id));
	        endforeach;
	    endif;
	    
	    $this->session->set_flashdata('success', 'The navigation group has been deleted.');
        redirect('admin/navigation/index');
    }
    
}

?>