<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Page_layouts_m extends MY_Model
{

	// Get stuff is handled by MY_Model magic fun.
	
	// ----- CRUD --------------------
	
    // Create a new page layout
    function create($input = array())
    {
        $this->load->helper('date');
        
        $this->db->insert('page_layouts', array(
        	'title' 		=> $input['title'],
        	'body' 			=> $input['body'],
        	'css' 			=> $input['css'],
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
	        'css' 			=> $input['css'],
	        'updated_on' 	=> now()
        ), array('id' => $id));
    }
    
}

?>