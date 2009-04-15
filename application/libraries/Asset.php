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
* Code Igniter Asset Library
*
* @package		CodeIgniter
* @subpackage	Libraries
* @category		Libraries
* @author       Philip Sturgeon < email@philsturgeon.co.uk >
*/

// ------------------------------------------------------------------------

class Asset {
	
	private $app_web_path;
	
	private $CI;
	
	function __construct()
	{
		$this->CI =& get_instance();
		
		// DOCUMENT_ROOT will show a full path to the index file
		if( isset($_SERVER['DOCUMENT_ROOT']) )
		{
			// This show the web root path for loading assets
			$this->app_web_path = defined('APPPATH_URI') ? APPPATH_URI : '/';
		}
		
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
		$attribute_str = $this->_parse_asset_html($attributes);
	
		return '<link href="'.$this->css_path($asset_name, $module_name).'" rel="stylesheet" type="text/css"'.$attribute_str.' />'."\n";
	}
	

	// ------------------------------------------------------------------------
	
	/**
	  * CSS Asset Path Helper
	  *
	  * Generate CSS asset web path locations.
	  *
	  * @access		public
	  * @param		string    the name of the file or asset
	  * @param		string    optional, module name
	  * @return		string    full url to css asset
	  */
	
	function css_path($asset_name, $module_name = NULL)
	{
		return $this->other_asset_path($asset_name, $module_name, 'css');
	}
	

	// ------------------------------------------------------------------------
	
	/**
	  * CSS Asset URL Helper
	  *
	  * Generate CSS asset URL location.
	  *
	  * @access		public
	  * @param		string    the name of the file or asset
	  * @param		string    optional, module name
	  * @return		string    full url to css asset
	  */
	
	function css_url($asset_name, $module_name = NULL)
	{
		return $this->other_asset_url($asset_name, $module_name, 'css');
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
		
		$attribute_str = $this->_parse_asset_html($attributes);
	
		return '<img src="'.$this->image_path($asset_name, $module_name).'"'.$attribute_str.' />'."\n";
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
	
	function image_path($asset_name, $module_name = NULL)
	{
		return $this->other_asset_path($asset_name, $module_name, 'img', 'path');
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
		return $this->other_asset_url($asset_name, $module_name, 'img');
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
		return '<script type="text/javascript" src="'.$this->js_path($asset_name, $module_name).'"></script>'."\n";
	}

	// ------------------------------------------------------------------------
	
	/**
	  * JavaScript Asset Path Helper
	  *
	  * Helps generate JavaScript asset locations.
	  *
	  * @access		public
	  * @param		string    the name of the file or asset
	  * @param		string    optional, module name
	  * @return		string    web root path to JavaScript asset
	  */
	
	function js_path($asset_name, $module_name = NULL)
	{
		return $this->other_asset_path($asset_name, $module_name, 'js');
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
		return $this->other_asset_url($asset_name, $module_name, 'js');
	}
	
	
	// ------------------------------------------------------------------------
	
	/**
	  * General Asset HTML Helper
	  *
	  * The main asset location generator
	  *
	  * @access		public
	  * @param		string    the name of the file or asset
	  * @param		string    optional, module name
	  * @return		string    HTML code for JavaScript asset
	  */

	public function other_asset_path($asset_name, $module_name = NULL, $asset_type = NULL)
	{
		return $this->_other_asset_location($asset_name, $module_name, $asset_type, 'path');
	}
	
	
	public function other_asset_url($asset_name, $module_name = NULL, $asset_type = NULL)
	{
		return $this->_other_asset_location($asset_name, $module_name, $asset_type, 'url');
	}
	
	private function _other_asset_location($asset_name, $module_name = NULL, $asset_type = NULL, $location_type = 'url')
	{
		
		// If they are using a direct path, take them to it
		if(strpos($asset_name, 'assets/') !== FALSE)
		{
			$asset_location = $this->app_web_path.$asset_name;
		}
		
		// If they have just given a filename, not an asset path, and its in a theme
		elseif($module_name == '_theme_')
		{
			$asset_location = $this->app_web_path.'themes/'
							. $this->CI->settings->item('default_theme').'/'
							. $asset_type.'/'.$asset_name;
		}
		
		// Normal file (that might be in a module)
		else
		{
			$asset_location = $this->app_web_path;
		
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
	
	private function _parse_asset_html($attributes = NULL)
	{
		$attribute_str = '';
			
		if(is_array($attributes))
		{
			foreach($attributes as $key => $value)
			{
				$attribute_str .= ' '.$key.'="'.$value.'"';
			}
		}
	
		return $attribute_str;
	}
	
}

?>