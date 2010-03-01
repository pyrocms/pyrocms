<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Page_layouts_m extends MY_Model
{

	// Get stuff is handled by MY_Model magic fun.
	
    // Create a new page layout
    function insert($input = array())
    {
        $this->load->helper('date');
        
        $input['updated_on'] = now();
        
        return parent::insert($input);
    }
    
    // Update a page layout
    function update($id = 0, $input = array())
    {
        $this->load->helper('date');
        
        $input['updated_on'] = now();
        
        return parent::update($id, $input);
    }
    
}

?>