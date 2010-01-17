<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Categories_m extends MY_Model
{
	function insert($input = array())
    {
    	$this->db->insert('categories', array(
        	'title'=>$input['title'],
        	'slug'=>url_title(strtolower($input['title']))
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
    
    // Callbacks
    function check_title($title = '')
    {
		return parent::count_by('slug', url_title($title)) === 0;
    }
}

?>