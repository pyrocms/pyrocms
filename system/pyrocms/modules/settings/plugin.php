<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Settings Plugin
 *
 * Allows settings to be used in content tags.
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2010, PyroCMS
 *
 */
class Plugin_Settings extends Plugin
{
	/**
	 * Site Name
	 *
	 * Returns the site name
	 *
	 * @param	array
	 * @return	string
	 */
	public function site_name($data = array())
	{
		return $this->settings->item('site_name');
	}

	// ------------------------------------------------------------------------

	/**
	 * Site Slogan
	 *
	 * Displays the site slogan
	 *
	 * @param	array
	 * @return 	string
	 */
	public function site_slogan($data = array())
	{
		return $this->settings->item('site_slogan');
	}
}

/* End of file plugin.php */