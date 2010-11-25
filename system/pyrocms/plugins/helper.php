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
class Plugin_Helper extends Plugin
{
	/**
	 * Data
	 *
	 * Loads a theme partial
	 *
	 * Usage:
	 * {pyro:helper:lang line="foo"}
	 *
	 * @param	array
	 * @return	array
	 */
	function lang()
	{
		$line = $this->attribute('line');
		return $this->lang->line($line);
	}

	function date()
	{
		$format = $this->attribute('format');
		return date($format);
	}
}

/* End of file theme.php */