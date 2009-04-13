<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller {

    function __construct() {
        parent::Admin_Controller();
        $this->load->module_model('services', 'services_m');
        
        $this->data->pay_per_options = array(
        	'' 		=>	'one off', 
			'hour'	=>	'per Hour',
			'day'	=>	'per Day',
			'week'	=>	'per Week',
			'month'	=>	'per Month',
			'year'	=>	'per Year'
       	);
    }

    function index() {
        $this->load->helper('text');
		
        // Create pagination links
    	$total_rows = $this->services_m->countServices();
    	$this->data->pagination = create_pagination('admin/suppliers/index', $total_rows);

    	// Using this data, get the relevant results
    	$this->data->services = $this->services_m->getServices(array('limit' => $this->data->pagination['limit']));

    	$this->layout->create('admin/index', $this->data);
    }
    
    // Admin: Create a New Service
    function create() {
        $this->load->library('validation');
        $rules['title'] = 'trim|required|callback__createTitleCheck';
        $rules['description'] = 'trim|required';
        $rules['price'] = 'trim|is_numeric';
        $rules['pay_per'] = 'trim';
        $this->validation->set_rules($rules);
        $this->validation->set_fields();
        
        $config = array('name'=>'description', 'content'=>$this->validation->description);
        $this->load->library('spaw', $config);
		// setting directories for a SPAW editor instance:
		$this->spaw->setConfigItem(
			'PG_SPAWFM_DIRECTORIES',
			  array(
			    array(
			      'dir'     => '/uploads/services/flash/',
			      'caption' => 'Flash movies', 
			      'params'  => array(
			        'allowed_filetypes' => array('flash')
			      )
			    ),
			    array(
			      'dir'     => '/uploads/services/images/',
			      'caption' => 'Images',
			      'params'  => array(
			        'default_dir' => true, // set directory as default (optional setting)
			        'allowed_filetypes' => array('images')
			      )
			    ),
			  ),
			  SPAW_CFG_TRANSFER_SECURE
		);
        
        if ($this->validation->run()) {
        	
            if ($this->services_m->newService($_POST))
            {
                $this->session->set_flashdata('success', 'The service "'.$this->input->post('title').'" was added.');
            } 
            
            else
            {
                $this->session->set_flashdata('error', 'An error occured.');
            }
            
            redirect('admin/services/index');
        }
        
        foreach(array_keys($rules) as $field)
		{
        	$this->data->service->$field = (isset($_POST[$field])) ? $this->validation->$field : '';
        }
        
        $this->layout->create('admin/form', $this->data);
    }
    
    // Admin: Edit a Service
    function edit($slug = '') {
		
    	// No service to edit
        if (!$slug) redirect('admin/services/index');
            
        $this->load->library('validation');
        $rules['title'] = 'trim|required';
        $rules['description'] = 'trim|required';
        $rules['price'] = 'trim|is_numeric';
        $rules['pay_per'] = 'trim';
        $this->validation->set_rules($rules);
        $this->validation->set_fields();

        $this->data->service = $this->services_m->getService($slug);

        // Override the database value for each populated field
        foreach(array_keys($rules) as $field) {
        	if(isset($_POST[$field]))
        	$this->data->service->$field = $this->validation->$field;
        }

        $spaw_cfg = array('name'=>'description', 'content'=>$this->data->service->description);
        $this->load->library('spaw', $spaw_cfg);
        // setting directories for a SPAW editor instance:
        $this->spaw->setConfigItem(
			'PG_SPAWFM_DIRECTORIES',
	        array(
		        array(
			    	'dir'     => '/uploads/services/flash/',
			    	'caption' => 'Flash movies', 
			     	'params'  => array(
			        'allowed_filetypes' => array('flash')
		        	)
		        ),
		        array(
			    	'dir'     => '/uploads/services/images/',
			    	'caption' => 'Images',
			    	'params'  => array(
			    	'default_dir' => true, // set directory as default (optional setting)
			        'allowed_filetypes' => array('images')
		        	)
		        ),
	        ),
	        SPAW_CFG_TRANSFER_SECURE
        );

        if ($this->validation->run()) {
        	if ($this->services_m->updateService($_POST, $slug)) {
        		$this->session->set_flashdata(array('success'=>'The service "'.$this->input->post('title').'" was saved.'));
        		redirect('admin/services/index', $this->data);

        	} else {
        		$this->session->set_flashdata(array('error'=>'An error occurred.'));
        	}
        }
        
        $this->layout->create('admin/form', $this->data);
    }
    
    // Admin: Delete a Service
    function delete($slug = '') {
		
		 // Delete one
		if($slug):
			$this->services_m->deleteService($slug);
		
		// Delete multiple
		else:
			foreach (array_keys($this->input->post('delete')) as $slug)
			{
				$this->services_m->deleteService($slug);
			}
		endif;

        $this->session->set_flashdata('success', 'The service(s) were deleted.');
		redirect('admin/services/index');
    }
    
    // Callback: from create()
    function _createTitleCheck($title = '') {
        if ($this->services_m->checkTitle($title)) {
            $this->validation->set_message('_createTitleCheck', 'A service with the name "'.$title.'" already exists.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

?>