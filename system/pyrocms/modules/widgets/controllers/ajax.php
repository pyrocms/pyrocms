<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Ajax controller for the widgets module
 *
 * @package 		PyroCMS
 * @subpackage 		Widgets
 * @category 		Modules
 * @author			Phil Sturgeon - PyroCMS Development Team
 */
class Ajax extends CI_Controller
{
	/**
	 * Constructor method
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		// Call the parent's constructor method
		parent::__construct();

		// Load the required classes
		$this->load->library('widgets');
		$this->lang->load('widgets');
	}

	/**
	 * Update the order of the widgets
	 * @access public
	 * @return void
	 */
	public function update_order()
	{
		$ids = explode(',', $this->input->post('order'));

		$i = 1;

		foreach ($ids as $id)
		{
			$this->widgets->update_instance_order($id, ++$i);
		}

		$this->pyrocache->delete_all('widget_m');
	}
}