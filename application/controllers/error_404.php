<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Error_404 extends Public_Controller {

    function index() {
    	
    	$this->lang->load('errors');
    	
    	set_status_header(404);
    	
    	$this->template->title( $this->lang->line('error_404_title') )
    		->set_breadcrumb( $this->lang->line('error_404_title'))
    		->build('../errors/error_404', $this->data);
	}
}

?>