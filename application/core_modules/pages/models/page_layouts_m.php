<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Page_layouts_m extends Model
{
	public function get_by_id($id = 0)
    {
    	$this->db->where('id', $id);
    	return $this->db->get('page_layouts')->row();
    }
    
    
    // Return an object of objects containing page layout data
    function get_many($params = array())
    {
        if(!empty($params['order']))
        {
        	$this->db->order_by($params['order']);
        	unset($params['order']);
        }
    
        return $this->db->get_where('page_layouts', $params)->result();
    }
    
	// Count the amount of page_layouts with param X
	function count($params = array())
	{
		$results = $this->get($params);
		
		return count($results);
	}
    
	// ----- CRUD --------------------
	
    // Create a new page layout
    function create($input = array())
    {
        $this->load->helper('date');
        
        $this->db->insert('page_layouts', array(
        	'title' 		=> $input['title'],
        	'body' 			=> $input['body'],
        	'updated_on'	=> now()
        ));
        
        return $this->db->insert_id();
    }
    
    // Update a page layout
    function update($id = 0, $input = array())
    {
        $this->load->helper('date');
        
        $this->db->update('page_layouts', array(
	        'title' 		=> $input['title'],
	        'body' 			=> $input['body'],
	        'updated_on' 	=> now()
        ), array('id' => $id));
    }
    
    // Delete a page layout
    function delete($id = 0)
    {
        $this->db->where('id', $id);
    	return $this->db->delete('page_layouts');
    }
    
}

?>