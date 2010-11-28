<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Theme Plugin
 *
 * Load partials and access data
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2010, PyroCMS
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
		return dirname($data['template_views']).'/';
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
	 * {pyro:theme:css file=""}
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
}

/* End of file theme.php */