<?php defined('BASEPATH') OR exit('No direct script access allowed');

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
 * CodeIgniter Asset Library
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category		Libraries
 * @author       Philip Sturgeon < email@philsturgeon.co.uk >
 */
class Asset {

	private $theme = NULL;
	private $_ci;

	function __construct()
	{
		$this->_ci = &get_instance();

		$this->_ci->load->config('asset');
	}

	// ------------------------------------------------------------------------

	/**
	 * CSS
	 *
	 * Helps generate CSS asset HTML.
	 *
	 * @access		public
	 * @param		string    the name of the file or asset
	 * @param		string    optional, module name
	 * @param		string    optional, extra attributes
	 * @return		string    HTML code for JavaScript asset
	 */
	public function css($asset_name, $module_name = NULL, $attributes = array(), $location_type = '')
	{
		$attribute_str = $this->_parse_asset_html($attributes);

		if ( ! preg_match('/rel="([^\"]+)"/', $attribute_str))
		{
			$attribute_str .= ' rel="stylesheet"';
		}

		$location_type = 'css_' . (in_array($location_type, array('url', 'path')) ? $location_type : 'path');

		return '<link href="' . $this->{$location_type}($asset_name, $module_name) . '" type="text/css"' . $attribute_str . ' />';
	}

	// ------------------------------------------------------------------------

	/**
	 * CSS Path
	 *
	 * Generate CSS asset path locations.
	 *
	 * @access		public
	 * @param		string    the name of the file or asset
	 * @param		string    optional, module name
	 * @return		string    full url to css asset
	 */
	public function css_path($asset_name, $module_name = NULL)
	{
		return $this->_asset_path($asset_name, $module_name, config_item('asset_css_dir'));
	}

	// ------------------------------------------------------------------------

	/**
	 * CSS URL
	 *
	 * Generate CSS asset URLs.
	 *
	 * @access		public
	 * @param		string    the name of the file or asset
	 * @param		string    optional, module name
	 * @return		string    full url to css asset
	 */
	public function css_url($asset_name, $module_name = NULL)
	{
		return $this->_asset_url($asset_name, $module_name, config_item('asset_css_dir'));
	}

	// ------------------------------------------------------------------------

	/**
	 * Image
	 *
	 * Helps generate image HTML.
	 *
	 * @access		public
	 * @param		string    the name of the image
	 * @param		string    optional, module name
	 * @param		string    optional, extra attributes
	 * @return		string    HTML code for image asset
	 */
	public function image($asset_name, $module_name = '', $attributes = array(), $location_type = '')
	{
		// No alternative text given? Use the filename, better than nothing!
		if (empty($attributes['alt']))
		{
			list($attributes['alt']) = explode('.', $asset_name);
		}

		$attribute_str	= $this->_parse_asset_html($attributes);
		$optional		= $location_type && (substr($location_type, -1) === '?') AND (($location_type = substr($location_type, 0, -1)) === 'path');
		$location_type	= 'image_' . (($optional OR in_array($location_type, array('url', 'path'))) ? $location_type : 'path');
		$location		= $this->{$location_type}($asset_name, $module_name);

		if ($optional && ! is_file(FCPATH . ltrim($location, '/')))
		{
			return '';
		}

		return '<img src="' . $location . '"' . $attribute_str . ' />';
	}

	// ------------------------------------------------------------------------

	/**
	 * Image Path
	 *
	 * Helps generate image paths.
	 *
	 * @access		public
	 * @param		string    the name of the file or asset
	 * @param		string    optional, module name
	 * @return		string    full url to image asset
	 */
	public function image_path($asset_name, $module_name = NULL)
	{
		return $this->_asset_path($asset_name, $module_name, config_item('asset_img_dir'), 'path');
	}

	// ------------------------------------------------------------------------

	/**
	 * Image URL
	 *
	 * Helps generate image URLs.
	 *
	 * @access		public
	 * @param		string    the name of the file or asset
	 * @param		string    optional, module name
	 * @return		string    full url to image asset
	 */
	public function image_url($asset_name, $module_name = NULL)
	{
		return $this->_asset_url($asset_name, $module_name, config_item('asset_img_dir'));
	}

	// ------------------------------------------------------------------------

	/**
	 * JS
	 *
	 * Helps generate JavaScript asset HTML.
	 *
	 * @access		public
	 * @param		string    the name of the file or asset
	 * @param		string    optional, module name
	 * @return		string    HTML code for JavaScript asset
	 */
	public function js($asset_name, $module_name = NULL, $location_type = '')
	{
		$location_type = 'js_' . (in_array($location_type, array('url', 'path')) ? $location_type : 'path');

		return '<script type="text/javascript" src="' . $this->{$location_type}($asset_name, $module_name) . '"></script>';
	}

	// ------------------------------------------------------------------------

	/**
	 * JS Path
	 *
	 * Helps generate JavaScript asset paths.
	 *
	 * @access		public
	 * @param		string    the name of the file or asset
	 * @param		string    optional, module name
	 * @return		string    web root path to JavaScript asset
	 */
	public function js_path($asset_name, $module_name = NULL)
	{
		return $this->_asset_path($asset_name, $module_name, config_item('asset_js_dir'));
	}

