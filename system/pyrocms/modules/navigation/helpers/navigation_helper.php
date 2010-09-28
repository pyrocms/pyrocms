<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 * Navigation helper
 *
 * @author Phil Sturgeon - PyroCMS Dev Team
 * @package PyroCMS
 * @subpackage Navigation Module
 * @category Module
 */

/**
 * Create a navigation menu (I believe...)
 * 
 * @param string $abbrev The link abbreviation
 * @return mixed
 */
function navigation($abbrev)
{
	$CI =& get_instance();
	
	$CI->load->model('navigation/navigation_m');

	return $CI->cache->model('navigation_m', 'load_group', $abbrev, $CI->settings->navigation_cache);
}

/**
 * Create a navigation menu with a tree structure
 *
 * @param string $abbrev The group abbreviation
 * @return mixed
 */
function navigation_tree($abbrev)
{
	$CI =& get_instance();

	$CI->load->model('navigation/navigation_m');

	return $CI->cache->model('navigation_m', 'load_group_tree', $abbrev, $CI->settings->navigation_cache);
}
