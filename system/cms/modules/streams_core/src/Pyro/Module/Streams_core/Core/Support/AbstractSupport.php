<?php namespace Pyro\Module\Streams_core\Core\Support;

abstract class AbstractSupport
{

	protected static $debug = true;

	public function __construct()
	{
		ci()->load->language('streams_core/pyrostreams');
		ci()->load->config('streams_core/streams');

		// Load the language file
		if (is_dir(APPPATH.'libraries/Streams')) {
			ci()->lang->load('streams_api', 'english', false, true, APPPATH.'libraries/Streams/');
		}
	}

	public static function debug($debug = true)
	{
		static::$debug = $debug;

		return new static;
	}

	/**
	 * Show an error message based on the
	 * debug level.
	 *
	 * @param	string $lang_code error message
	 * @param	function $function
	 * @param	info $info additional information
	 * @return	void
	 */
	public static function logError($lang_code = null, $function = null, $info = null)
	{

		if ( ! $lang_code or ! $function)
		{
			return false;
		}
			//$error = lang('streams:api.'.$lang_code).' ['.$function.']';
		$error = lang_label($lang_code).' ['.$function.']';			

		if ($info)
		{
			$error .= ' '.$info; // Must be already translated
		}


		// Log the message either way
		log_message('error', $error);

		if (static::$debug === true) show_error($error);
	}

}