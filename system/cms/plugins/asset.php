<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Asset Plugin
 *
 * Load asset data
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2011, PyroCMS
 *
 */
class Plugin_Asset extends Plugin
{
	/**
	 * Asset CSS
	 *
	 * Insert a CSS tag
	 *
	 * Usage:
	 *
	 * {{ asset:css file="" group="" }}
	 *
	 * @param	array
	 * @return	array
	 */
	public function css()
	{
		$file = $this->attribute('file');
		$group = $this->attribute('group');

		return Asset::css($file, NULL, $group);
	}
	
	/**
	 * Asset CSS URL
	 *
	 * Generate CSS asset URLs.
	 *
	 * Usage:
	 *
	 * {{ asset:css_url file="" }}
	 *
	 * @param	array
	 * @return	string    full url to css asset
	 */
	public function css_url()
	{
		$file = $this->attribute('file');
		
		return Asset::get_filepath_js($file, true);
	}
	
	/**
	 * Asset CSS Path
	 *
	 * Generate CSS asset path locations.
	 *
	 * Usage:
	 *
	 * {{ asset:css_path file="" module="" }}
	 *
	 * @param	array
	 * @return	string    full url to css asset
	 */
	public function css_path()
	{
		$file = $this->attribute('file');

		return BASE_URI.Asset::get_filepath_js($file, FALSE);
	}

	/**
	 * Asset Image
	 *
	 * Insert a image tag
	 *
	 * Usage:
	 *
	 * {{ asset:image file="" alt="" }}
	 *
	 * @param	array
	 * @return	array
	 */
	public function image()
	{
		$file = $this->attribute('file');
		$alt = $this->attribute('alt');
		
		$attributes = $this->attributes();
		unset($attributes['file']);
		unset($attributes['alt']);

		return Asset::img($file, $alt, $attributes);
	}
	
	/**
	 * Asset Image URL
	 *
	 * Helps generate image URLs.
	 *
	 * Usage:
	 *
	 * {{ asset:image_url file="" }}
	 *
	 * @param	array
	 * @return	string    full url to image asset
	 */
	public function image_url()
	{
		$file = $this->attribute('file');

		return Asset::get_filepath_img($file, true);
	}
	
	/**
	 * Asset Image Path
	 *
	 * Helps generate image paths.
	 *
	 * Usage:
	 *
	 * {{ asset:image_path file="" }}
	 *
	 * @param	array
	 * @return	array
	 */
	public function image_path()
	{
		$file = $this->attribute('file');

		return BASE_URI.Asset::get_filepath_img($file, false);
	}

	/**
	 * Asset JS
	 *
	 * Insert a JS tag
	 *
	 * Usage:
	 *
	 * {{ asset:js file="" group="" }}
	 *
	 * @param	array
	 * @return	array
	 */
	public function js()
	{
		$file = $this->attribute('file');
		$module = $this->attribute('group');

		return Asset::js($file, NULL, $group);
	}
	
	/**
	 * Asset JS URL
	 *
	 * Helps generate JavaScript asset locations.
	 *
	 * Usage:
	 *
	 * {{ asset:js_url file="" }}
	 *
	 * @param	array
	 * @return	string    full url to JavaScript asset
	 */
	public function js_url()
	{
		$file = $this->attribute('file');

		return Asset::get_filepath_js($file, true);
	}
	
	/**
	 * Asset JS Path
	 *
	 * Helps generate JavaScript asset paths.
	 *
	 * Usage:
	 *
	 * {{ asset:js_path file="" }}
	 *
	 * @param	array
	 * @return	string    web root path to JavaScript asset
	 */
	public function js_path()
	{
		$file = $this->attribute('file');

		return BASE_URI.Asset::get_filepath_js($file, false);
	}
	
	/**
	 * Asset Render
	 *
	 * Render an asset group (of JS and/or CSS).
	 *
	 * Usage:
	 *
	 * {{ asset:render group="" }}
	 *
	 * @param	array
	 * @return	string    Style and script tags for css and js
	 */
	public function render()
	{
		$group = $this->attribute('group', false);

		return Asset::render($group);
	}
}

/* End of file asset.php */