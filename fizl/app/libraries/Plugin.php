<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Fizl Parse Library
 *
 * Class for plugins to extend. 
 *
 * @package		Fizl
 * @author		Adam Fairholm (@adamfairholm)
 * @copyright	Copyright (c) 2011-2012, Parse19
 * @license		http://parse19.com/fizl/docs/license.html
 * @link		http://parse19.com/fizl
 */
class Plugin {

	/**
	 * Whatever is between the tags for tag pairs
	 *
	 * @access	public
	 * @param	string
	 */
	public $tag_content;

	// --------------------------------------------------------------------------

	/**
	 * Any passed attributes from the tag
	 *
	 * @access	public
	 * @var		array
	 */
	public $attributes;

	// --------------------------------------------------------------------------
	
	public function __construct()
	{
		$this->CI = get_instance();
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Get a plugin param.
	 *
	 * @access	public
	 * @param	string
	 * @param	[string]
	 * @return	string
	 */
	public function get_param($key, $default = NULL)
	{
		if(isset($this->attributes[$key]))
		{
			return $this->attributes[$key];
		}	
		else
		{
			return $default;
		}
	}

}