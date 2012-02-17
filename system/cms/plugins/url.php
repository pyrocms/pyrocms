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
	 *   {{ url:current }}
	 * 
	 * @return string The current URI string.
	 */
	function current()
	{
		return site_url($this->uri->uri_string());
	}

	/**
	 * Site URL of the installation.
	 *
	 * Usage:
	 *   {{ url:site }}
	 *
	 * @return string Site URL of the install.
	 */
	function site()
	{
		$uri = $this->attribute('uri');

		return $uri ? site_url($uri) : rtrim(site_url(), '/').'/';
	}

	/**
	 * Base URL of the installation.
	 *
	 * Usage:
	 *   {{ url:base }}
	 *
	 * @return string The base URL for the installation.
	 */
	function base()
	{
		return base_url();
	}

	/**
	 * Get URI segment.
	 *
	 * Usage:
	 *   {{ url:segments segment="1" default="home" }}
	 *
	 * @return string The URI segment, or the provided default.
	 */
	function segments()
	{
		$default = $this->attribute('default');
		$segment = $this->attribute('segment');

		return $this->uri->segment($segment, $default);
	}

	/**
	 * Build an anchor tag
	 *
	 * Usage:
	 *   {{ url:anchor segments="users/login" title="Login" class="login" }}
	 *
	 * @return string The anchor HTML tag.
	 */
	function anchor()
	{
		$segments = $this->attribute('segments');
		$title = $this->attribute('title', '');
		$class = $this->attribute('class', '');

		$class = !empty($class) ? 'class="'.$class.'"' : '';

		return anchor($segments, $title, $class);
	}

}