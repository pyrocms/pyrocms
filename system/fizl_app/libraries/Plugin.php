<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Plugin Library
 *
 * Class for plugins to extend. 
 *
 * @package		Fizl
 * @author		Adam Fairholm (@adamfairholm)
 * @copyright	Copyright (c) 2011, 1bit
 * @license		http://1bitapps.com/fizl/license.html
 * @link		http://1bitapps.com/fizl
 */
class Plugin {

	/**
	 * Whatever is between the tags for tag pairs
	 */
	public $tag_content;

	// --------------------------------------------------------------------------
	
	/**
	 * Get a plugin param.
	 *
	 * @access	public
	 * @param	string
	 * @param	[string]
	 * @return	string
	 */
	public function get_param($key, $default = '')
	{
		if(isset($this->$key)):
		
			return $this->$key;
			
		else:
		
			return $default;
		
		endif;
	}

}

/* End of file Plugin.php */