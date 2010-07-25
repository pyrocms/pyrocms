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
     * Get a chunk
     *
     * @param	int
     * @return	obj
     */
    function get_chunk( $chunk_id )
	{     
		$obj = $this->db->query( "SELECT * FROM chunks WHERE id='$chunk_id' LIMIT 1" );
    	
    	return $obj->row();
	}
     
	// --------------------------------------------------------------------------
     
    /**
     * Insert a chunk
     *
     * @param	array
     * @param	int
     * @return 	bool
     */
    function insert_new_chunk( $chunk_rules, $user_id )
    {
    	$insert_data = array();
    
    	foreach( array_keys($this->chunk_rules) as $item )
    	{
    		if( $item == 'content' ):
    		
       			$insert_data[$item] = $this->process_type( $this->input->post('type'), $this->input->post($item) );
 		
			else:
    		
    			$insert_data[$item] = $this->input->post($item);
    		
    		endif;
    	}
    	
    	$now = date('Y-m-d H:i:s');
    	
    	$insert_data['when_added'] 		= $now;
    	$insert_data['last_updated'] 	= $now;
    	$insert_data['added_by']		= $user_id;
    	
    	return $this->db->insert('chunks', $insert_data);
    }

	// --------------------------------------------------------------------------
     
    /**
     * Update a chunk
     *
     * @param	array
     * @param	int
     * @return 	bool
     */
    function update_chunk( $chunk_rules, $chunk_id )
    {
    	$update_data = array();
    
    	foreach( array_keys($this->chunk_rules) as $item )
    	{
    		if( $item == 'content' ):
    		
       			$update_data[$item] = $this->process_type( $this->input->post('type'), $this->input->post($item) );
 		
			else:
    		
    			$update_data[$item] = $this->input->post($item);
    		
    		endif;
    	}
    	
    	$update_data['last_updated'] 	= date('Y-m-d H:i:s');
    	
    	$this->db->where('id', $chunk_id);
    	return $this->db->update('chunks', $update_data);
    }

	// --------------------------------------------------------------------------

	/**
	 * Process a type
	 *
	 * @param	string
	 * @param	string
	 * @param	string - incoming or outgoing
	 * @return 	string
	 */
	function process_type( $type, $string, $mode = 'incoming' )
	{
		if( $type == 'html' ):
		
			if( $mode == 'incoming' ):
			
				return htmlspecialchars( $string );
			
			else:
			
				return htmlspecialchars_decode( $string );
			
			endif;
		
		else:
		
			return $string;
		
		endif;
	
	}
}

/* End of file chunks_m.php */
/* Location: ./third_party/modules/chunks/models/chunks_m.php */