<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams API Library
 *
 * @package		PyroStreams
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2011 - 2013, PyroCMS
 */ 
class Streams extends CI_Driver_Library {

	/**
	 * CI Instance
	 *
	 * @access	protected
	 * @var		obj
	 */
	protected $CI;

	// --------------------------------------------------------------------------

	/**
	 * Valid Streams API Drivers
	 *
	 * Required by CodeIgniter
	 *
	 * @access	protected
	 * @var		array
	 */
	protected $valid_drivers 	= array(
			'streams_entries',
			'streams_fields',
			'streams_streams',
			'streams_cp',
			'streams_utilities',
			'streams_parse'
	);

	// --------------------------------------------------------------------------

	/**
	 * Debug Mode
	 *
	 * When set to true, the API will throw
	 * CodeIgniter errors when it encouters
	 * a problem. Otherwise they will be
	 * quietly ignored.
	 *
	 * @access	protected
	 * @var		obj
	 */
	public $debug = true;

	// --------------------------------------------------------------------------
	
	/**
	 * Library Constructor
	 *
	 * Load our required assets
	 *
	 * @access	public
	 * @return	void
	 */
	public function __construct()
	{
		$this->CI = get_instance();

		$this->CI->load->language('streams_core/pyrostreams');
		$this->CI->load->config('streams_core/streams');
		$this->CI->load->library(array('streams_core/Type', 'streams_core/Fields', 'Form_validation'));
	
		$this->CI->load->model(array('streams_core/row_m', 'streams_core/streams_m', 'streams_core/fields_m'));
		
		// Load the language file
		if(is_dir(APPPATH.'libraries/Streams'))
		{
			$this->CI->lang->load('streams_api', 'english', false, true, APPPATH.'libraries/Streams/');
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Stream ID
	 *
	 * Get a stream ID from any number of
	 * stream inputs (object, id, or slug).
	 *
	 * If you are using the stream slug, you
	 * need to provide the namespace. 
	 *
	 * @param	mixed $stream
	 * @param	string $namespace
	 * @return	null|int
	 */
	public function stream_id($stream, $namespace = null)
	{
		// If we have an ID, then we're done.
		if (is_numeric($stream)) return $stream;
		
		// Check for slug
		if (is_string($stream))
		{
			return $this->CI->streams_m->get_stream_id_from_slug($stream, $namespace);
		}

		// Check for object
		if (is_object($stream) and isset($stream->id)) return $stream->id;
		
		return null;
	}
	
	// --------------------------------------------------------------------------

	/**
	 * Get a stream object from any number of
	 * stream inputs (object, id, or slug)
	 *
	 * @param	obj|int|string $stream
	 * @param	obj|int|string $namespace
	 * @return	null|int
	 */
	public function stream_obj($stream, $namespace = null)
	{
		// Check for object
		if (is_object($stream)) return $stream;

		// Check for ID
		if (is_numeric($stream)) return $this->CI->streams_m->get_stream($stream);
				
		// Check for slug
		if (is_string($stream) and $namespace) return $this->CI->streams_m->get_stream($stream, true, $namespace);
		
		return null;
	}

	// --------------------------------------------------------------------------

	/**
	 * Show an error message based on the
	 * debug level.
	 *
	 * @param	string $lang_code error message
	 * @param	function $function 
	 * @return	void
	 */
	public function log_error($lang_code, $function)
	{
		//$error = lang('streams:api.'.$lang_code).' ['.$function.']';
		$error = $lang_code.' ['.$function.']';
		
		// Log the message either way
		log_message('error', $error);
	
		if ($this->debug === true) show_error($error);
	}
	
}