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
 * @since		Version 1.0
 * @filesource
 */

/**
 * CodeIgniter File Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/file_helper.html
 */

// ------------------------------------------------------------------------

if ( ! function_exists('read_file'))
{
	/**
	 * Read File
	 *
	 * Opens the file specfied in the path and returns it as a string.
	 *
	 * This function is DEPRECATED and should be removed in
	 * CodeIgniter 3.1+. Use file_get_contents() instead.
	 *
	 * @deprecated
	 * @param	string	path to file
	 * @return	string
	 */
	function read_file($file)
	{
		return @file_get_contents($file);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('write_file'))
{
	/**
	 * Write File
	 *
	 * Writes data to the file specified in the path.
	 * Creates a new file if non-existent.
	 *
	 * @param	string	path to file
	 * @param	string	file data
	 * @param	int
	 * @return	bool
	 */
	function write_file($path, $data, $mode = FOPEN_WRITE_CREATE_DESTRUCTIVE)
	{
		if ( ! $fp = @fopen($path, $mode))
		{
			return FALSE;
		}

		flock($fp, LOCK_EX);
		fwrite($fp, $data);
		flock($fp, LOCK_UN);
		fclose($fp);

		return TRUE;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_files'))
{
	/**
	 * Delete Files
	 *
	 * Deletes all files contained in the supplied directory path.
	 * Files must be writable or owned by the system in order to be deleted.
	 * If the second parameter is set to TRUE, any directories contained
	 * within the supplied base directory will be nuked as well.
	 *
	 * @param	string	path to file
	 * @param	bool	whether to delete any directories found in the path
	 * @param	int
	 * @param	bool	whether to skip deleting .htaccess and index page files
	 * @return	bool
	 */
	function delete_files($path, $del_dir = FALSE, $level = 0, $htdocs = FALSE)
	{
		// Trim the trailing slash
		$path = rtrim($path, DIRECTORY_SEPARATOR);

		if ( ! $current_dir = @opendir($path))
		{
			return FALSE;
		}

		while (FALSE !== ($filename = @readdir($current_dir)))
		{
			if ($filename !== '.' && $filename !== '..')
			{
				if (is_dir($path.DIRECTORY_SEPARATOR.$filename) && $filename[0] !== '.')
				{
					delete_files($path.DIRECTORY_SEPARATOR.$filename, $del_dir, $level + 1, $htdocs);
				}
				elseif ($htdocs !== TRUE OR ! preg_match('/^(\.htaccess|index\.(html|htm|php)|web\.config)$/i', $filename))
				{
					@unlink($path.DIRECTORY_SEPARATOR.$filename);
				}
			}
		}
		@closedir($current_dir);

		if ($del_dir === TRUE && $level > 0)
		{
			return @rmdir($path);
		}

		return TRUE;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_filenames'))
{
	/**
	 * Get Filenames
	 *
	 * Reads the specified directory and builds an array containing the filenames.
	 * Any sub-folders contained within the specified path are read as well.
	 *
	 * @param	string	path to source
	 * @param	bool	whether to include the path as part of the filename
	 * @param	bool	internal variable to determine recursion status - do not use in calls
	 * @return	array
	 */
	function get_filenames($source_dir, $include_path = FALSE, $_recursion = FALSE)
	{
		static $_filedata = array();

		if ($fp = @opendir($source_dir))
		{
			// reset the array and make sure $source_dir has a trailing slash on the initial call
			if ($_recursion === FALSE)
			{
				$_filedata = array();
				$source_dir = rtrim(realpath($source_dir), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
			}

			while (FALSE !== ($file = readdir($fp)))
			{
				if (@is_dir($source_dir.$file) && $file[0] !== '.')
				{
					get_filenames($source_dir.$file.DIRECTORY_SEPARATOR, $include_path, TRUE);
				}
				elseif ($file[0] !== '.')
				{
					$_filedata[] = ($include_path === TRUE) ? $source_dir.$file : $file;
				}
			}
			closedir($fp);

			return $_filedata;
		}

		return FALSE;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('get_dir_file_info'))
{
	/**
	 * Get Directory File Information
	 *
	 * Reads the specified directory and builds an array containing the filenames,
	 * filesize, dates, and permissions
	 *
	 * Any sub-folders contained within the specified path are read as well.
	 *
	 * @param	string	path to source
	 * @param	bool	Look only at the top level directory specified?
	 * @param	bool	internal variable to determine recursion status - do not use in calls
	 * @return	array
	 */
	function get_dir_file_info($source_dir, $top_level_only = TRUE, $_recursion = FALSE)
	{
		static $_filedata = array();
		$relative_path = $source_dir;

		if ($fp = @opendir($source_dir))
		{
			// reset the array and make sure $source_dir has a trailing slash on the initial call
			if ($_recursion === FALSE)
			{
				$_filedata = array();
				$source_dir = rtrim(realpath($source_dir), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
			}

			// foreach (scandir($source_dir, 1) as $file) // In addition to being PHP5+, scandir() is simply not as fast
			while (FALSE !== ($file = readdir($fp)))
			{
				if (@is_dir($source_dir.$file) && $file[0] !== '.' && $top_level_only === FALSE)
				{
					get_dir_file_info($source_dir.$file.DIRECTORY_SEPARATOR, $top_level_only, TRUE);
				}
				elseif ($file[0] !== '.')
				{
					$_filedata[$file] = get_file_info($source_dir.$file);
					$_filedata[$file]['relative_path'] = $relative_path;
				}
			}
			closedir($fp);

			return $_filedata;
		}

		return FALSE;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('get_file_info'))
{
	/**
	 * Get File Info
	 *
	 * Given a file and path, returns the name, path, size, date modified
	 * Second parameter allows you to explicitly declare what information you want returned
	 * Options are: name, server_path, size, date, readable, writable, executable, fileperms
	 * Returns FALSE if the file cannot be found.
	 *
	 * @param	string	path to file
	 * @param	mixed	array or comma separated string of information returned
	 * @return	array
	 */
	function get_file_info($file, $returned_values = array('name', 'server_path', 'size', 'date'))
	{

		if ( ! file_exists($file))
		{
			return FALSE;
		}

		if (is_string($returned_values))
		{
			$returned_values = explode(',', $returned_values);
		}

		foreach ($returned_values as $key)
		{
			switch ($key)
			{
				case 'name':
					$fileinfo['name'] = substr(strrchr($file, DIRECTORY_SEPARATOR), 1);
					break;
				case 'server_path':
					$fileinfo['server_path'] = $file;
					break;
				case 'size':
					$fileinfo['size'] = filesize($file);
					break;
				case 'date':
					$fileinfo['date'] = filemtime($file);
					break;
				case 'readable':
					$fileinfo['readable'] = is_readable($file);
					break;
				case 'writable':
					// There are known problems using is_weritable on IIS.  It may not be reliable - consider fileperms()
					$fileinfo['writable'] = is_writable($file);
					break;
				case 'executable':
					$fileinfo['executable'] = is_executable($file);
					break;
				case 'fileperms':
					$fileinfo['fileperms'] = fileperms($file);
					break;
			}
		}

		return $fileinfo;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('get_mime_by_extension'))
{
	/**
	 * Get Mime by Extension
	 *
	 * Translates a file extension into a mime type based on config/mimes.php.
	 * Returns FALSE if it can't determine the type, or open the mime config file
	 *
	 * Note: this is NOT an accurate way of determining file mime types, and is here strictly as a convenience
	 * It should NOT be trusted, and should certainly NOT be used for security
	 *
	 * @param	string	path to file
	 * @return	mixed
	 */
	function get_mime_by_extension($file)
	{
		$extension = strtolower(substr(strrchr($file, '.'), 1));

		static $mimes;

		if ( ! is_array($mimes))
		{
			$mimes =& get_mimes();

			if (empty($mimes))
			{
				return FALSE;
			}
		}

		if (isset($mimes[$extension]))
		{
			return is_array($mimes[$extension])
				? current($mimes[$extension]) // Multiple mime types, just give the first one
				: $mimes[$extension];
		}

		return FALSE;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('symbolic_permissions'))
{
	/**
	 * Symbolic Permissions
	 *
	 * Takes a numeric value representing a file's permissions and returns
	 * standard symbolic notation representing that value
	 *
	 * @param	int
	 * @return	string
	 */
	function symbolic_permissions($perms)
	{
		if (($perms & 0xC000) === 0xC000)
		{
			$symbolic = 's'; // Socket
		}
		elseif (($perms & 0xA000) === 0xA000)
		{
			$symbolic = 'l'; // Symbolic Link
		}
		elseif (($perms & 0x8000) === 0x8000)
		{
			$symbolic = '-'; // Regular
		}
		elseif (($perms & 0x6000) === 0x6000)
		{
			$symbolic = 'b'; // Block special
		}
		elseif (($perms & 0x4000) === 0x4000)
		{
			$symbolic = 'd'; // Directory
		}
		elseif (($perms & 0x2000) === 0x2000)
		{
			$symbolic = 'c'; // Character special
		}
		elseif (($perms & 0x1000) === 0x1000)
		{
			$symbolic = 'p'; // FIFO pipe
		}
		else
		{
			$symbolic = 'u'; // Unknown
		}

		// Owner
		$symbolic .= (($perms & 0x0100) ? 'r' : '-')
			. (($perms & 0x0080) ? 'w' : '-')
			. (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x' ) : (($perms & 0x0800) ? 'S' : '-'));

		// Group
		$symbolic .= (($perms & 0x0020) ? 'r' : '-')
			. (($perms & 0x0010) ? 'w' : '-')
			. (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x' ) : (($perms & 0x0400) ? 'S' : '-'));

		// World
		$symbolic .= (($perms & 0x0004) ? 'r' : '-')
			. (($perms & 0x0002) ? 'w' : '-')
			. (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x' ) : (($perms & 0x0200) ? 'T' : '-'));

		return $symbolic;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('octal_permissions'))
{
	/**
	 * Octal Permissions
	 *
	 * Takes a numeric value representing a file's permissions and returns
	 * a three character string representing the file's octal permissions
	 *
	 * @param	int
	 * @return	string
	 */
	function octal_permissions($perms)
	{
		return substr(sprintf('%o', $perms), -3);
	}
}

/* End of file file_helper.php */
/* Location: ./system/helpers/file_helper.php */