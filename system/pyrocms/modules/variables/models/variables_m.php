<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Variables_m extends MY_Model
{
    function insert($input = array())
    {
    	return parent::insert(array(
    		'name' => $input['name'],
    		'data' => $input['data']
        ));
    }
    
    function update($id, $input = array() )
    {
        return parent::update($id, array(
			'name'	=> $input['name'],
			'data'	=> $input['data']            
		));
    }    
    
    // Callbacks
    function check_name($id, $name = '')
    {
    	return parent::count_by(array( 
			'id !=' => $id, 
			'name' =>  $name
		)) != 0;
    }
}

?>