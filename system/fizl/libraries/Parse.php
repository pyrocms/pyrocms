<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Parse Library
 *
 * Class for plugins to extend. 
 *
 * @package		Fizl
 * @author		Adam Fairholm (@adamfairholm)
 * @copyright	Copyright (c) 2011-2012, Parse19
 * @license		http://parse19.com/fizl/docs/license.html
 * @link		http://parse19.com/fizl
 */
class Parse {

	/**
	 * Parse Content
	 *
	 * @access	public
	 * @param	array
	 * @return 	string
	 */
	public function callback($name, $attributes, $content)
	{
		$this->CI = get_instance();

		// Do we have a : in the name? If so, we need
		// to separate this into the plugin/call
		if (strpos($name, ':') === FALSE)
		{
			// If we do not have a call
			// specified, we can use a function
			// with the same name as the plugin.
			$plugin 	= $name;
			$call 		= $name;
		}
		else
		{
			$pieces = explode(':', $name, 2);
			
			if (count($pieces) != 2) return NULL;
			
			$plugin 	= $pieces[0];
			$call		= $pieces[1];
		}
		
		// Look for the plugin file
		if (is_dir(APPPATH.'plugins/'.$plugin))
		{
			$this->CI->load->add_package_path(APPPATH.'plugins/'.$plugin);
		}	
		elseif (is_dir(FCPATH.'addons/plugins/'.$plugin))
		{
			$this->CI->load->add_package_path(FCPATH.'fizl/plugins/'.$plugin);
		}	
		else
		{
			return NULL;
		}
		
		$this->CI->load->library($plugin);
		
		// Add our params to the library
		// as class variables
		foreach($attributes as $key => $val)
		{
			$this->CI->$plugin->attributes[$key] = $val;
		}
		
		// Add content to the library
		$this->CI->$plugin->tag_content = $content;
		
		return $this->CI->$plugin->$call();
	}

}