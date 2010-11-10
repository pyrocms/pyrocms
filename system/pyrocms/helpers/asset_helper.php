<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Code Igniter
*
* An open source application development framework for PHP 4.3.2 or newer
*
* @package		CodeIgniter
* @author		Rick Ellis
* @copyright	Copyright (c) 2006, pMachine, Inc.
* @license		http://www.codeignitor.com/user_guide/license.html
* @link			http://www.codeigniter.com
* @since        Version 1.0
* @filesource
*/

// ------------------------------------------------------------------------

/**
* Code Igniter Asset Helpers
*
* @package		CodeIgniter
* @subpackage	Helpers
* @category		Helpers
* @author       Philip Sturgeon < email@philsturgeon.co.uk >
*/

// ------------------------------------------------------------------------


function css($asset_name, $module_name = NULL, $attributes = array())
{
	$CI =& get_instance();
	$CI->load->library('asset');
	return $CI->asset->css($asset_name, $module_name, $attributes);
}

function theme_css($asset, $attributes = array())
{
	return css($asset, '_theme_', $attributes);
}

function css_url($asset_name, $module_name = NULL)
{
	$CI =& get_instance();
	$CI->load->library('asset');
	return $CI->asset->css_url($asset_name, $module_name);
}

function css_path($asset_name, $module_name = NULL)
{
	$CI =& get_instance();
	$CI->load->library('asset');
	return $CI->asset->css_path($asset_name, $module_name);
}

// ------------------------------------------------------------------------


function image($asset_name, $module_name = NULL, $attributes = array())
{
	$CI =& get_instance();
	$CI->load->library('asset');
	return $CI->asset->image($asset_name, $module_name, $attributes);
}

function theme_image($asset, $attributes = array())
{
	return image($asset, '_theme_', $attributes);
}

function image_url($asset_name, $module_name = NULL)
{
	$CI =& get_instance();
	$CI->load->library('asset');
	return $CI->asset->image_url($asset_name, $module_name);
}

function image_path($asset_name, $module_name = NULL)
{
	$CI =& get_instance();
	$CI->load->library('asset');
	return $CI->asset->image_path($asset_name, $module_name);
}

// ------------------------------------------------------------------------


function js($asset_name, $module_name = NULL)
{
	$CI =& get_instance();
	$CI->load->library('asset');
	return $CI->asset->js($asset_name, $module_name);
}

function theme_js($asset)
{
	return js($asset, '_theme_');
}

function js_url($asset_name, $module_name = NULL)
{
	$CI =& get_instance();
	$CI->load->library('asset');
	return $CI->asset->js_url($asset_name, $module_name);
}

function js_path($asset_name, $module_name = NULL)
{
	$CI =& get_instance();
	$CI->load->library('asset');
	return $CI->asset->js_path($asset_name, $module_name);
}