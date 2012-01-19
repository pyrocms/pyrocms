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
 * Entries Driver
 *
 * @package  	Streams API
 * @category  	Drivers
 * @author  	Parse19
 */ 
 
class Streams_streams extends CI_Driver {

	// --------------------------------------------------------------------------

	/**
	 * Get entries for a stream.
	 *
	 * @access	public
	 * @param	string - stream name
	 * @param	string - stream slug
	 * @param	[string - about notes for stream]
	 * @return	bool
	 */
	public function add_stream($stream_name, $stream_slug, $about = null)
	{
		// -------------------------------------
		// Validate Data
		// -------------------------------------
		
		// Do we have a stream name?
		if( !trim($stream_name) ):
		
			$this->log_error('empty_stream_name', 'add_stream');
			return false;
						
		endif;

		// Do we have a stream slug?
		if( !trim($stream_slug) ):
		
			$this->log_error('empty_stream_slug', 'add_stream');
			return false;
						
		endif;
		
		// Is this stream slug already available?
		if( is_object($this->CI->streams_m->get_stream($stream_slug, true)) ):
		
			$this->log_error('stream_slug_in_use', 'add_stream');
			return false;
		
		endif;
	
		// -------------------------------------
		// Create Stream
		// -------------------------------------
	
		return $this->CI->streams_m->create_new_stream($stream_name, $stream_slug, $about);
	}

	// --------------------------------------------------------------------------

	/**
	 * Get Stream
	 *
	 * @access	public
	 * @param	stream
	 * @return	object
	 */
	public function get_stream($stream)
	{
		return $this->CI->streams_m->get_stream($this->stream_id($stream));
	}

	// --------------------------------------------------------------------------

	/**
	 * Delete a stream
	 *
	 * @access	public
	 * @param	stream
	 * @return	object
	 */
	public function delete_stream($stream)
	{
		return $this->CI->streams_m->delete_stream($this->stream_obj($stream));
	}

	// --------------------------------------------------------------------------

	/**
	 * Update a stream
	 *
	 * @access	public
	 * @param	string
	 * @param 	array - data
	 * @return	object
	 */
	function update_stream($stream, $data)
	{
		return $this->CI->streams_m->update_stream($this->stream_id($stream), $data);
	}

	// --------------------------------------------------------------------------

	/**
	 * Get stream field assignments
	 *
	 * @access	public
	 * @param	stream
	 * @return	object
	 */
	public function get_assignments($stream)
	{
		return $this->CI->field_m->get_assignments_for_stream($this->stream_id($stream));
	}
	
}