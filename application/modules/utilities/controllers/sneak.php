<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// This does sod all right now, will finish it one day (perhaps)

class Sneak extends Controller
{
	function __construct() {
    	parent::Controller();
    	
        $this->load->library('session');
		$this->load->library('users/user_lib');
		
		$this->load->library('proxy', 'utilities/sneak/fetch');
		
		if(!$this->user_lib->logged_in())
		{
			redirect('users/login');
		}
		
	}

    function index($domain = '') {
    	
    	$this->data->url = str_replace('url=', '', $_SERVER['QUERY_STRING']);
    	$this->load->view('sneak/frameset', $this->data);
    	
	}
	
    function topnav($hash = '') {
    	
		$this->data->url = base64_decode($hash);
    	$this->load->view('sneak/topnav', $this->data);
    	
	}
	
	function fetch($hash = '')
	{
		if(!$hash) {
			if($this->input->post('url')) $hash = $this->input->post('url');
			elseif($this->input->get('url')) $hash = $this->input->get('url');
		}
		
		$this->proxy->query($hash, $_POST, $_GET, $_FILES, $this->input->post('c'));
        
    	$this->proxy->getPage(); 
	}
}

?>