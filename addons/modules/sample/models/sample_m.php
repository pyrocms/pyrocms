<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a sample module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	Sample Module
 */
class Sample_m extends MY_Model {

	public function __construct()
	{
		parent::__construct();
	}

	//get all items
	public function get_items()
	{
		return $this->db
					->order_by('name', 'asc')
					->get('sample_items')
					->result();
	}
	
	//create a new item
	public function create_item($input)
	{
		$to_insert = array(
			'name' => $input['name'],
			'slug' => $this->_check_slug($input['slug'])
		);

		return $this->db->insert('sample_items', $to_insert);
	}

	//make sure the slug is valid
	public function _check_slug($slug)
	{
		$slug = strtolower($slug);
		$slug = preg_replace('/\s+/', '-', $slug);

		return $slug;
	}
}
