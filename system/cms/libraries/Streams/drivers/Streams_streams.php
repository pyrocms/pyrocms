<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Entries Driver
 * 
 * @author  	Parse19
 * @package  	PyroCMS\Core\Libraries\Streams\Drivers
 */
class Streams_streams extends CI_Driver {

	private $CI;

	/**
	 * Constructor
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct()
	{
		$this->CI =& get_instance();
	}

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
	public function add_stream($stream_name, $stream_slug, $namespace, $prefix = null, $about = null)
	{
		// -------------------------------------
		// Validate Data
		// -------------------------------------
		
		// Do we have a stream name?
		if ( ! trim($stream_name))
		{
			$this->log_error('empty_stream_name', 'add_stream');
			return false;
		}				

		// Do we have a stream slug?
		if ( ! trim($stream_slug))
		{
			$this->log_error('empty_stream_slug', 'add_stream');
			return false;
		}				

		// Do we have a stream namespace?
		if ( ! trim($namespace))
		{
			$this->log_error('empty_stream_namespace', 'add_stream');
			return false;
		}				
		
		// Is this stream slug already available?
		if( is_object($this->CI->streams_m->get_stream($stream_slug, true)) )
		{
			$this->log_error('stream_slug_in_use', 'add_stream');
			return false;
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
	public function get_stream($stream, $namespace)
	{
		$str_id = $this->stream_id($stream, $namespace);
		
		if ( ! $str_id) $this->log_error('invalid_stream', 'get_stream');

		return $this->CI->streams_m->get_stream($str_id);
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
	public function delete_stream($stream, $namespace)
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
	 * @param	string - namespace
	 * @param 	array - associative array of new data
	 * @return	object
	 */
	function update_stream($stream, $namespace, $data)
	{	
		$str_id = $this->stream_id($stream, $namespace);
		
		if ( ! $str_id) $this->log_error('invalid_stream', 'update_stream');
		
		$data['stream_slug'] = $stream;
		$data['stream_prefix'] = isset($data['stream_prefix']) ? $data['stream_prefix'] : NULL;

		return $this->CI->streams_m->update_stream($str_id, $data);
	}

	// --------------------------------------------------------------------------

	/**
	 * Get stream field assignments
	 *
	 * @access	public
	 * @param	stream - obj, id, or string
	 * @param	string - namespace
	 * @return	object
	 */
	public function get_assignments($stream, $namespace)
	{
		$str_id = $this->stream_id($stream, $namespace);
		
		if ( ! $str_id) $this->log_error('invalid_stream', 'get_stream');

		return $this->CI->fields_m->get_assignments_for_stream($str_id);
	}

	// --------------------------------------------------------------------------

	/**
	 * Get streams in a namespace
	 *
	 * @access	public
	 * @param	stream - obj, id, or string
	 * @param	[string - namespace]
	 * @return	object
	 */
	public function get_streams($namespace)
	{
		return $this->CI->streams_m->get_streams($namespace);
	}
	
	// --------------------------------------------------------------------------

	/**
	 * Validation Array
	 *
	 * Get a validation array for a stream. Takes
	 * the format of an array of arrays like this:
	 *
	 * array(
	 * 'field' => 'email',
	 * 'label' => 'Email',
	 * 'rules' => 'required|valid_email'
	 */
	public function validation_array($stream, $namespace, $method = 'new', $skips = array(), $row_id = null)
	{
		$str_id = $this->stream_id($stream, $namespace);
		
		if ( ! $str_id) $this->log_error('invalid_stream', 'validation_array');

		$stream_fields = $this->CI->streams_m->get_stream_fields($str_id);

		return $this->CI->fields->set_rules($stream_fields, $method, $skips, true, $row_id);
	}	
}