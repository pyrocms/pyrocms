<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams API Library
 *
 * @package  	Streams API
 * @category  	Models
 * @author  	Parse19
 */ 
class Streams extends CI_Driver_Library {

	/**
	 * CI Instance
	 *
	 * @access	protected
	 * @var		obj
	 */
	protected $ci;

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
			'streams_utilities'
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
	protected $debug = true;

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

		$this->CI->load->language('streams/pyrostreams');

		$this->CI->load->config('streams/streams');

		$this->CI->load->helper('streams/streams');

        streams_constants();
        
		$this->CI->load->library('streams/Type');
	
		$this->CI->load->model(array('streams/row_m', 'streams/streams_m', 'streams/fields_m'));
		
		// Load the language file
		if(is_dir(APPPATH.'libraries/Streams')):
		
			$this->CI->lang->load('streams_api', 'english', FALSE, TRUE, APPPATH.'libraries/Streams/');
		
		endif;
	}

	// --------------------------------------------------------------------------

	/**
	 * Get a stream ID from any number of
	 * stream inputs (object, id, or slug)
	 *
	 * @access	public
	 * @param	mixed - obj, int, or string
	 * @return	mixed - null or int
	 */
	public function stream_id($stream)
	{
		// Check for ID
		if(is_numeric($stream)) return $stream;
		
		// Check for slug
		if(is_string($stream)):
		
			return $this->CI->streams_m->get_stream_id_from_slug($stream);
		
		endif;

		// Check for object
		if(is_object($stream) and isset($stream->id)) return $stream->id;
		
		return null;
	}
	
	// --------------------------------------------------------------------------

	/**
	 * Get a stream object from any number of
	 * stream inputs (object, id, or slug)
	 *
	 * @access	public
	 * @param	mixed - obj, int, or string
	 * @return	mixed - null or int
	 */
	public function stream_obj($stream)
	{
		// Check for object
		if(is_object($stream)) return $stream;

		// Check for ID
		if(is_numeric($stream)) return $this->CI->streams_m->get_stream($stream);
		
		// Check for slug
		if(is_string($stream)) return $this->CI->streams_m->get_stream($stream, true);
		
		return null;
	}

	// --------------------------------------------------------------------------

	/**
	 * Show an error message based on the
	 * debug level.
	 *
	 * @access	public
	 * @param	string - error message
	 * @return	void
	 */
	public function log_error($lang_code, $function)
	{
		$error = lang('streams.api.'.$lang_code).' ['.$function.']';
		
		// Log the message either way
		log_message('error', $error);
	
		if($this->debug === true) show_error($error);
	}
	
}