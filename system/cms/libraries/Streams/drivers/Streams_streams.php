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
	 * @param	string - stream namespace
	 * @param	[string - stream prefix]
	 * @param	[string - about notes for stream]
	 * @return	bool
	 */
	public function add_stream($stream_name, $stream_slug, $namespace, $prefix = NULL, $about = NULL)
	{
		// -------------------------------------
		// Validate Data
		// -------------------------------------
		
		// Do we have a stream name?
		if ( ! trim($stream_name))
		{
			$this->log_error('empty_stream_name', 'add_stream');
			return FALSE;
		}				

		// Do we have a stream slug?
		if ( ! trim($stream_slug))
		{
			$this->log_error('empty_stream_slug', 'add_stream');
			return FALSE;
		}				

		// Do we have a stream namespace?
		if ( ! trim($namespace))
		{
			$this->log_error('empty_stream_namespace', 'add_stream');
			return FALSE;
		}				
		
		// Is this stream slug already available?
		if( is_object($this->CI->streams_m->get_stream($stream_slug, true)) )
		{
			$this->log_error('stream_slug_in_use', 'add_stream');
			return FALSE;
		}
	
		// -------------------------------------
		// Create Stream
		// -------------------------------------
		
		return $this->CI->streams_m->create_new_stream(
												$stream_name,
												$stream_slug,
												$prefix,
												$namespace,
												$about
											);
	}

	// --------------------------------------------------------------------------

	/**
	 * Get Stream
	 *
	 * @access	public
	 * @param	stream - obj, id, or string
	 * @param	[string - namespace]
	 * @return	object
	 */
	public function get_stream($stream, $namespace = NULL)
	{
		return $this->CI->streams_m->get_stream($this->stream_id($stream, $namespace));
	}

	// --------------------------------------------------------------------------

	/**
	 * Delete a stream
	 *
	 * @access	public
	 * @param	stream - obj, id, or string
	 * @param	[string - namespace]
	 * @return	object
	 */
	public function delete_stream($stream, $namespace = NULL)
	{
		$str_obj = $this->stream_obj($stream, $namespace);
		
		if ( ! $str_obj) $this->log_error('invalid_stream', 'delete_stream');
	
		return $this->CI->streams_m->delete_stream($str_obj);
	}

	// --------------------------------------------------------------------------

	/**
	 * Update a stream
	 *
	 * @access	public
	 * @param	stream - obj, id, or string
	 * @param 	array - data
	 * @param	[string - namespace]
	 * @return	object
	 */
	function update_stream($stream, $data, $namespace = NULL)
	{
		return $this->CI->streams_m->update_stream($this->stream_id($stream, $namespace), $data);
	}

	// --------------------------------------------------------------------------

	/**
	 * Get stream field assignments
	 *
	 * @access	public
	 * @param	stream - obj, id, or string
	 * @param	[string - namespace]
	 * @return	object
	 */
	public function get_assignments($stream, $namespace = NULL)
	{
		return $this->CI->field_m->get_assignments_for_stream($this->stream_id($stream, $namespace));
	}
	
}