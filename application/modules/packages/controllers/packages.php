<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class packages extends Public_Controller
{
	function __construct()
	{
		parent::Public_Controller();
		$this->load->model('packages_m');
		$this->lang->load('packages');
	}
	
	function index()
	{
		$this->load->helper('text');
		$this->data->packages = $this->packages_m->getPackages();
		$this->layout->create('index', $this->data);
	}
	
	// Public: View a package
	function view($slug = '')
	{
		if (!$slug) redirect('packages/index');
		$this->data->package = $this->packages_m->getPackage($slug);
		$this->layout->create('view', $this->data);
	}
}    
?>