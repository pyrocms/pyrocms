<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Services extends Public_Controller
{
	function __construct()
	{
		parent::Public_Controller();
		$this->load->model('services_m');
		$this->lang->load('services');
	}
	
	// Public: View a list of services
	function index()
	{
		$this->load->helper('text');
		$this->data->services = $this->services_m->getServices();
		$this->layout->create('index', $this->data);
	}
	
	// Public: View a particular service
	function view($slug = '')
	{
		if (!$slug) redirect('services/index');
		$this->data->service = $this->services_m->getService($slug);
		
		$this->layout->title( $this->data->service->title, $this->lang->line('service_title'));
		$this->layout->create('view', $this->data);
	}
}
?>