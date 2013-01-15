<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Events
 *
 * A simple events system for CodeIgniter.
 *
 * @version		1.0
 * @author		Dan Horrigan <http://dhorrigan.com>
 * @author		Eric Barnes <http://ericlbarnes.com>
 * @license		Apache License v2.0
 * @copyright	2010 Dan Horrigan
 * @package		PyroCMS\Core\Libraries
 */

class Events
{
	/**
	 * An array of listeners
	 * 
	 * @var	array
	 */
	protected static $_listeners = array();

	/**
	 * Constructor
	 * 
	 * Load up the modules. 
	 */
	public function __construct()
	{
		self::_load_modules();
	}

	/**
	 * Load Modules
	 *
	 * Loads all active modules
	 */
	private static function _load_modules()
	{
		$_ci = get_instance();

		$is_core = true;

		$_ci->load->model('addons/module_m');

		if ( ! $results = $_ci->enabled_modules)
		{
			return false;
		}

		foreach ($results as $row)
		{
			// This does not have a valid details.php file! :o
			if (!$details_class = self::_spawn_class($row['slug'], $row['is_core']))
			{
				continue;
			}
		}

		return true;
	}

	/**
	 * Spawn Class
	 *
	 * Checks to see if a events.php exists and returns a class
	 * 
	 * @param string $slug The folder name of the module.
	 * @param boolean $is_core Whether the module is a core module.
	 * @return object|boolean 
	 */
	private static function _spawn_class($slug, $is_core = false)
	{
		$path = $is_core ? APPPATH : ADDONPATH;

		// Before we can install anything we need to know some details about the module
		$events_file = $path.'modules/'.$slug.'/events'.EXT;

		// Check the details file exists
		if (!is_file($events_file))
		{
			$events_file = SHARED_ADDONPATH.'modules/'.$slug.'/events'.EXT;

			if (!is_file($events_file))
			{
				return false;
			}
		}

		// Sweet, include the file
		include_once $events_file;

		// Now call the details class
		$class = 'Events_'.ucfirst(strtolower($slug));

		// Now we need to talk to it
		return class_exists($class) ? new $class : false;
	}

	/**
	 * Register
	 *
	 * Registers a Callback for a given event
	 *
	 * @param string $event The name of the event.
	 * @param array $callback The callback for the event.
	 */
	public static function register($event, array $callback)
	{
		$key = get_class($callback[0]).'::'.$callback[1];
		self::$_listeners[$event][$key] = $callback;
		log_message('debug', 'Events::register() - Registered "'.$key.' with event "'.$event.'"');
	}

	/**
	 * Triggers an event and returns the results.
	 * 
	 * The results can be returned in the following formats:
	 *  - 'array'
	 *  - 'json'
	 *  - 'serialized'
	 *  - 'string'
	 *
	 * @param string $event The name of the event
	 * @param string $data Any data that is to be passed to the listener
	 * @param string $return_type The return type
	 * @return string|array The return of the listeners, in the return type
	 */
	public static function trigger($event, $data = '', $return_type = 'string')
	{
		log_message('debug', 'Events::trigger() - Triggering event "'.$event.'"');

		$calls = array();

		if (self::has_listeners($event))
		{
			foreach (self::$_listeners[$event] as $listener)
			{
				if (is_callable($listener))
				{
					$calls[] = call_user_func($listener, $data);
				}
			}
		}

		return self::_format_return($calls, $return_type);
	}

	/**
	 * Format Return
	 *
	 * Formats the return in the given type
	 *
	 * @param array $calls The array of returns
	 * @param string $return_type The return type
	 * @return array|null The formatted return
	 */
	protected static function _format_return(array $calls, $return_type)
	{
		log_message('debug', 'Events::_format_return() - Formating calls in type "'.$return_type.'"');

		switch ($return_type)
		{
			case 'array':
				return $calls;
				break;
			case 'json':
				return json_encode($calls);
				break;
			case 'serialized':
				return serialize($calls);
				break;
			case 'string':
				$str = '';
				foreach ($calls as $call)
				{
					$str .= $call;
				}
				return $str;
				break;
			default:
				return $calls;
				break;
		}

		// Does not do anything, so send null. false would suggest an error
		return null;
	}

	/**
	 *
	 * @access	public
	 * @param	string	
	 * @return	bool	
	 */

	/**
	 * Checks if the event has listeners
	 *
	 * @param string $event The name of the event
	 * @return boolean Whether the event has listeners
	 */
	public static function has_listeners($event)
	{
		log_message('debug', 'Events::has_listeners() - Checking if event "'.$event.'" has listeners.');

		if (isset(self::$_listeners[$event]) and count(self::$_listeners[$event]) > 0)
		{
			return true;
		}

		return false;
	}

}