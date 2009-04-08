<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Staff_m extends Model {

	function __construct() {
		parent::Model();
	}

	function getStaff( $params = array() ) {
		
		$this->db->select('s.slug, s.user_id, s.fact, s.body, s.filename, s.position, s.updated_on, 
    						IF(u.id > 0, IF(u.last_name = "", u.first_name, CONCAT(u.first_name, " ", u.last_name)), s.name) as name, 
    						IF(u.id > 0, u.email, s.email) as email', FALSE);
    	
    	$this->db->join('users u', 's.user_id = u.id', 'left');
    	
		if (empty($params['slug'])) {
			
			// Limit the results based on 1 number or 2 (2nd is offset)
			if(isset($params['limit']) && is_int($params['limit'])) $this->db->limit($params['limit']);
			elseif(isset($params['limit']) && is_array($params['limit'])) $this->db->limit($params['limit'][0], $params['limit'][1]);
        
			$query = $this->db->get('staff as s');

			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return FALSE;
			}
		} else {
			$query = $this->db->getwhere('staff as s', $params);
			if ($query->num_rows() > 0) {
				return $query->row();
			} else {
				return FALSE;
			}
		}
	}

    function countStaff($params = array())
    {
		return $this->db->count_all_results('staff');
    }
    
	function newStaff($input = array(), $photo) {
		$this->load->helper('date');

		if(empty($input['user_id'])):
			$name = ucwords(strtolower($input['name']));
			$email = $input['email'];
			$slug = url_title($name);
			$user_id = 0;			
		else:
			$name = '';
			$email = '';
			$slug = $input['user_id'];
			$user_id = $input['user_id'];
		endif;
		
		$position = $input['position'];
		$body = $input['body'];
		$fact = $input['fact'];
		$filename = $photo['file_name'];

		$this->db->insert('staff', array(
			'slug'=>$slug,
			'user_id'=>$user_id,
			'name'=>$name,
			'email'=>$email,
			'position'=>$position,
			'fact'=>$fact,
			'body'=>$body,
			'filename'=>$filename,
			'updated_on'=>now()
		));

        return $this->db->insert_id();
	}

	function updateStaff($slug = '', $input = array()) {

		$this->load->helper('date');
		
		$db_array = array(
			"position"		=>	$input['position'],
			"body"			=>	$input['body'],
			"fact"			=>	$input['fact'],
			"updated_on"	=>	now()
		);
	
		if(!empty($input['name'])) {
			$db_array['name'] = ucwords(strtolower($input['name']));
		}
		
		if(!empty($input['email'])) {
			$db_array['email'] = $input['email'];
		}
		
		if (isset($input['filename'])) {
			$db_array['filename'] = $input['filename'];
		}
		
		$this->db->update("staff", $db_array, array("slug"=>$slug));

	}
	
	function deleteStaff($slug) {
		$this->db->delete('staff', array('slug'=>$slug));
		return $this->db->affected_rows();
	}

}

?>