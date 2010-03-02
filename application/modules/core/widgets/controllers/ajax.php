<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
	function __construct()
	{
		parent::Admin_Controller();
		$this->load->library('widgets');
	}
	
	function add_widget_area()
	{
		$data->widget_area->title = $this->input->post('area_title');
		$data->widget_area->slug = $this->input->post('area_slug');
		
		$this->widgets->add_area($data->widget_area);
		
		echo $this->load->view('admin/ajax/new_area', $data, TRUE);
	}
	
	function ajax_update_positions()
	{
		$ids = explode(',', $this->input->post('order'));
		
		$i = 1;
		
		foreach($ids as $id)
		{
			$this->widgets_m->update_link_position($id, $i);
			
			++$i;
		}
		
		$this->cache->delete_all('widgets_m');
	}
}
?>