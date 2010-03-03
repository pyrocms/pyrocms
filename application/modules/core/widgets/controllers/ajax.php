<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
	function __construct()
	{
		parent::Admin_Controller();
		$this->load->library('widgets');
		$this->lang->load('widgets');
	}
	
	function add_widget_area()
	{
		$data->widget_area->title = $this->input->post('area_title');
		$data->widget_area->slug = $this->input->post('area_slug');
		
		$this->widgets->add_area($data->widget_area);
		
		$this->load->view('admin/ajax/new_area', $data);
	}
	
	function delete_widget_area()
	{
		$slug = $this->input->post('area_slug');
		$this->widgets->delete_area($slug);
	}
	
	function show_widget_instance_form()
	{
		if(!$this->input->post('widget_slug') || !$this->input->post('area_slug'))
		{
			exit();
		}
		
		$widget = $this->widgets->get_widget($this->input->post('widget_slug'));
		$widget_area = $this->widgets->get_area($this->input->post('area_slug'));
		
		$this->load->view('admin/ajax/new_instance', array(
			'widget' => $widget,
			'widget_area' => $widget_area,
		));
	}
	
	function add_widget_instance()
	{
		$title = $this->input->post('title');
		$widget_id = $this->input->post('widget_id');
		$widget_area_id = $this->input->post('widget_area_id');
		
		$options = $_POST;
		unset($options['title'], $options['widget_id'], $options['widget_area_id']);
		
		$this->widgets->add_instance($title, $widget_id, $widget_area_id, $options);
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
	
	/*private function _status($status, $message)
	{
		echo json_encode();
	}*/
}
?>