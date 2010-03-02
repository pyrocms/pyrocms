<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package 		PyroCMS
 * @subpackage 		Widgets module
 * @author			Phil Sturgeon - PyroCMS Development Team
 * 
 * Model to handle widgets
 */
class Widgets_m extends MY_Model
{

	function get_by_area($slug)
	{
		$this->_select_instances();

		$this->db->where('wa.slug', $slug);

		return $this->db->get()->result();
	}
	
	private function _select_instances()
	{
		$this->db->select('wi.id, w.slug, w.title, wi.title as instance_title, wi.widget_area_id, wi.data')
			->from('widget_areas wa')
			->join('widget_instances wi', 'wa.id = wi.widget_area_id')
			->join('widgets w', 'wi.widget_id = w.id');
	}
	
	public function insert_area($input)
	{
		return $this->db->insert('widget_areas', array(
			'title' => $input['title'],
			'slug' => $input['slug']
		));
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
}