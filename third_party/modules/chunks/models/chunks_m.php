<?php

class Chunks_m extends MY_Model {

    // --------------------------------------------------------------------------
    
    /**
    * Get some chunks
    *
    * @param	int limit
    * @param	int offset
    * @return	obj
    */
    function get_chunks( $limit = FALSE, $offset = 0 )
	{
     	$query = "SELECT * FROM chunks ORDER BY name DESC";
   
		if( $limit )
     	{
     		$query .= " LIMIT $offset, $limit";
     	}
     
		$obj = $this->db->query( $query );
    	
    	return $obj->result();
	}
     
	// --------------------------------------------------------------------------
     
    /**
     * Insert a chunk
     *
     * @param	array
     * @return bool
     */
    function insert_new_chunk( $chunk_rules )
    {
    	$insert_data = array();
    
    	foreach( array_keys($this->chunk_rules) as $item )
    	{
    		$insert_data[$item] = $this->input->post($item);
    	}
    	
    	$now = date('Y-m-d H:i:s');
    	
    	$insert_data['when_added'] 		= $now;
    	$insert_data['last_updated'] 	= $now;
    	
    	return $this->db->insert('chunks', $insert_data);
    }

}

/* End of file chunks_m.php */
/* Location: ./third_party/modules/chunks/models/chunks_m.php */