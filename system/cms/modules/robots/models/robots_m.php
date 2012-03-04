<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a Robots module for PyroCMS
 *
 * @author 		Jacob Albert Jolman
 * @website		http://www.odin-ict.nl
 * @package 	PyroCMS
 * @subpackage 	Robots Module
 */
class Robots_m extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		
		$this->_table = 'core_robots';
	}
	
	public function get_robots_txt()
	{
		return $this->query = $this->db->query("SELECT * FROM " . $this->_table. " WHERE site_ref='" . SITE_REF . "';")->row();
	}
	
	public function update_robots_txt($input)
	{
		return $this->query = $this->db->query("UPDATE " . $this->_table . " SET txt='" . $input['txt'] . "' WHERE site_ref='" . SITE_REF . "';");
	}
}
