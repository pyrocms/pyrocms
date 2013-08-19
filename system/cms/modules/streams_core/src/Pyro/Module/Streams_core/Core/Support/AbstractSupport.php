<?php namespace Pyro\Module\Streams_core\Core\Support;

abstract class AbstractSupport
{

	protected $debug = true;

	public function debug($debug = true)
	{
		$this->debug = $debug;
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
	public function logError($lang_code = null, $function = null, $info = null)
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

		if ($this->debug === true) show_error($error);
	}

}