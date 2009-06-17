<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Staff extends Public_Controller 
{
	function __construct() 
	{
		parent::Public_Controller();
		$this->load->model('staff_m');
		$this->lang->load('staff');
	}
	
	function index()
	{
		$this->load->helper('string'); 
		$this->load->helper('text');	
	 	$this->data->staffs = $this->staff_m->getStaff();
	 	$this->layout->create('index', $this->data);
	}
	
	function view($slug='')
	{
		$this->load->helper('text');
		$this->load->helper('typography');

		if(empty($slug) or !$this->data->staff = $this->staff_m->getStaff(array('slug'=>$slug)) )
		{
			redirect('staff');
		}
		
	 	$this->layout->title( $this->data->staff->name, $this->lang->line('staff_title'));
    $this->layout->create('view', $this->data);
	}
}


?>