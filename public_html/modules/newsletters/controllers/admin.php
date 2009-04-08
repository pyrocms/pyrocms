<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller {

    function __construct() {
        parent::Admin_Controller();
        $this->load->model('newsletters_m');
        
        $this->newsletters_m->emailFrom = $this->settings->item('contact_email');
    }

    // Admin: Show Newsletters
    function index() {
        
        // Create pagination links
    	$total_rows = $this->newsletters_m->countNewsletters();
    	$this->data->pagination = create_pagination('admin/newsletters/index', $total_rows);

    	// Using this data, get the relevant results
    	$this->data->newsletters = $this->newsletters_m->getNewsletters(array('order'=>'created_on DESC', 'limit' => $this->data->pagination['limit']));
    	
        $this->layout->create('admin/index', $this->data);
    }

    function view($id = 0) {
		
		$this->data->newsletter = $this->newsletters_m->getNewsletter($id);
        if ($this->data->newsletter) {
            $this->layout->create('admin/view', $this->data);
        } else {
            redirect('admin/newsletters/index');
        }
    }
    
    // Admin: Create a new Newsletter
    function create() {
        $this->load->library('validation');
        $rules['title'] = 'trim|required';
        $rules['body'] = 'trim|required';
        $this->validation->set_rules($rules);
        $this->validation->set_fields();
        $config = array('name'=>'body', 'content'=>$this->validation->body);
        $this->load->library('spaw', $config);
		// setting directories for a SPAW editor instance:
		$this->spaw->setConfigItem(
			'PG_SPAWFM_DIRECTORIES',
			  array(
			    array(
			      'dir'     => '/uploads/newsletters/flash/',
			      'caption' => 'Flash movies', 
			      'params'  => array(
			        'allowed_filetypes' => array('flash')
			      )
			    ),
			    array(
			      'dir'     => '/uploads/newsletters/images/',
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
            if ($this->newsletters_m->newNewsletter($_POST)) {
                $this->session->set_flashdata(array('success'=>'Your newsletter was saved.'));
                redirect('admin/newsletters/index');
                return;
            } else {
                $this->session->set_flashdata(array('error'=>'An error occured.'));
                $this->layout->create('admin/create', $this->data);
                return;
            }
        } else {
            $this->layout->create('admin/create', $this->data);
        }
    }
   
    function send($id = 0) {

    	// If the newsletter was sent ok
		if($this->newsletters_m->sendNewsletter($id)) {
			$this->session->set_flashdata(array('success'=>'Your newsletter was sent.'));
		} else {
	    	$this->session->set_flashdata(array('error'=>'An error occured.'));
		}
		
		redirect('admin/newsletters/index');
    }
    
    // Admin: Export
    function export() {
        $this->load->plugin('to_xml');
        to_xml($this->db->get('emails'), 'recipients');
    }
}

?>