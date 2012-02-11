<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a Robots module for PyroCMS
 *
 * @author 		Jacob Albert Jolman
 * @website		http://www.odin-ict.nl
 * @package 	PyroCMS
 * @subpackage 	Robots Module
 */
class Robots extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('robots_m');
		$this->load->language('robots');
	}
	
	public function index()
	{
		$this->data->robots_txt = $this->robots_m->get_robots_txt();
		
		$this->load->view('robots', $this->data);
	}
}
/* End of file robots.php */