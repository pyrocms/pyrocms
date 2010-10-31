<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Theme Plugin
 *
 * Load partials and access data
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2010, EllisLab, Inc.
 *
 */
class Plugin_Theme extends Plugin
{
	/**
	 * Partial
	 *
	 * Loads a theme partial
	 * Usage:
	 * {pyro:theme:partial file="header"}
	 *
	 * @param	array
	 * @return	array
	 */

	function partial()
	{
		$file = $this->attribute('file');

		$data =& $this->load->_ci_cached_vars;

		return $this->parser->parse_string($this->load->_ci_load(array(
			'_ci_path' => $data['template_views'].'partials/'.$file.'.html',
			'_ci_return' => TRUE
		)), $data, TRUE, TRUE);
	}

	/**
	 * Theme CSS
	 *
	 * Creates a list of news posts
	 *
	 * Usage:
	 * {pyro:theme:partial name=""}
	 *
	 * @param	array
	 * @return	array
	 */

	function css()
	{
		$file = $this->attribute('file');
		$attributes = $this->attributes();
		unset($attributes['file']);

		return theme_css($file, $attributes);
	}
}

/* End of file news.plugin.php */