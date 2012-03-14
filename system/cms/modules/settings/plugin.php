<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Settings Plugin
 *
 * Allows settings to be used in content tags.
 * 
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Settings\Plugins
 */
class Plugin_Settings extends Plugin
{
	/**
	 * Load a variable
	 *
	 * Magic method to get the setting.
	 *
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function __call($name, $data)
	{
		return $this->settings->item($name);
	}
}

/* End of file plugin.php */