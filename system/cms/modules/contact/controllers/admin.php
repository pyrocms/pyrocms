<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 * @author 		Phil Sturgeon - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Comments
 * @category 	Module
 */
class Admin extends Admin_Controller {
	
	public function index()
	{
		$this->load->language('contact');
		$this->load->model('contact_m');
		
		$data['contact_log'] = $this->contact_m->order_by('sent_at', 'desc')->get_log();
		
		$this->template->build('index', $data);
	}
	
}