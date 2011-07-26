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
	 * Options
	 *
	 * Fetches a theme option
	 *
	 * Usage:
	 * {pyro:theme:options option="layout"}
	 *
	 * @param	string
	 */
	function options()
	{
		$option = $this->pyrocache->model('themes_m', 'get_option', array( array('slug' => $this->attribute('option')) ));

		return is_object($option) ? $option->value : NULL;
	}
	
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
	 * Insert a CSS tag with location based for url or path from the theme or module
	 *
	 * Usage:
	 *
	 * {pyro:theme:css file=""}
	 *
	 * @param	array
	 * @return	array
	 */
	function css($return = '')
	{
		$this->load->library('asset');
		
		$file		= $this->attribute('file');
		$attributes	= $this->attributes();
		$module		= $this->attribute('module', '_theme_');
		$method		= 'css' . (in_array($return, array('url', 'path')) ? '_' . $return : ($return = ''));
		$base		= $this->attribute('base', '');

		foreach (array('file', 'module', 'base') as $key)
		{
			if (isset($attributes[$key]))
			{
				unset($attributes[$key]);
			}
			else if ($key === 'file')
			{
				return '';
			}
		}

		if ( ! $return)
		{
			return $this->asset->{$method}($file, $module, $attributes, $base);
		}

		return $this->asset->{$method}($file, $module, $attributes);
	}

	/**
	 * Theme CSS URL
	 *
	 * Usage:
	 *
	 * {pyro:theme:css_url file=""}
	 *
	 * @param	array
	 * @return	string The css location url
	 */
	function css_url()
	{
		return $this->css('url');
	}

	/**
	 * Theme CSS PATH
	 *
	 * Usage:
	 *
	 * {pyro:theme:css_path file=""}
	 *
	 * @param	array
	 * @return	string The css location path
	 */
	function css_path()
	{
		return $this->css('path');
	}

	/**
	 * Theme Image
	 *
	 * Insert a image tag with location based for url or path from the theme or module
	 *
	 * Usage:
	 *
	 * {pyro:theme:image file=""}
	 *
	 * @param	array
	 * @return	array
	 */
	function image($return = '')
	{
		$this->load->library('asset');

		$file		= $this->attribute('file');
		$attributes	= $this->attributes();
		$module		= $this->attribute('module', '_theme_');
		$method		= 'image' . (in_array($return, array('url', 'path')) ? '_' . $return : ($return = ''));
		$base		= $this->attribute('base', '');

		foreach (array('file', 'module', 'base') as $key)
		{
			if (isset($attributes[$key]))
			{
				unset($attributes[$key]);
			}
			else if ($key === 'file')
			{
				return '';
			}
		}

		if ( ! $return)
		{
			return $this->asset->{$method}($file, $module, $attributes, $base);
		}

		return $this->asset->{$method}($file, $module, $attributes);
	}

	/**
	 * Theme Image URL
	 *
	 * Usage:
	 *
	 * {pyro:theme:image_url file=""}
	 *
	 * @param	array
	 * @return	string The image location url
	 */
	function image_url()
	{
		return $this->image('url');
	}

	/**
	 * Theme Image PATH
	 *
	 * Usage:
	 *
	 * {pyro:theme:image_path file=""}
	 *
	 * @param	array
	 * @return	string The image location path
	 */
	function image_path()
	{
		return $this->image('path');
	}

	/**
	 * Theme JS
	 *
	 * Insert a JS tag with location based for url or path from the theme or module
	 *
	 * Usage:
	 *
	 * {pyro:theme:js file=""}
	 *
	 * @param	array
	 * @return	array
	 */
	function js($return = '')
	{
		$this->load->library('asset');

		$file	= $this->attribute('file');
		$module	= $this->attribute('module', '_theme_');
		$method	= 'js' . (in_array($return, array('url', 'path')) ? '_' . $return : ($return = ''));
		$base	= $this->attribute('base', '');

		if ( ! $return)
		{
			return $this->asset->{$method}($file, $module, $base);
		}

		return $this->asset->{$method}($file, $module);
	}

	/**
	 * Theme JS URL
	 *
	 * Usage:
	 *
	 * {pyro:theme:js_url file=""}
	 *
	 * @param	array
	 * @return	string The js location url
	 */
	function js_url()
	{
		return $this->js('url');
	}


	/**
	 * Theme JS PATH
	 *
	 * Usage:
	 *
	 * {pyro:theme:js_path file=""}
	 *
	 * @param	array
	 * @return	string The js location path
	 */
	function js_path()
	{
		return $this->js('path');
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

		$name	= $this->attribute('name');
		$value	= $this->attribute('value');

		if ($value !== NULL)
		{
			$variables[$name] = $value;
			return;
		}

		return $variables[$name];
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
