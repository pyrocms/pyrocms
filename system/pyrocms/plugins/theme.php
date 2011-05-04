<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Theme Plugin
 *
 * Load partials and access data
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2011, PyroCMS
 *
 */
class Plugin_Theme extends Plugin
{
	/**
	 * Partial
	 *
	 * Loads a theme partial
	 * 
	 * Usage:
	 * {pyro:theme:partial file="header"}
	 *
	 * @param	array
	 * @return	array
	 */
	function partial()
	{
		$name = $this->attribute('name');
		$name = $this->attribute('file', $name); #deprecated

		$data =& $this->load->_ci_cached_vars;

		return $this->parser->parse_string($this->load->_ci_load(array(
			'_ci_path' => $data['template_views'].'partials/'.$name.'.html',
			'_ci_return' => TRUE
		)), $data, TRUE, TRUE);
	}

	function path()
	{
		$data =& $this->load->_ci_cached_vars;
		$path = rtrim($data['template_views'], '/');
		return preg_replace('#(\/views(\/web|\/mobile)?)$#', '', $path).'/';
	}

	/**
	 * Theme CSS
	 *
	 * Insert a CSS tag from the theme
	 *
	 * Usage:
	 *
	 * {pyro:theme:css file=""}
	 *
	 * @param	array
	 * @return	array
	 */
	function css()
	{
		$this->load->library('asset');
		
		$file = $this->attribute('file');
		$attributes = $this->attributes();
		unset($attributes['file']);

		return $this->asset->css($file, '_theme_', $attributes);
	}

	/**
	 * Theme Image
	 *
	 * Insert a image tag from the theme
	 *
	 * Usage:
	 *
	 * {pyro:theme:image file=""}
	 *
	 * @param	array
	 * @return	array
	 */
	function image()
	{
		$this->load->library('asset');

		$file = $this->attribute('file');
		$attributes = $this->attributes();
		unset($attributes['file']);

		return $this->asset->image($file, '_theme_', $attributes);
	}

	/**
	 * Theme JS
	 *
	 * Insert a JS tag from the theme
	 *
	 * Usage:
	 *
	 * {pyro:theme:js file=""}
	 *
	 * @param	array
	 * @return	array
	 */
	function js()
	{
		$this->load->library('asset');

		$file = $this->attribute('file');

		return $this->asset->js($file, '_theme_');
	}

	/**
	 *
	 * Set and get theme variables
	 *
	 * Usage:
	 * {pyro:theme:variables name="foo"}
	 *
	 * @param	array
	 * @return	array
	 */
	public function variables()
	{
		if ( ! isset($variables))
		{
			static $variables = array();
		}

		$name = $this->attribute('name');
		$value = $this->attribute('value');

		if ($value !== NULL)
		{
			$variables[$name] = $value;
			return;
		}

		return $variables[$name];
	}

	function js_url()
	{
		$this->load->library('asset');

		$file = $this->attribute('file');

		return $this->asset->js_url($file, '_theme_');
	}

	/**
	 * Theme Favicon
	 *
	 * Insert a link tag for favicon from your theme
	 *
	 * Usage:
	 *
	 * {pyro:theme:favicon file="" [rel="foo"] [type="bar"]}
	 *
	 * @param	array
	 * @return	array
	 */
	public function favicon()
	{
		$base = $this->attribute('base', 'path');

		if ($base === 'path')
		{
			$theme_path = $this->template->get_theme_path();
			$file = BASE_URI . $theme_path . $this->attribute('file', 'favicon.ico');
		}
		elseif ($base === 'url')
		{
			$this->load->library('asset');
			$file = $this->asset->image_url($this->attribute('file', 'favicon.ico'), '_theme_');
		}

		$rel		= $this->attribute('rel', 'shortcut icon');
		$type		= $this->attribute('type', 'image/x-icon');
		$is_xhtml	= in_array($this->attribute('xhtml', 'true'), array('1','y','yes','true'));

		$link = '<link ';
		$link .= 'href="' . $file . '" ';
		$link .= 'rel="' . $rel . '" ';
		$link .= 'type="' . $type . '" ';
		$link .= ($is_xhtml ? '/' : '') . '>';

		return $link;
	}
}

/* End of file theme.php */
