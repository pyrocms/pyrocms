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
 * Database Cache Class
 *
 * @category	Database
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/database/
 */
class CI_DB_Cache {

	public $CI;
	public $db;	// allows passing of db object so that multiple database connections and returned db objects can be supported

	public function __construct(&$db)
	{
		// Assign the main CI object to $this->CI and load the file helper since we use it a lot
		$this->CI =& get_instance();
		$this->db =& $db;
		$this->CI->load->helper('file');
	}

	// --------------------------------------------------------------------

	/**
	 * Set Cache Directory Path
	 *
	 * @param	string	the path to the cache directory
	 * @return	bool
	 */
	public function check_path($path = '')
	{
		if ($path == '')
		{
			if ($this->db->cachedir == '')
			{
				return $this->db->cache_off();
			}

			$path = $this->db->cachedir;
		}

		// Add a trailing slash to the path if needed
		$path = preg_replace('/(.+?)\/*$/', '\\1/',  $path);

		if ( ! is_dir($path) OR ! is_really_writable($path))
		{
			// If the path is wrong we'll turn off caching
			return $this->db->cache_off();
		}

		$this->db->cachedir = $path;
		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Retrieve a cached query
	 *
	 * The URI being requested will become the name of the cache sub-folder.
	 * An MD5 hash of the SQL statement will become the cache file name
	 *
	 * @return	string
	 */
	public function read($sql)
	{
		if ( ! $this->check_path())
		{
			return $this->db->cache_off();
		}

		$segment_one = ($this->CI->uri->segment(1) == FALSE) ? 'default' : $this->CI->uri->segment(1);
		$segment_two = ($this->CI->uri->segment(2) == FALSE) ? 'index' : $this->CI->uri->segment(2);
		$filepath = $this->db->cachedir.$segment_one.'+'.$segment_two.'/'.md5($sql);

		if (FALSE === ($cachedata = read_file($filepath)))
		{
			return FALSE;
		}

		return unserialize($cachedata);
	}

	// --------------------------------------------------------------------

	/**
	 * Write a query to a cache file
	 *
	 * @return	bool
	 */
	public function write($sql, $object)
	{
		if ( ! $this->check_path())
		{
			return $this->db->cache_off();
		}

		$segment_one = ($this->CI->uri->segment(1) == FALSE) ? 'default' : $this->CI->uri->segment(1);
		$segment_two = ($this->CI->uri->segment(2) == FALSE) ? 'index' : $this->CI->uri->segment(2);
		$dir_path = $this->db->cachedir.$segment_one.'+'.$segment_two.'/';
		$filename = md5($sql);

		if ( ! @is_dir($dir_path))
		{
			if ( ! @mkdir($dir_path, DIR_WRITE_MODE))
			{
				return FALSE;
			}

			@chmod($dir_path, DIR_WRITE_MODE);
		}

		if (write_file($dir_path.$filename, serialize($object)) === FALSE)
		{
			return FALSE;
		}

		@chmod($dir_path.$filename, FILE_WRITE_MODE);
		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Delete cache files within a particular directory
	 *
	 * @return	bool
	 */
	public function delete($segment_one = '', $segment_two = '')
	{
		if ($segment_one == '')
		{
			$segment_one  = ($this->CI->uri->segment(1) == FALSE) ? 'default' : $this->CI->uri->segment(1);
		}

		if ($segment_two == '')
		{
			$segment_two = ($this->CI->uri->segment(2) == FALSE) ? 'index' : $this->CI->uri->segment(2);
		}

		$dir_path = $this->db->cachedir.$segment_one.'+'.$segment_two.'/';
		delete_files($dir_path, TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Delete all existing cache files
	 *
	 * @return	bool
	 */
	public function delete_all()
	{
		delete_files($this->db->cachedir, TRUE);
	}

}

/* End of file DB_cache.php */
/* Location: ./system/database/DB_cache.php */
