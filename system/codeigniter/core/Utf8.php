<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 2.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Utf8 Class
 *
 * Provides support for UTF-8 environments
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	UTF-8
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/utf8.html
 */
class CI_Utf8 {

	/**
	 * Constructor
	 *
	 * Determines if UTF-8 support is to be enabled
	 */
	public function __construct()
	{
		log_message('debug', 'Utf8 Class Initialized');

		global $CFG;

		if (
			@preg_match('/./u', 'é') === 1		// PCRE must support UTF-8
			&& function_exists('iconv')			// iconv must be installed
			&& @ini_get('mbstring.func_overload') != 1	// Multibyte string function overloading cannot be enabled
			&& $CFG->item('charset') === 'UTF-8'		// Application charset must be UTF-8
			)
		{
			define('UTF8_ENABLED', TRUE);
			log_message('debug', 'UTF-8 Support Enabled');

			// set internal encoding for multibyte string functions if necessary
			// and set a flag so we don't have to repeatedly use extension_loaded()
			// or function_exists()
			if (extension_loaded('mbstring'))
			{
				define('MB_ENABLED', TRUE);
				mb_internal_encoding('UTF-8');
			}
			else
			{
				define('MB_ENABLED', FALSE);
			}
		}
		else
		{
			define('UTF8_ENABLED', FALSE);
			log_message('debug', 'UTF-8 Support Disabled');
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Clean UTF-8 strings
	 *
	 * Ensures strings are UTF-8
	 *
	 * @param	string
	 * @return	string
	 */
	public function clean_string($str)
	{
		if ($this->_is_ascii($str) === FALSE)
		{
			$str = @iconv('UTF-8', 'UTF-8//IGNORE', $str);
		}

		return $str;
	}

	// --------------------------------------------------------------------

	/**
	 * Remove ASCII control characters
	 *
	 * Removes all ASCII control characters except horizontal tabs,
	 * line feeds, and carriage returns, as all others can cause
	 * problems in XML
	 *
	 * @param	string
	 * @return	string
	 */
	public function safe_ascii_for_xml($str)
	{
		return remove_invisible_characters($str, FALSE);
	}

	// --------------------------------------------------------------------

	/**
	 * Convert to UTF-8
	 *
	 * Attempts to convert a string to UTF-8
	 *
	 * @param	string
	 * @param	string	- input encoding
	 * @return	string
	 */
	public function convert_to_utf8($str, $encoding)
	{
		if (function_exists('iconv'))
		{
			return @iconv($encoding, 'UTF-8', $str);
		}
		elseif (function_exists('mb_convert_encoding'))
		{
			return @mb_convert_encoding($str, 'UTF-8', $encoding);
		}

		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Is ASCII?
	 *
	 * Tests if a string is standard 7-bit ASCII or not
	 *
	 * @param	string
	 * @return	bool
	 */
	protected function _is_ascii($str)
	{
		return (preg_match('/[^\x00-\x7F]/S', $str) === 0);
	}

}

/* End of file Utf8.php */
/* Location: ./system/core/Utf8.php */
