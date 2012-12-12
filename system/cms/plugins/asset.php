<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Asset Plugin
 *
 * Load and print asset data
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Plugins
 */
class Plugin_Asset extends Plugin
{

	public $version = '1.0';
	public $name = array(
		'en' => 'Asset',
	);
	public $description = array(
		'en' => 'Access to static content such as CSS or Javascript file assets.',
		'el' => 'Πρόσβαση σε στατικό περιεχόμενο όπως αρχεία CSS ή Javascript.',
		'fr' => 'Accéder à des ressources CSS et Javascript (Assets).'
	);

	/**
	 * Asset CSS
	 *
	 * Insert a CSS tag
	 *
	 * Usage:
	 *
	 * {{ asset:css file="" group="" }}
	 *
	 * @return string Full url to css asset
	 */
	public function css()
	{
		$file = $this->attribute('file');
		$file_min = $this->attribute('file_min');
		$group = $this->attribute('group');

		return Asset::css($file, $file_min, $group);
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
	 * @return string Full url to CSS asset
	 */
	public function css_url()
	{
		$file = $this->attribute('file');

		return Asset::get_filepath_css($file, true);
	}

	/**
	 * Asset CSS Path
	 *
	 * Generate CSS asset path locations.
	 *
	 * Usage:
	 *
	 * {{ asset:css_path file="" }}
	 *
	 * @return string Path to the CSS asset relative to web root
	 */
	public function css_path()
	{
		$file = $this->attribute('file');

		return BASE_URI . Asset::get_filepath_css($file, false);
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
	 * @return array Full url to image asset
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
	 * @return string Full url to image asset
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
	 * @return string Path to the image asset relative to web root
	 */
	public function image_path()
	{
		$file = $this->attribute('file');

		return BASE_URI . Asset::get_filepath_img($file, false);
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
	 * @return string
	 */
	public function js()
	{
		$file = $this->attribute('file');
		$file_min = $this->attribute('file_min');
		$group = $this->attribute('group');

		return Asset::js($file, $file_min, $group);
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
	 * @return string Full url to the Javascript asset
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
	 * @return string Path to the JavaScript asset relative to web root
	 */
	public function js_path()
	{
		$file = $this->attribute('file');

		return BASE_URI . Asset::get_filepath_js($file, false);
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
	 * @return string Style and script tags for CSS and Javascript
	 */
	public function render()
	{
		$group = $this->attribute('group', false);

		return Asset::render($group);
	}

	/**
	 * Asset Render CSS
	 *
	 * Render a CSS asset group.
	 *
	 * Usage:
	 *
	 * {{ asset:render_css group="" }}
	 *
	 * @return string Style tags for CSS
	 */
	public function render_css()
	{
		$group = $this->attribute('group', false);

		return Asset::render_css($group);
	}

	/**
	 * Asset Render Javascript
	 *
	 * Render a Javascript asset group.
	 *
	 * Usage:
	 *
	 * {{ asset:render_js group="" }}
	 *
	 * @return string Script tags for Javascript
	 */
	public function render_js()
	{
		$group = $this->attribute('group', false);

		return Asset::render_js($group);
	}

}