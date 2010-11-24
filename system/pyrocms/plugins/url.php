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
		return $this->uri->uri_string();
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
}

/* End of file theme.php */