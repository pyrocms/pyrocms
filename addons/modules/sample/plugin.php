<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a sample module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	Sample Module
 */
class Plugin_Sample extends Plugin
{
	/**
	 * Item List
	 * Usage:
	 * 
	 * {pyro:sample:items limit="5" order="asc"}
	 *      {id} {name} {slug}
	 * {/pyro:sample:items}
	 *
	 * @return	array
	 */
	function items()
	{
		$limit = $this->attribute('limit');
		$order = $this->attribute('order');
		
		return $this->db->order_by('name', $order)
						->limit($limit)
						->get('sample_items')
						->result_array();
	}
}

/* End of file plugin.php */