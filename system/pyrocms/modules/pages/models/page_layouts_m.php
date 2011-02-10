<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Page layout model
 * 
 * @author Phil Sturgeon - PyroCMS Dev Team
 * @package Pyrocms
 * @subpackage Pages module
 * @category Module
 * 
 */
class Page_layouts_m extends MY_Model
{
    /**
     * Create a new page layout
	 * 
	 * @access public
	 * @param array $input The input to insert into the DB
	 * @return mixed
	 * 
     */
    public function insert($input = array())
    {
        $this->load->helper('date');
        
        $input['updated_on'] = now();
        
        return parent::insert($input);
    }

	// --------------------------------------------------------------------------
    
    /**
     * Update a page layout
	 * 
	 * @param int $id The ID of the page layout to update
	 * @param array $input The data to update
	 * @return mixed
     */
    public function update($id = 0, $input = array())
    {
        $this->load->helper('date');
        
        $input['updated_on'] = now();
        
        return parent::update($id, $input);
    }

	// --------------------------------------------------------------------------
    
    /**
     * Save 
	 * 
	 * @access 	public
	 * @param 	string
	 * @return mixed
     */
    public function save_layout_file( $id, $title, $body )
    {
		$path = ADDONPATH . 'layouts';

        if( is_dir($path) ):
     		
     		$this->load->helper( array('file', 'url') );   
        	
        	$file_name = $id . '_' . url_title( $title, 'underscore', TRUE ) . '.html';
        	
        	if( write_file( $path . '/' . $file_name, $body, FOPEN_WRITE_CREATE_DESTRUCTIVE ) ):
        	
        		@chmod( $path . '/' . $file_name, FILE_WRITE_MODE ); 
        	
        	else:
        	
        		return FALSE;
        	
        	endif;
        
        endif;
        
        return TRUE;
	}

	// --------------------------------------------------------------------------

	/**
	 * Get a layout
	 *
	 * @access	public
	 * @param	int
	 * @access	obj
	 */	
	public function get( $id )
	{
		$path = ADDONPATH . 'layouts/';
	
		$this->load->helper('file');
	
		$this->db->limit(1)->where('id', $id);
		$db_obj = $this->db->get('page_layouts');
		
		$layout = $db_obj->row();
		
		// Get layout file and replace the body
		if( $this->settings->get('enable_layout_files') == '1' ):
		
	    	$file_name = $path . '/' . $id . '_' . url_title( $layout->title, 'underscore', TRUE ) . '.html';
	    
	        if( file_exists( $file_name ) ):
	        
	        	$layout->body = read_file( $file_name );
	        	
	        endif;
	        
	    endif;
				
		return $layout;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Delete layout file
	 *
	 * @access	public
	 * @param	int
	 * @return	void
	 */
	public function delete_layout_file( $id )
	{
		$this->db->limit(1)->where('id', $id);
		$db_obj = $this->db->get('page_layouts');
		
		$layout = $db_obj->row();

		@unlink( ADDONPATH . 'layouts/' . $id . '_' . url_title( $layout->title, 'underscore', TRUE ) . '.html' );
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Sync Layouts to Database
	 *
	 * @access	public
	 * @param	array
	 * @return	void
	 */
	public function sync_layouts( $ids )
	{
		// Run through each ID, grab the layout data from the 
		// file and save it back to the DB
			
		foreach( $ids as $layout_id ):
		
			$layout = $this->get( $layout_id );
			
			$update_data['body'] = $layout->body;
			
			$this->db->where('id', $layout_id);
			$this->db->update('page_layouts', $update_data);
		
		endforeach;
	}

}