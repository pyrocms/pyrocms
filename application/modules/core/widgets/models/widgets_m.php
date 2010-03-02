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
}