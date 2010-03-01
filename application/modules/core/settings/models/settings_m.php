<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Settings_m extends Model {

    function __construct() {
        parent::Model();
    }
    
	function get($slug = '') {
        $this->db->select('slug, type, IF(`value` = "", `default`, `value`) as `value`', FALSE);
		$query = $this->db->get_where('settings', array('slug'=>$slug));
		
		if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->row();
        }
    }
    
    function get_all()
    {
    	$this->db->select('slug, type, IF(`value` = "", `default`, `value`) as `value`', FALSE);
		return $this->db->get('settings')->result();
    }
    
	function getSettings($params = array()) {
        $this->db->select('slug, type, title, description, `default`, `options`, IF(`value` = "", `default`, `value`) as `value`, is_required, module', FALSE);
		$query = $this->db->get_where('settings', $params);
		
		if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }
    
	function update($slug = '', $params = array()) {
		$this->db->update('settings', $params, array('slug'=>$slug));
		return true;
    }
    
    function sections()
    {
    	$this->db->select('module');
    	$this->db->distinct();
    	$this->db->where('module != ""');

    	$query = $this->db->get('settings');
		
		if ($query->num_rows() == 0) {
            return FALSE;
        }
    	
        $sections = array();
	    
	    foreach($query->result() as $section)
	    {
	    	$sections[$section->module] = ucfirst($section->module);
	    }
	    
	    return $sections;
    }
}

?>