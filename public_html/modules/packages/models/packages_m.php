<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Packages_m extends Model {

    function __construct() {
        parent::Model();
    }
    
    function checkTitle($title = '') {
        $this->db->select('COUNT(title) AS total');
        $query = $this->db->getwhere('packages', array('slug'=>url_title($title)));
        $row = $query->row();
        if ($row->total == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function getPackage($slug = '') {
        $query = $this->db->getwhere('packages', array('slug'=>$slug));
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->row();
        }
    }
    
    function getPackages($params = array()) {
    	
       	// Limit the results based on 1 number or 2 (2nd is offset)
       	if(isset($params['limit']) && is_int($params['limit'])) $this->db->limit($params['limit']);
    	elseif(isset($params['limit']) && is_array($params['limit'])) $this->db->limit($params['limit'][0], $params['limit'][1]);
    	
        $query = $this->db->get('packages');
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }
  
    function countPackages($params = array())
    {
		return $this->db->count_all_results('packages');
    }
    
    function newPackage($input = array()) {
    	$this->load->helper('date');

    	$this->db->insert('packages', array(
    		'title'			=>	$input['title'],
    		'slug'			=>	url_title($input['title']), 
    		'description'	=>	$input['description'],
    		'featured'		=>	isset($input['featured']) ? 'Y' : 'N',
    		'updated_on'	=>	now()
    	));
    	
    	return TRUE; // No automatic id - $this->db->insert_id();
    }
    
    function updatePackage($input, $old_slug) {
    	$this->load->helper('date');

    	return $this->db->update('packages', array(
            'title'			=>	$input['title'],
            'slug'			=>	url_title($input['title']),
            'description'	=>	$input['description'],
            'updated_on'	=>	now()
    	), array('slug'=>$old_slug));
    }
    
    function updateFeatured($featured = array()) {
        $this->db->update('packages', array('featured'=>'N'), array('featured'=>'Y'));
        if (!empty($featured)) {
            foreach ($featured as $slug => $value) {
                $this->db->orwhere('slug', $slug);
            }
            $this->db->update('packages', array('featured'=>'Y'));
        }
    }

	function deletePackage($slug = '') {
        $this->db->delete('packages', array('slug'=>$slug));
        return $this->db->affected_rows();
    }

}

?>