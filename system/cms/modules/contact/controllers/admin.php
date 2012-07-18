<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * The admin controller for the Contact module.
 *
 * @author PyroCMS Dev Team
 * @package	 PyroCMS\Core\Modules\Contact\Controllers
 */
class Admin extends Admin_Controller
{

	/**
	 * Shows the contact messages list.
	 */
	public function index()
	{
		$this->load->language('contact');
		$this->load->model('contact_m');

		$this->template
			->set('contact_log', $this->contact_m->order_by('sent_at', 'desc')
			->get_log())
			->build('index');
	}

}