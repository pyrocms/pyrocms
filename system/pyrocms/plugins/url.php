<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Session Plugin
 *
 * Read and write session data
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2010, PyroCMS
 *
 */
class Plugin_Url extends Plugin
{
	/**
	 * Current uri string
	 *
	 * Usage:
	 * {pyro:url:current}
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
	 * {pyro:url:site}
	 *
	 * @param	array
	 * @return	array
	 */
	function site()
	{
		return rtrim(site_url(), '/').'/';
	}

	/**
	 *
	 * base URL of the install
	 *
	 * Usage:
	 * {pyro:url:base}
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
	 * {pyro:url:segments segment="1" default="home"}
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
}

/* End of file theme.php */