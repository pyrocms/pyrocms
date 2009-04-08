<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Suppliers_m extends Model {

    function __construct() {
        parent::Model();
    }
    
    function getSupplier($slug = '') {
        $this->db->select('suppliers.*');
        $query = $this->db->getwhere('suppliers', array('suppliers.slug'=>$slug));
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    function getSuppliers($params = '') {

    	$this->db->select('suppliers.*');
    	$this->db->order_by('title', 'asc');
    	
    	// Limit the results based on 1 number or 2 (2nd is offset)
       	if(isset($params['limit']) && is_int($params['limit'])) $this->db->limit($params['limit']);
    	elseif(isset($params['limit']) && is_array($params['limit'])) $this->db->limit($params['limit'][0], $params['limit'][1]);
        
    	if(!empty($params['category'])) $this->db->where('suppliers.category_id', $category);
    	
    	$query = $this->db->get('suppliers');
        
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    function countSuppliers($params = array())
    {
		return $this->db->count_all_results('suppliers');
    }
    
    function newSupplier($input = array()) {
        $this->load->helper('date');
        
        $slug = url_title($input['title']);
        
        $this->db->insert('suppliers', array(
        	'slug'			=>	$slug,
        	'title'			=>	$input['title'],
        	'description'	=>	$input['description'],
        	'url'			=>	$input['url'],
			'image'			=>	$input['image'],
        	'updated_on'	=>	now()
        ));
        
        $id = $this->db->insert_id();
        
		if($id)
		{
	        foreach ($input['category'] as $category => $val) {
	            $this->db->insert('suppliers_categories', array( 'supplier_id' => $id, 'category_id' => $category ));
	        }
		}
        
        return $id;
    }
    
    function updateSupplier($id = '', $input = array()) {
        $this->load->helper('date');

		$db_array = array(
			"description"	=>	$input['description'],
			"url"			=>	$input['url'],
			'updated_on'	=>  now()
		);
	
		if(!empty($input['image'])) {
			$db_array['image'] = $input['image'];
		}

        $this->db->update('suppliers', $db_array, array('id'=>$id));
        
        $this->db->delete('suppliers_categories', array('supplier_id'=>$id));
        foreach ($input['category'] as $category => $val) {
            $this->db->insert('suppliers_categories', array('supplier_id'=>$id, 'category_id'=> $category ));
        }
    }
    
    function deleteSupplier($id) {
        $this->db->delete('suppliers', array('id'=>$id));
        $this->db->delete('suppliers_categories', array('supplier_id'=>$id));
		return $this->db->affected_rows();
    }

	function getCategoryies($id) {
		$this->db->select('category_id');
        $query = $this->db->getwhere('suppliers_categories', array('supplier_id'=> $id));
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
	}

}

?>