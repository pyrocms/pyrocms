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


function css($asset_name, $attributes = array())
{
	return Asset::css($asset_name, $attributes);
}

function theme_css($asset, $attributes = array())
{
	return css($asset, $attributes);
}

// ------------------------------------------------------------------------


function image($asset_name, $attributes = array())
{
	return Asset::img($asset_name, NULL, $attributes);
}

function theme_image($asset, $attributes = array())
{
	return image($asset, $attributes);
}

// ------------------------------------------------------------------------


function js($asset_name, $attributes = array())
{
	return Asset::js($asset_name, $attributes);
}

function theme_js($asset, $attributes = array())
{
	return js($asset, $attributes);
}
