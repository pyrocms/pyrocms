<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Categories_m extends Model
{
	function get_many($params = array())
	{
		// Limit the results based on 1 number or 2 (2nd is offset)
       	if(isset($params['limit']) && is_int($params['limit'])) $this->db->limit($params['limit']);
    	elseif(isset($params['limit']) && is_array($params['limit'])) $this->db->limit($params['limit'][0], $params['limit'][1]);
    	
        $this->db->order_by('title', 'asc');
        $query = $this->db->get('categories');
        
        return $query->result();
    }
    
	function get($id = 0) {
        
    	if(is_numeric($id))  $this->db->where('id', $id);
    	else  				 $this->db->where('slug', $id);
		
		return $this->db->get_where('categories')->row();
    }
    
    function count($params = array())
    {
		return $this->db->count_all_results('categories');
    }
    
    function add($input = array())
    {
    	$this->db->insert('categories', array(
        	'slug'=>url_title(strtolower($input['title'])),
        	'title'=>$input['title']
        ));
        
        return $input['title'];
    }
    
    function update($id, $input) {
            
		$this->db->update('categories', array(
            'title'	=> $input['title'],
            'slug'	=> url_title(strtolower($input['title']))
		), array('id' => $id));
            
		return TRUE;
    }
    
    function remove($id)
    {
        $this->db->delete('categories', array('id'=>$id));
        return $this->db->affected_rows();
    }
    
    function check_title($title = '')
    {
        $this->db->select('COUNT(title) AS total');
        $query = $this->db->get_where('categories', array('slug'=>url_title($title)));
        $row = $query->row();
        if ($row->total == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}

?>
