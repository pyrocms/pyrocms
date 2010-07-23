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

}

/* End of file chunks_m.php */
/* Location: ./third_party/modules/chunks/models/chunks_m.php */