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


/**
  * General Asset Helper
  *
  * Helps generate links to asset files of any sort. Asset type should be the
  * name of the folder they are stored in.
  *
  * @access		public
  * @param		string    the name of the file or asset
  * @param		string    the asset type (name of folder)
  * @param		string    optional, module name
  * @return		string    full url to asset
  */

function other_asset_url($asset_name, $module_name = NULL, $asset_type = NULL)
{
	$obj =& get_instance();
	$base_url = '/';//$obj->config->item('base_url');
	
	// If they are using a direct path, take them to it
	if(strpos($asset_name, 'assets/') !== FALSE)	{
		$asset_location = $base_url.'/'.$asset_name;
		
	// If they have just given a filename, not an asset path, and its in a theme
	} elseif($module_name == '_theme_') {
		
		$asset_location = $base_url.'themes/'.$obj->settings->item('default_theme').'/';
		$asset_location .= $asset_type.'/'.$asset_name;
	
	// Normal file (that might be in a module)
	} else {
		
		$asset_location = $base_url;
	
		// Its in a module, ignore the current 
		if($module_name && $module_name != '_theme_') {
			$asset_location .= 'modules/'.$module_name.'/';
		} else {
			$asset_location .= 'assets/';
		}
		
		$asset_location .= $asset_type.'/'.$asset_name;
	
	}
	
	return $asset_location;

}


// ------------------------------------------------------------------------

/**
  * Parse HTML Attributes
  *
  * Turns an array of attributes into a string
  *
  * @access		public
  * @param		array		attributes to be parsed
  * @return		string 		string of html attributes
  */

function _parse_asset_html($attributes = NULL)
{

	if(is_array($attributes)):
		$attribute_str = '';

		foreach($attributes as $key => $value):
			$attribute_str .= ' '.$key.'="'.$value.'"';
		endforeach;

		return $attribute_str;
	endif;

	return '';
}

// ------------------------------------------------------------------------

/**
  * CSS Asset Helper
  *
  * Helps generate CSS asset locations.
  *
  * @access		public
  * @param		string    the name of the file or asset
  * @param		string    optional, module name
  * @return		string    full url to css asset
  */

function css_url($asset_name, $module_name = NULL)
{
	return other_asset_url($asset_name, $module_name, 'css');
}


// ------------------------------------------------------------------------

/**
  * CSS Asset HTML Helper
  *
  * Helps generate JavaScript asset locations.
  *
  * @access		public
  * @param		string    the name of the file or asset
  * @param		string    optional, module name
  * @param		string    optional, extra attributes
  * @return		string    HTML code for JavaScript asset
  */

function css($asset_name, $module_name = NULL, $attributes = array())
{
	$attribute_str = _parse_asset_html($attributes);

	return '<link href="'.css_url($asset_name, $module_name).'" rel="stylesheet" type="text/css"'.$attribute_str.' />'."\n";
}

// ------------------------------------------------------------------------

/**
  * Image Asset Helper
  *
  * Helps generate CSS asset locations.
  *
  * @access		public
  * @param		string    the name of the file or asset
  * @param		string    optional, module name
  * @return		string    full url to image asset
  */

function image_url($asset_name, $module_name = NULL)
{
	return other_asset_url($asset_name, $module_name, 'img');
}


// ------------------------------------------------------------------------

/**
  * Image Asset HTML Helper
  *
  * Helps generate image HTML.
  *
  * @access		public
  * @param		string    the name of the image
  * @param		string    optional, module name
  * @param		string    optional, extra attributes
  * @return		string    HTML code for image asset
  */

function image($asset_name, $module_name = '', $attributes = array())
{
	// No alternative text given? Use the filename, better than nothing!
	if(empty($attributes['alt'])) list($attributes['alt']) = explode('.', $asset_name);
	
	$attribute_str = _parse_asset_html($attributes);

	return '<img src="'.image_url($asset_name, $module_name).'"'.$attribute_str.' />'."\n";
}


// ------------------------------------------------------------------------

/**
  * JavaScript Asset URL Helper
  *
  * Helps generate JavaScript asset locations.
  *
  * @access		public
  * @param		string    the name of the file or asset
  * @param		string    optional, module name
  * @return		string    full url to JavaScript asset
  */

function js_url($asset_name, $module_name = NULL)
{
	return other_asset_url($asset_name, $module_name, 'js');
}


// ------------------------------------------------------------------------

/**
  * JavaScript Asset HTML Helper
  *
  * Helps generate JavaScript asset locations.
  *
  * @access		public
  * @param		string    the name of the file or asset
  * @param		string    optional, module name
  * @return		string    HTML code for JavaScript asset
  */

function js($asset_name, $module_name = NULL)
{
	return '<script type="text/javascript" src="'.js_url($asset_name, $module_name).'"></script>'."\n";
}

?>