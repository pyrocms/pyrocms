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

		$this->template
			->set('contact_log', Contact_m::orderBy('sent_at', 'desc')->all())
			->build('index');
	}

}

/* End of file admin.php */