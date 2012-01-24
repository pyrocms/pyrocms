<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams API Library
 *
 * @package  	Streams API
 * @category  	Libraries
 * @author  	Parse19
 */

// --------------------------------------------------------------------------
 
/**
 * Streams Utilities Driver
 *
 * Functions to help out with common
 * utility tasks.
 *
 * @package  	Streams API
 * @category  	Drivers
 * @author  	Parse19
 */ 
 
class Streams_cp {
	
	/**
	 * Convert table to stream.
	 *
	 * Note: this does NOT handle fields
	 * at this time. This must be done manually.
	 *
	 * We are trying not to make a lot of assumptions
	 * in this function, lest we get anything else
	 * in the database messed up.
 	 *
	 * @access	public
	 * @param	string - table slug
	 * @param	string - stream prefix
	 * @param	string - full stream name
	 * @param	[string - about the stream]
	 * @param	[string - title column]
	 * @param	[string - is hidden stream - y or n]
	 * @return	bool
	 */
	function table_to_stream($table_slug, $prefix, $stream_name, $about = null, $title_column = null, $is_hidden = 'n')
	{
		// ----------------------------
		// Get table squared away
		// ----------------------------

		// Does the table w/ the prefix exist?
		// If not, then forget it.
		
		if ( ! $this->db->table_exists($prefix.$table_slug) )
		{
			return false;
		}
		
		// ----------------------------
		// Add some fields to profiles
		// in prep for making it a stream
		// ----------------------------

		// Add created field to profiles
		if ( ! $this->db->field_exists('created', 'profiles') )
		{
			$this->dbforge->add_field("`created` datetime DEFAULT NULL");
		}
	
		// Add updated field to profiles
		if ( ! $this->db->field_exists('updated', 'profiles') )
		{
			$this->dbforge->add_field("`updated` DEFAULT NULL");
		}

		// Add created_by field to profiles
		if ( ! $this->db->field_exists('created_by', 'profiles') )
		{
			$this->dbforge->add_field("`created_by` int(11) DEFAULT NULL");
		}

		// Add ordering_count field to profiles
		if ( ! $this->db->field_exists('ordering_count', 'profiles') )
		{
			$this->dbforge->add_field("`ordering_count` int(11) DEFAULT NULL");
		}

		// ----------------------------
		// Add to stream table
		// ----------------------------
		
		$insert_data = array(
			'stream_name'	=> $stream_name,
			'stream_prefix' => $prefix,
			'stream_slug'	=> $table_slug,
			'about'			=> $about,
			'title_column'	=> $title_column,
			'sorting'		=> 'title',
			'is_hidden'		=> $is_hidden
		);
	
		return $this->db->insert($this->config->item('streams.streams_table'), $insert_data);
	}
	
}