<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PyroChunks Admin Controller Class
 *
 * @package  PyroCMS
 * @subpackage  PyroChunks
 * @category  Controller
 * @author  Adam Fairholm
 */ 
class Admin extends Admin_Controller {

	function __construct()
	{
		parent::Admin_Controller();
		
		$this->load->model('chunks_m');
		
		$this->load->language('chunks');
		
		$this->template->set_partial('sidebar', 'admin/sidebar');
	}

	// --------------------------------------------------------------------------

	function index()
	{
		$this->list_chunks();
	}

	// --------------------------------------------------------------------------
	
	/**
	 * List chunks
	 *
	 */
	function list_chunks()
	{
		// -------------------------------------
		// Get chunks
		// -------------------------------------
		
		$this->data->chunks = $this->chunks_m->get_chunks();
		
		// -------------------------------------
			
		$this->template->build('admin/list_chunks', $this->data);
	}

}

/* End of file admin.php */
/* Location: ./third_party/modules/chunks/controllers/admin.php */