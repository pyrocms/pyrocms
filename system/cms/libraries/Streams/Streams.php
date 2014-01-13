<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams API Library
 *
 * @author  	Parse19
 * @package  	PyroCMS\Core\Libraries\Streams
 */
class Streams extends CI_Driver_Library
{
	/**
	 * @var	array Valid Streams API Drivers
	 */
	protected $valid_drivers = array(
		'entries',
		'fields',
		'streams',
		'cp',
		'utilities',
		'parse'
	);

	/**
	 * Debug Mode
	 *
	 * When set to true, the API will throw
	 * CodeIgniter errors when it encouters
	 * a problem. Otherwise they will be
	 * quietly ignored.
	 *
	 * @var		obj
	 */
	public $debug = true;

	/**
	 * Library Constructor
	 *
	 * Load our required assets
	 *
	 * @return	void
	 */
	public function __construct()
	{
/*		ci()->load->language('streams_core/pyrostreams');
		ci()->load->config('streams_core/streams');

		// Load the language file
		if (is_dir(APPPATH.'libraries/Streams')) {
			ci()->lang->load('streams_api', 'english', false, true, APPPATH.'libraries/Streams/');
		}*/
	}

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
		if (is_string($stream)) {
			return ci()->streams_m->get_stream_id_from_slug($stream, $namespace);
		}

		// Check for object
		if (is_object($stream) and isset($stream->id)) return $stream->id;

		return null;
	}

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
		if (is_numeric($stream)) return ci()->streams_m->get_stream($stream);

		// Check for slug
		if (is_string($stream) and $namespace) return ci()->streams_m->get_stream($stream, true, $namespace);

		return null;
	}

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
