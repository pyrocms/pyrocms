<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Ajax controller for the widgets module
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Addons\Controllers
 */
class Ajax extends MY_Controller
{
	/**
	 * Update the order of the widgets
	 * 
	 * @return void
	 */
	public function widget_update_order($to = 'instance')
	{
		// Load the required classes
		$this->load->library('widgets');
		$this->lang->load('widgets');

		$ids = explode(',', $this->input->post('order'));

		$i = 0;

		switch ($to)
		{
			case 'instance':
				foreach ($ids as $id)
				{
					$id = str_replace('instance-', '', $id);
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