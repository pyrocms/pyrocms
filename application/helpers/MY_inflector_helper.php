<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2009, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Inflector Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/directory_helper.html
 */


// --------------------------------------------------------------------

/**
 * Humanize - Cyrillic character support
 *
 * Takes multiple words separated by underscores and changes them to spaces
 *
 * @access	public
 * @param	string
 * @return	str
 */	
if ( ! function_exists('humanize'))
{	
	function humanize($str)
	{
		$str = preg_replace('/[_]+/', ' ', trim($str));
		
		if( function_exists('mb_convert_case') )
		{
			return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
		}
		
		else
		{
			return ucwords(strtolower($str));
		}
	}
}
	

// --------------------------------------------------------------------

/**
 * Keywords
 *
 * Takes multiple words separated by spaces and changes them to keywords
 *
 * @access	public
 * @param	string
 * @return	str
 */	
if ( ! function_exists('keywords'))
{	
	function keywords($str)
	{
		return preg_replace('/[\s]+/', ', ', trim($str));
	}
}

/* End of file inflector_helper.php */
/* Location: ./system/helpers/inflector_helper.php */