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
 * @copyright	Copyright (c) 2006 - 2012 EllisLab, Inc.
 * @license		http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 3.0
 * @filesource
 */

/**
 * CodeIgniter Wincache Caching Class
 *
 * Read more about Wincache functions here:
 * http://www.php.net/manual/en/ref.wincache.php
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Core
 * @author		Mike Murkovic
 * @link
 */
class CI_Cache_wincache extends CI_Driver {

	/**
	 * Get
	 *
	 * Look for a value in the cache. If it exists, return the data,
	 * if not, return FALSE
	 *
	 * @param	string
	 * @return	mixed	value that is stored/FALSE on failure
	 */
	public function get($id)
	{
		$success = FALSE;
		$data = wincache_ucache_get($id, $success);

		// Success returned by reference from wincache_ucache_get()
		return ($success) ? $data : FALSE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Cache Save
	 *
	 * @param	string	Unique Key
	 * @param	mixed	Data to store
	 * @param	int	Length of time (in seconds) to cache the data
	 * @return	bool	true on success/false on failure
	 */
	public function save($id, $data, $ttl = 60)
	{
		return wincache_ucache_set($id, $data, $ttl);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete from Cache
	 *
	 * @param	mixed	unique identifier of the item in the cache
	 * @return	bool	true on success/false on failure
	 */
	public function delete($id)
	{
		return wincache_ucache_delete($id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Clean the cache
	 *
	 * @return	bool	false on failure/true on success
	 */
	public function clean()
	{
		return wincache_ucache_clear();
	}

	// ------------------------------------------------------------------------

	/**
	 * Cache Info
	 *
	 * @return	mixed	array on success, false on failure
	 */
	 public function cache_info()
	 {
		 return wincache_ucache_info(TRUE);
	 }

	// ------------------------------------------------------------------------

	/**
	 * Get Cache Metadata
	 *
	 * @param	mixed	key to get cache metadata on
	 * @return	mixed	array on success/false on failure
	 */
	public function get_metadata($id)
	{
		if ($stored = wincache_ucache_info(FALSE, $id))
		{
			$age = $stored['ucache_entries'][1]['age_seconds'];
			$ttl = $stored['ucache_entries'][1]['ttl_seconds'];
			$hitcount = $stored['ucache_entries'][1]['hitcount'];

			return array(
				'expire'    => $ttl - $age,
				'hitcount'  => $hitcount,
				'age'       => $age,
				'ttl'       => $ttl
			);
		}

		return FALSE;
	}

	// ------------------------------------------------------------------------

	/**
	 * is_supported()
	 *
	 * Check to see if WinCache is available on this system, bail if it isn't.
	 *
	 * @return	bool
	 */
	public function is_supported()
	{
		if ( ! extension_loaded('wincache'))
		{
			log_message('error', 'The Wincache PHP extension must be loaded to use Wincache Cache.');
			return FALSE;
		}

		return TRUE;
	}

}

/* End of file Cache_wincache.php */
/* Location: ./system/libraries/Cache/drivers/Cache_wincache.php */