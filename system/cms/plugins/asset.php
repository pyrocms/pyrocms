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
	 * {pyro:asset:css file="" module=""}
	 *
	 * @param	array
	 * @return	array
	 */
	function css()
	{
		$this->load->library('asset');
		
		$file = $this->attribute('file');
		$module = $this->attribute('module');
		$attributes = $this->attributes();
		unset($attributes['file']);
		unset($attributes['module']);

		return $this->asset->css($file, $module, $attributes);
	}
	
	/**
	 * Asset CSS URL
	 *
	 * Generate CSS asset URLs.
	 *
	 * Usage:
	 *
	 * {pyro:asset:css_url file="" module=""}
	 *
	 * @param	array
	 * @return	string    full url to css asset
	 */
	function css_url()
	{
		$this->load->library('asset');
		
		$file = $this->attribute('file');
		$module = $this->attribute('module');

		return $this->asset->css_url($file, $module);
	}
	
	/**
	 * Asset CSS Path
	 *
	 * Generate CSS asset path locations.
	 *
	 * Usage:
	 *
	 * {pyro:asset:css_path file="" module=""}
	 *
	 * @param	array
	 * @return	string    full url to css asset
	 */
	function css_path()
	{
		$this->load->library('asset');
		
		$file = $this->attribute('file');
		$module = $this->attribute('module');

		return $this->asset->css_path($file, $module);
	}

	/**
	 * Asset Image
	 *
	 * Insert a image tag
	 *
	 * Usage:
	 *
	 * {pyro:asset:image file="" module=""}
	 *
	 * @param	array
	 * @return	array
	 */
	function image()
	{
		$this->load->library('asset');

		$file = $this->attribute('file');
		$module = $this->attribute('module');
		$attributes = $this->attributes();
		unset($attributes['file']);
		unset($attributes['module']);

		return $this->asset->image($file, $module, $attributes);
	}
	
	/**
	 * Asset Image URL
	 *
	 * Helps generate image URLs.
	 *
	 * Usage:
	 *
	 * {pyro:asset:image_url file="" module=""}
	 *
	 * @param	array
	 * @return	string    full url to image asset
	 */
	function image_url()
	{
		$this->load->library('asset');

		$file = $this->attribute('file');
		$module = $this->attribute('module');

		return $this->asset->image_url($file, $module);
	}
	
	/**
	 * Asset Image Path
	 *
	 * Helps generate image paths.
	 *
	 * Usage:
	 *
	 * {pyro:asset:image_path file="" module=""}
	 *
	 * @param	array
	 * @return	array
	 */
	function image_path()
	{
		$this->load->library('asset');

		$file = $this->attribute('file');
		$module = $this->attribute('module');

		return $this->asset->image_path($file, $module);
	}

	/**
	 * Asset JS
	 *
	 * Insert a JS tag
	 *
	 * Usage:
	 *
	 * {pyro:asset:js file="" module=""}
	 *
	 * @param	array
	 * @return	array
	 */
	function js()
	{
		$this->load->library('asset');

		$file = $this->attribute('file');
		$module = $this->attribute('module');

		return $this->asset->js($file, $module);
	}
	
	/**
	 * Asset JS URL
	 *
	 * Helps generate JavaScript asset locations.
	 *
	 * Usage:
	 *
	 * {pyro:asset:js_url file="" module=""}
	 *
	 * @param	array
	 * @return	string    full url to JavaScript asset
	 */
	function js_url()
	{
		$this->load->library('asset');

		$file = $this->attribute('file');
		$module = $this->attribute('module');

		return $this->asset->js_url($file, $module);
	}
	
	/**
	 * Asset JS Path
	 *
	 * Helps generate JavaScript asset paths.
	 *
	 * Usage:
	 *
	 * {pyro:asset:js_path file="" module=""}
	 *
	 * @param	array
	 * @return	string    web root path to JavaScript asset
	 */
	function js_path()
	{
		$this->load->library('asset');

		$file = $this->attribute('file');
		$module = $this->attribute('module');

		return $this->asset->js_path($file, $module);
	}
}

/* End of file asset.php */