<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Domains Helper
 *
 * @package		Domains Helper
 * @subpackage	Domains Module
 * @category	Helper
 * @author		Ryan Thompson - AI Web Systems, Inc.
 */

/**
 * Get the site's ID based on SITE_REF
 */
if(!function_exists('site_id'))
{
	function site_id()
	{
		// Get ready
		$CI = get_instance();

		// Run query
		$r = $CI->db->query("SELECT id FROM core_sites WHERE ref = '".$CI->db->escape_str(SITE_REF)."'")->result();

		return $r[0]->id;
	}
}