<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Ajax controller for the widgets module
 *
 * @package 		PyroCMS
 * @subpackage 		Widgets
 * @category 		Modules
 * @author			PyroCMS Development Team
 */
class Ajax extends MY_Controller
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
	public function update_order($to = 'instance')
	{
		$ids = explode(',', $this->input->post('order'));

		$i = 0;

		switch ($to)
		{
			case 'instance':
				foreach ($ids as $id)
				{
					$this->widgets->update_instance_order($id, ++$i);
				}
				break;

			case 'widget':
				foreach ($ids as $id)
				{
					$this->widgets->update_widget_order($id, ++$i);
				}
				break;
		}

		$this->pyrocache->delete_all('widget_m');
	}
}