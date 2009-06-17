<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Suppliers extends Public_Controller
{
	function __construct()
	{
		parent::Public_Controller();
		$this->load->model('suppliers_m');
	}
	
	function index()
	{
		$this->data->suppliers = $this->suppliers_m->getSuppliers();
		$this->layout->create('index', $this->data);
	}
	
	function category($category = '')
	{
		if (empty($category)) redirect('suppliers/index');
				
		$this->data->suppliers = $this->suppliers_m->getSuppliers($category);
		$this->layout->create('index', $this->data);	
	}

}

?>