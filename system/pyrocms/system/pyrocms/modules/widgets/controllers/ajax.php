<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Ajax controller for the widgets module
 *
 * @package 		PyroCMS
 * @subpackage 		Widgets
 * @category 		Modules
 * @author			Phil Sturgeon - PyroCMS Development Team
 */
class Ajax extends Admin_Controller
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
	 * Add a new widget area
	 * @access public
	 * @return void
	 */
	public function add_widget_area()
	{
		$data->widget_area->title 	= $this->input->post('area_title');
		$data->widget_area->slug 	= $this->input->post('area_slug');
		
		$this->widgets->add_area($data->widget_area);
		
		$this->load->view('admin/ajax/add_area', $data);
	}
	
	/**
	 * Delete an existing widget area
	 * @access public
	 * @return void
	 */
	public function delete_widget_area()
	{
		$slug = $this->input->post('area_slug');
		$this->widgets->delete_area($slug);
	}
	
	/**
	 * Create the form for a new widget instance
	 * @access public
	 * @return void
	 */
	public function add_widget_instance_form()
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
	
	/**
	 * Add a new widget instance
	 * @access public
	 * @return void
	 */
	public function add_widget_instance()
	{
		$title 			= $this->input->post('title');
		$widget_id 		= $this->input->post('widget_id');
		$widget_area_id = $this->input->post('widget_area_id');
		
		$options 		= $_POST;
		unset($options['title'], $options['widget_id'], $options['widget_area_id']);
		
		$result 		= $this->widgets->add_instance($title, $widget_id, $widget_area_id, $options);
		
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
	
	/**
	 * Create the form for editing a widget instance
	 * @access public
	 * @return void
	 */
	public function edit_widget_instance_form()
	{
		$instance_id = $this->input->post('instance_id');
		
		if(!$instance_id)
		{
			exit();
		}
		
		$widget = $this->widgets->get_instance($instance_id);
		$widget_area = $this->widgets->get_area($widget->widget_area_slug);
		
		$widget_areas = $this->widgets->list_areas();
		$widget_areas = array_for_select($widget_areas, 'id', 'title');
		
		$this->load->view('admin/ajax/instance_form', array(
			'widget' => $widget,
			'widget_area' => $widget_area,
			'widget_areas' => $widget_areas
		));
	}
	
	/**
	 * Edit a widget instance
	 * @access public
	 * @return void
	 */
	public function edit_widget_instance()
	{
		$instance_id 		= $this->input->post('widget_instance_id');
		$title 				= $this->input->post('title');
		$widget_id 			= $this->input->post('widget_id');
		$widget_area_id 	= $this->input->post('widget_area_id');
		
		$options 			= $_POST;
		unset($options['title'], $options['widget_id'], $options['widget_area_id'], $options['widget_instance_id']);
		
		$result 			= $this->widgets->edit_instance($instance_id, $title, $widget_area_id, $options);
		
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
	
	/**
	 * Delete a widget instance
	 * @access public
	 * @return void
	 */
	public function delete_widget_instance()
	{
		$instance_id = $this->input->post('instance_id');
		$this->widgets->delete_instance($instance_id);
	}
	
	/**
	 * List all available widgets
	 * @access public
	 * @param str $slug The slug of the widget
	 * @return void
	 */
	function list_widgets($slug)
	{
		$widgets = $this->widgets->list_area_instances($slug);
		$this->load->view('admin/ajax/instance_list', array('widgets' => $widgets));
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
		
		foreach($ids as $id)
		{
			$this->widgets->update_instance_order($id, $i);
			++$i;
		}
		
		$this->cache->delete_all('widget_m');
	}
	
	/**
	 * Edit widget area
	 * @access public
	 * @return void
	 */
	public function edit_widget_area()
	{
		$area = $this->input->post('area_id');
		$title = $this->input->post('title');
		$slug = $this->input->post('slug');
		
		$edit = $this->widgets->edit_area(array('area_slug' => $area,
						'title' => ucwords($title),
						'slug' => $slug
						));
		$status = 'error';
		
		if($edit)
		{
			$status = 'success';
		}
		
		echo json_encode(array('status' => $status, 'find' => $area, 'replace' => $slug, 'title' => ucwords($title)));
	}
}
?>