	// ------------------------------------------------------------------------

	/**
	 * JS URL
	 *
	 * Helps generate JavaScript asset locations.
	 *
	 * @access		public
	 * @param		string    the name of the file or asset
	 * @param		string    optional, module name
	 * @return		string    full url to JavaScript asset
	 */
	public function js_url($asset_name, $module_name = NULL)
	{
		return $this->_asset_url($asset_name, $module_name, config_item('asset_js_dir'));
	}

	// ------------------------------------------------------------------------

	/**
	 * General Asset HTML Helper
	 *
	 * The main asset location generator
	 *
	 * @access		private
	 * @param		string    the name of the file or asset
	 * @param		string    optional, module name
	 * @return		string    HTML code for JavaScript asset
	 */
	private function _asset_path($asset_name, $module_name = NULL, $asset_type = NULL)
	{
		return $this->_other_asset_location($asset_name, $module_name, $asset_type, 'path');
	}

	public function _asset_url($asset_name, $module_name = NULL, $asset_type = NULL)
	{
		return $this->_other_asset_location($asset_name, $module_name, $asset_type, 'url');
	}

	private function _other_asset_location($asset_name, $module_name = NULL, $asset_type = NULL, $location_type = 'url')
	{
		// Given a full URL
		if (strpos($asset_name, '://') !== FALSE OR strpos($asset_name, '//') === 0)
		{
			return $asset_name;
		}

		$base_location = config_item($location_type == 'url' ? 'asset_url' : 'asset_dir');

		// If they are using a direct path, take them to it
		if (strpos($asset_name, 'assets/') !== FALSE)
		{
			$asset_location = $base_location . $asset_name;
		}

		// If they have just given a filename, not an asset path, and its in a theme
		elseif ($module_name == '_theme_' AND $this->theme)
		{
			$base_location	= $location_type == 'url' ? rtrim(site_url(), '/') . '/' : BASE_URI;
			$asset_location	= $base_location . ltrim(config_item('theme_asset_dir'), '/')
				. $this->theme . '/'
				. $asset_type . '/' . $asset_name;
		}

		// Normal file (that might be in a module)
		else
		{
			$asset_location = $base_location;
			
			// we need to check if they are using the default admin theme or a Premium theme
			if (is_dir(APPPATH . 'themes/' . ADMIN_THEME))
			{
				$admin_path = APPPATH . 'themes/' . ADMIN_THEME . '/';
			}
			elseif (is_dir(SHARED_ADDONPATH . 'themes/' . ADMIN_THEME))
			{
				$admin_path = SHARED_ADDONPATH . 'themes/' . ADMIN_THEME . '/';
			}
			elseif (is_dir(ADDONPATH . 'themes/' . ADMIN_THEME))
			{
				$admin_path = ADDONPATH . 'themes/' . ADMIN_THEME . '/';
			}

			// It's in a module, ignore the current
			if ($module_name)
			{
				foreach (Modules::$locations as $path => $offset)
				{
					//to speed things up only check in the admin theme if we're on the admin panel
					if ($this->theme == ADMIN_THEME)
					{
						//check in the admin theme first for overloaded asset files
						if(is_file($admin_path . $asset_type . '/modules/' . $module_name . '/' . $asset_name))
						{
							$asset_location = BASE_URL . $admin_path . $asset_type . '/modules/' . $module_name . '/';
				
							//reset $asset_type so we don't have admin_theme/css/module/css folder structure
							$asset_type = '';
							
							break;
						}
						// nothing overloaded. The cat is on their back
						elseif (is_dir($path . $module_name))
						{
							$asset_location = BASE_URL . $path . $module_name . '/';
							break;
						}
					}
					else
					{
						if (is_dir($path . $module_name))
						{
							$base_location	= $location_type == 'url' ? rtrim(site_url(), '/') . '/' : BASE_URI;
							$asset_location = $base_location . $path . $module_name . '/';
							break;
						}
					}
				}
			}

			$asset_location .= ( $asset_type == '' ? '' : $asset_type . '/') . $asset_name;
		}

		return $asset_location;
	}

	// ------------------------------------------------------------------------

	/**
	 * Parse HTML Attributes
	 *
	 * Turns an array of attributes into a string
	 *
	 * @access		private
	 * @param		array		attributes to be parsed
	 * @return		string 		string of html attributes
	 */
	private function _parse_asset_html($attributes = NULL)
	{
		$attribute_str = '';

		if (is_string($attributes))
		{
			$attribute_str = $attributes;
		}
		else if (is_array($attributes) || is_object($attributes))
		{
			foreach ($attributes as $key => $value)
			{
				$attribute_str .= ' ' . $key . '="' . $value . '"';
			}
		}

		return $attribute_str;
	}

	// ------------------------------------------------------------------------

	/**
	 * Set theme
	 *
	 * If you use some sort of theme system, this method stores the theme name
	 *
	 * @access		public
	 * @param		string		theme name
	 */
	public function set_theme($theme)
	{
		$this->theme = $theme;
	}

}

// END Asset Class

/* End of file Asset.php */
/* Location: ./application/libraries/Asset.php */