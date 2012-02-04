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
		
		// Easy out for configs.
		// We have a special place in our heart for config:config_item.
		if ($plugin == 'config')
		{
			return $this->CI->config->item($call);
		}
		
		$plugin_dirs = array(APPPATH.'plugins/', FCPATH.'addons/plugins/');
		
		// We can either have plugin folders or plugin files.
		foreach ($plugin_dirs as $dir)
		{		
			if (is_dir($dir.$plugin) AND is_file($dir.$plugin.'/'.$plugin.'.php'))
			{
				$file = $dir.$plugin.'/'.$plugin.'.php';
				break;
			}
			elseif (is_file($dir.$plugin.'.php'))
			{
				$file = $dir.$plugin.'.php';
				break;
			}
		}
		
		if ( ! isset($file)) return NULL;
		
		require_once($file);
		
		$class = 'Plugin_'.$plugin;
		
		if(class_exists($class))
		{
			$plug = new $class();
		}
		
		// Add our params to the library
		// as class variables
		foreach($attributes as $key => $val)
		{
			$plug->attributes[$key] = $val;
		}
		
		// Add content to the library
		$plug->tag_content = $content;
		
		if ( ! method_exists($plug, $call)) return NULL;
		
		return $plug->$call();
	}

}