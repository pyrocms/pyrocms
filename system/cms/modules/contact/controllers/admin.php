<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Contact\Controllers
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