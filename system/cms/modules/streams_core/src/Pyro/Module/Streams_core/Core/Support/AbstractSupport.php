<?php namespace Pyro\Module\Streams_core\Core\Support;

abstract class AbstractSupport
{

	/**
	 * Enable debug mode
	 * @var boolean
	 */
	protected static $debug = true;

	/**
	 * Registered callbacks
	 * @var array
	 */
	private $callbacks = array();

	/**
	 * Construct and bring in assets
	 */
	public function __construct()
	{
		ci()->load->language('streams_core/pyrostreams');
		ci()->load->config('streams_core/streams');

		// Load the language file
		if (is_dir(APPPATH.'libraries/Streams')) {
			ci()->lang->load('streams_api', 'english', false, true, APPPATH.'libraries/Streams/');
		}
	}

	/**
	 * Add a callback
	 * @param string $method_name     
	 * @param boolean $method_callable
	 */
    protected function addCallback($method_name, $method_callable)
    {
        if (is_callable($method_callable))
        {
        	$this->callbacks[camel_case('fire_'.$method_name)] = \Closure::bind($method_callable, $this, get_class());
        }
    }
 
 	/**
 	 * Hook into PHP calls to look for callbacks
 	 * @param  strign $method_name 
 	 * @param  array  $args        
 	 * @return function              
 	 */
	public function __call($method_name, array $args)
    {
        if (isset($this->callbacks[$method_name]))
        {
            return call_user_func_array($this->callbacks[$method_name], $args);
        }
    }

    /**
     * Toggle debugging
     * @param  boolean $debug 
     * @return object         
     */
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