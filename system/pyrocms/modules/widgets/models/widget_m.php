<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package 		PyroCMS
 * @subpackage 		Widgets module
 * @author			Phil Sturgeon - PyroCMS Development Team
 * 
 * Model to handle widgets
 */
class Widget_m extends MY_Model
{

	function get_instance($id)
	{
		$this->db->select('w.id, w.slug, wi.id as instance_id, wi.title as instance_title, w.title, wi.widget_area_id, wa.slug as widget_area_slug, wi.options')
			->from('widget_areas wa')
			->join('widget_instances wi', 'wa.id = wi.widget_area_id')
			->join('widgets w', 'wi.widget_id = w.id')
			->where('wi.id', $id);

		return $this->db->get()->row();
	}
	
	function get_by_area($slug)
	{
		$this->db->select('wi.id, w.slug, wi.id as instance_id, wi.title as instance_title, w.title, wi.widget_area_id, wa.slug as widget_area_slug, wi.options')
			->from('widget_areas wa')
			->join('widget_instances wi', 'wa.id = wi.widget_area_id')
			->join('widgets w', 'wi.widget_id = w.id')
			->where('wa.slug', $slug)
			->order_by('wi.order');

		return $this->db->get()->result();
	}
	
	public function get_areas()
	{
		return $this->db->get('widget_areas')->result();
	}
	
	public function get_area_by($field, $id)
	{
		return $this->db->get_where('widget_areas', array($field => $id))->row();
	}
	
	public function get_widget_by($field, $id)
	{
		return $this->db->get_where('widgets', array($field => $id))->row();
	}
	
	public function insert_widget($input)
	{
		return $this->db->insert('widgets', array(
			'title' 		=> $input['title'],
			'slug' 			=> $input['slug'],
			'description' 	=> $input['description'],
			'author' 		=> $input['author'],
			'website' 		=> $input['website'],
			'version' 		=> $input['version']
		));
	}
	
	public function insert_area($input)
	{
		return $this->db->insert('widget_areas', array(
			'title' => $input['title'],
			'slug' 	=> $input['slug']
		));
	}
	
	public function update_area($input)
	{		
		$this->db->where('slug', $input['area_slug'])
				->update('widget_areas', array('title' => $input['title'],
								'slug' => $input['slug'] 
				));
		$result = $this->db->affected_rows();
		
		return ($result > 0) ? TRUE : FALSE;
	}
	
	public function insert_instance($input)
	{
		$this->load->helper('date');
		
		$last_widget = $this->db->select('`order`')
			->order_by('`order`', 'desc')
			->limit(1)
			->get_where('widget_instances', array('widget_area_id' => $input['widget_area_id']))
			->row();
			
		$order = isset($last_widget->order) ? $last_widget->order + 1 : 1;
		
		return $this->db->insert('widget_instances', array(
			'title' => $input['title'],
			'widget_id' => $input['widget_id'],
			'widget_area_id' => $input['widget_area_id'],
			'options' => $input['options'],
			'`order`' => $order,
			'created_on' => now(),
			'updated_on' => now()
		));
	}
	
	public function update_instance($instance_id, $input)
	{
		$this->db->where('id', $instance_id);
		
		return $this->db->update('widget_instances', array(
        	'title' => $input['title'],
			'widget_area_id' => $input['widget_area_id'],
			'options' => $input['options']
		));
	}
	
	function update_instance_order($id, $order) 
	{
		$this->db->where('id', $id);
		
		return $this->db->update('widget_instances', array(
        	'`order`' => (int) $order
		));
	}
	
	function delete_widget($slug) 
	{
		$widget = $this->db->select('id')->get_where('widgets', array('slug' => $slug))->row();
		
		if(isset($widget->id))
		{
			$this->db->delete('widget_instances', array('widget_id' => $widget->id));
		}
		
		return $this->db->delete('widgets', array('slug' => $slug));
	}
	
	public function delete_area($slug)
	{
		// Get the id for this area
		$area = $this->db->select('id')->get_where('widget_areas', array('slug' => $slug))->row();
		
		if(isset($area->id))
		{
			// Delete widgets in that area
			$this->db->delete('widget_instances', array('widget_area_id' => $area->id));
			
			// Delete this area
			return $this->db->delete('widget_areas', array('id' => $area->id));
		}
		
		return TRUE;
	}
	
	function delete_instance($id) 
	{
		return $this->db->delete('widget_instances', array('id' => $id));
	}
}