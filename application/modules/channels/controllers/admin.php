<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 2.0
 * @filesource
 */

/**
 * Admin controller for the Channels module
 * 
 * @author 		Dan Horrigan <dan@dhorrigan.com>
 * @package 	PyroCMS
 * @subpackage 	Channels
 */
class Admin extends Admin_Controller
{

	/**
	 * Construct
	 */
	public function __construct()
	{
		parent::Admin_Controller();
		// TODO: Add Constructor Code
	}

	/**
	 * Index
	 *
	 * @access public
	 * @return void
	 */
	public function index()
	{
		// TODO: Write logic to get all channels.
		$this->template->build('admin/index', $this->data);
	}

}

/* End of file admin.php */