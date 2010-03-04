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
		
		$this->load->view('admin/ajax/add_area', $data);
	}
	
	function delete_widget_area()
	{
		$slug = $this->input->post('area_slug');
		$this->widgets->delete_area($slug);
	}
	
	function add_widget_instance_form()
	{
		if(!$this->input->post('widget_slug') || !$this->input->post('area_slug'))
		{
			exit();
		}
		
		$widget = $this->widgets->get_widget($this->input->post('widget_slug'));
		$widget_area = $this->widgets->get_area($this->input->post('area_slug'));
		
		$this->load->view('admin/ajax/instance_form', array(
			'widget' => $widget,
			'widget_area' => $widget_area
		));
	}
	
	function add_widget_instance()
	{
		$title = $this->input->post('title');
		$widget_id = $this->input->post('widget_id');
		$widget_area_id = $this->input->post('widget_area_id');
		
		$options = $_POST;
		unset($options['title'], $options['widget_id'], $options['widget_area_id'], $options['widget_area_slug']);
		
		$result = $this->widgets->add_instance($title, $widget_id, $widget_area_id, $options);
		
		if($result['status'] == 'success')
		{
			echo json_encode($result);
		}
		
		else
		{
			$data = array(
				'widget' 		=> $this->widgets->get_widget($widget_id),
				'widget_area' 	=> $this->widgets->get_area($widget_area_id),
				'error'			=> $result['error']
			);

			echo json_encode(array('status' => 'error', 'form' => $this->load->view('admin/ajax/instance_form', $data, TRUE)));
		}
	}
	
	function edit_widget_instance_form()
	{
		$instance_id = $this->input->post('instance_id');
		if(!$instance_id)
		{
			exit();
		}
		
		$widget = $this->widgets->get_instance($instance_id);
		$widget_area = $this->widgets->get_area($widget->widget_area_slug);
		
		$this->load->view('admin/ajax/instance_form', array(
			'widget' => $widget,
			'widget_area' => $widget_area,
		));
	}
	
	function edit_widget_instance()
	{
		$instance_id = $this->input->post('widget_instance_id');
		$title = $this->input->post('title');
		$widget_id = $this->input->post('widget_id');
		$widget_area_id = $this->input->post('widget_area_id');
		
		$options = $_POST;
		unset($options['title'], $options['widget_id'], $options['widget_area_id'], $options['widget_area_slug'], $options['widget_instance_id']);
		
		$result = $this->widgets->edit_instance($instance_id, $title, $widget_area_id, $options);
		
		if($result['status'] == 'success')
		{
			echo json_encode($result);
		}
		
		else
		{
			$widget = 
			
			$data = array(
				'widget' 		=> $this->widgets->get_widget($widget_id),
				'widget_area' 	=> $this->widgets->get_area($widget_area_id),
				'error'			=> $result['error']
			);

			echo json_encode(array('status' => 'error', 'form' => $this->load->view('admin/ajax/instance_form', $data, TRUE)));
		}
	}
	
	function delete_widget_instance()
	{
		$instance_id = $this->input->post('instance_id');
		$this->widgets->delete_instance($instance_id);
	}
	
	function list_widgets($slug)
	{
		$widgets = $this->widgets->list_area_instances($slug);
		$this->load->view('admin/ajax/updated_instance_list', array('widgets' => $widgets));
	}
	
	function update_order()
	{
		$ids = explode(',', $this->input->post('order'));
		
		$i = 1;
		
		foreach($ids as $id)
		{
			$this->widgets->update_instance_order($id, $i);
			echo $this->db->last_query();
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