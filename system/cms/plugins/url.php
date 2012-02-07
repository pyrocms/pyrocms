<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Session Plugin
 *
 * Read and write session data
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Plugins
 */
class Plugin_Url extends Plugin
{
	/**
	 * Current uri string
	 *
	 * Usage:
	 * {{ url:current }}
	 *
	 * @param	array
	 * @return	array
	 */
	function current()
	{
		return site_url($this->uri->uri_string());
	}

	/**
	 *
	 * site URL of the install
	 *
	 * Usage:
	 * {{ url:site }}
	 *
	 * @param	array
	 * @return	array
	 */
	function site()
	{
		$uri = $this->attribute('uri');

		return $uri ? site_url($uri) : rtrim(site_url(), '/').'/';
	}

	/**
	 *
	 * base URL of the install
	 *
	 * Usage:
	 * {{ url:base }}
	 *
	 * @param	array
	 * @return	array
	 */
	function base()
	{
		return base_url();
	}

	/**
	 *
	 * Pick a segment and provide a default if nothing there
	 *
	 * Usage:
	 * {{ url:segments segment="1" default="home" }}
	 *
	 * @param	array
	 * @return	array
	 */
	function segments()
	{
		$default = $this->attribute('default');
		$segment = $this->attribute('segment');

		return $this->uri->segment($segment, $default);
	}
	
	/**
	 * build an anchor tag
	 *
	 * Usage:
	 * {{ url:anchor segments="users/login" title="Login" class="login" }}
	 *
	 * @param	array
	 * @return	string
	 */
	function anchor()
	{
		$segments = $this->attribute('segments');
		$title = $this->attribute('title', '');
		$class = $this->attribute('class', '');
		
		$class = ! empty($class) ? 'class="' . $class . '"' : '' ;
		
		return anchor($segments, $title, $class);
	}
}

/* End of file url.php */