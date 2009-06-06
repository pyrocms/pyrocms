<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Test extends Controller {

    function index() {
    	
    	$this->load->library('db_debug');
    	
        
    	echo $this->db_debug->get('news');
    	
	}
}

?>