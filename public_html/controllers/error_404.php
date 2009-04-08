<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Error_404 extends Public_Controller {

    function index() {
    	
    	$this->lang->load('errors');
    	
    	header("HTTP/1.1 404 Not Found");
    	
    	$this->layout->title(lang('error_404_title'));
    	$this->layout->add_breadcrumb(lang('error_404_title'));
    	$this->layout->create('../errors/error_404', $this->data);
	}
}

?>