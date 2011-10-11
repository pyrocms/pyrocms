<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Events
 *
 * A simple events system for CodeIgniter.
 *
 * @package		CodeIgniter
 * @subpackage	Events
 * @version		1.0
 * @author		Dan Horrigan <http://dhorrigan.com>
 * @author		Eric Barnes <http://ericlbarnes.com>
 * @license		Apache License v2.0
 * @copyright	2010 Dan Horrigan
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Events Library
 */
class Events {

	/**
	 * @var	array	An array of listeners
	 */
	protected static $_listeners = array();

	public function __construct()
	{
		self::_load_modules();
	}

	// ------------------------------------------------------------------------

	/**
	 * Load Modules
	 *
	 * Loads all active modules
	 *
	 */
	private static function _load_modules()
	{
		$_ci = get_instance();

		$is_core = TRUE;

		$_ci->load->model('modules/module_m');

		if ( ! $results = $_ci->module_m->get_all())
		{
			return FALSE;
		}

		foreach ($results as $row)
		{
			// This doesnt have a valid details.php file! :o
			if ( ! $details_class = self::_spawn_class($row['slug'], $row['is_core']))
			{
				continue;
			}
		}

		return TRUE;
	}

	/**
	 * Spawn Class
	 *
	 * Checks to see if a events.php exists and returns a class
	 *
	 * @param	string	$slug	The folder name of the module
	 * @access	private
	 * @return	array
	 */
	private static function _spawn_class($slug, $is_core = FALSE)
	{
		$path = $is_core ? APPPATH : ADDONPATH;

		// Before we can install anything we need to know some details about the module
		$events_file = $path . 'modules/' . $slug . '/events'.EXT;

		// Check the details file exists
		if ( ! is_file($events_file))
		{
			$events_file = SHARED_ADDONPATH . 'modules/' . $slug . '/events'.EXT;
			
			if ( ! is_file($events_file))
			{
				return FALSE;
			}
		}

		// Sweet, include the file
		include_once $events_file;

		// Now call the details class
		$class = 'Events_'.ucfirst(strtolower($slug));

		// Now we need to talk to it
		return class_exists($class) ? new $class : FALSE;
	}

	/**
	 * Register
	 *
	 * Registers a Callback for a given event
	 *
	 * @access	public
	 * @param	string	The name of the event
	 * @param	array	The callback for the Event
	 * @return	void
	 */
	public static function register($event, array $callback)
	{
		$key = get_class($callback[0]).'::'.$callback[1];
		self::$_listeners[$event][$key] = $callback;
		log_message('debug', 'Events::register() - Registered "'.$key.' with event "'.$event.'"');
	}

	/**
	 * Trigger
	 *
	 * Triggers an event and returns the results.  The results can be returned
	 * in the following formats:
	 *
	 * 'array'
	 * 'json'
	 * 'serialized'
	 * 'string'
	 *
	 * @access	public
	 * @param	string	The name of the event
	 * @param	mixed	Any data that is to be passed to the listener
	 * @param	string	The return type
	 * @return	mixed	The return of the listeners, in the return type
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
	 * @access	protected
	 * @param	array	The array of returns
	 * @param	string	The return type
	 * @return	mixed	The formatted return
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

		// Doesn't do anything, so send NULL. FALSE would suggest an error
		return NULL;
	}

	/**
	 * Has Listeners
	 *
	 * Checks if the event has listeners
	 *
	 * @access	public
	 * @param	string	The name of the event
	 * @return	bool	Whether the event has listeners
	 */
	public static function has_listeners($event)
	{
		log_message('debug', 'Events::has_listeners() - Checking if event "'.$event.'" has listeners.');

		if (isset(self::$_listeners[$event]) AND count(self::$_listeners[$event]) > 0)
		{
			return TRUE;
		}
		return FALSE;
	}
}

/* End of file Events.php */