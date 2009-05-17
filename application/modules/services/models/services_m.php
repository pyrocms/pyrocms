<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Services_m extends Model {

    function __construct() {
        parent::Model();
    }
    
    function checkTitle($title = '') {
        $this->db->select('COUNT(title) AS total');
        $query = $this->db->getwhere('services', array('slug'=>url_title($title)));
        $row = $query->row();
        if ($row->total == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function getService($slug = '') {
        $query = $this->db->getwhere('services', array('slug'=>$slug));
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->row();
        }
    }
    
    function getServices() {
        
    	// Limit the results based on 1 number or 2 (2nd is offset)
    	if(isset($params['limit']) && is_int($params['limit'])) $this->db->limit($params['limit']);
    	elseif(isset($params['limit']) && is_array($params['limit'])) $this->db->limit($params['limit'][0], $params['limit'][1]);
        
    	$query = $this->db->get('services');
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }

    function countServices($params = array())
    {
		return $this->db->count_all_results('services');
    }
    
    function newService($input = array()) {
    	$this->load->helper('date');

    	$this->db->insert('services', array(
            	'title'			=> $input['title'],
            	'slug'			=> url_title($input['title']),
            	'description'	=> $input['description'],
            	'price'			=> (float) $input['price'],
            	'pay_per'		=> $input['pay_per'],
            	'updated_on'	=> now()
    	));
            
        return $this->db->insert_id();
    }
    
    function updateService($input, $old_slug) {
    	$this->load->helper('date');

    	return $this->db->update('services', array(
            'title'			=> $input['title'],
            'slug'			=> url_title($input['title']),
            'description'	=> $input['description'],
            'price'			=> (float) $input['price'],
            'pay_per'		=> $input['pay_per'],
            'updated_on'	=> now()
    	), array('slug'		=> $old_slug));
    }

    function deleteService($id = 0) {
        $this->db->delete('services', array('id'=> $id));
        return $this->db->affected_rows();
    }

}

?>