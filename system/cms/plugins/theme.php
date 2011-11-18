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
	public static $options = null;
	
	/**
	 * Constructor
	 *
	 * Set options for this plugin
	 */
	public function __construct()
	{
		// Use this class statically to store stuff
		if (is_null(Plugin_Theme::$options))
		{
			$options = $this->pyrocache->model('themes_m', 'get_options_by', array(array('theme' => $this->theme->slug)));
			
			if ($options)
			{
				Plugin_Theme::$options = array();
				foreach ($options as $option)
				{
					// Assign it so THIS tag can use it
					$this->{$option->slug} = $option->value;
					
					// Save it for the next instance of this plugin
					Plugin_Theme::$options[$option->slug] = $option->value;
				}
			}
		}
		
		// Already got stuff, so assign it to this tag instance
		else
		{
			foreach (Plugin_Theme::$options as $slug => $value)
			{
				$this->{$slug} = $value;
			}
		}
	}
	
	/**
	 * Partial
	 *
	 * Loads a theme partial
	 *
	 * Usage:
	 * {{ theme:partial file="header" }}
	 *
	 * @param	array
	 * @return	array
	 */
	public function partial()
	{
		$name = $this->attribute('name');
		$name = $this->attribute('file', $name); #deprecated 2.0

		$path =& $this->load->get_var('template_views');
		$data = $this->load->_ci_cached_vars;

		return $this->parser->parse_string($this->load->_ci_load(array(
			'_ci_path' => $path.'partials/'.$name.'.html',
			'_ci_return' => TRUE
		)), $data, TRUE, TRUE);
	}
	
	/**
	 * Path
	 *
	 * Get the path to the theme
	 *
	 * Usage:
	 * {{ theme:partial file="header" }}
	 *
	 * @param	array
	 * @return	array
	 */
	public function path()
	{
		$path =& rtrim($this->load->get_var('template_views'), '/');
		return preg_replace('#(\/views(\/web|\/mobile)?)$#', '', $path).'/';
	}

	/**
	 * Theme CSS
	 *
	 * Insert a CSS tag with location based for url or path from the theme or module
	 *
	 * Usage:
	 *
	 * {{ theme:css file="" }}
	 *
	 * @param	array
	 * @return	array
	 */
	public function css($return = '')
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
	 * {{ theme:css_url file="" }}
	 *
	 * @param	array
	 * @return	string The css location url
	 */
	public function css_url()
	{
		return $this->css('url');
	}

	/**
	 * Theme CSS PATH
	 *
	 * Usage:
	 *
	 * {{ theme:css_path file="" }}
	 *
	 * @param	array
	 * @return	string The css location path
	 */
	public function css_path()
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
	 * {{ theme:image file="" }}
	 *
	 * @param	array
	 * @return	array
	 */
	public function image($return = '')
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
	 * {{ theme:image_url file="" }}
	 *
	 * @param	array
	 * @return	string The image location url
	 */
	public function image_url()
	{
		return $this->image('url');
	}

	/**
	 * Theme Image PATH
	 *
	 * Usage:
	 *
	 * {{ theme:image_path file="" }}
	 *
	 * @param	array
	 * @return	string The image location path
	 */
	public function image_path()
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
	 * {{ theme:js file="" }}
	 *
	 * @param	array
	 * @return	array
	 */
	public function js($return = '')
	{
		$this->load->library('asset');

		$file	= $this->attribute('file');
		$attributes	= $this->attributes();
		$module	= $this->attribute('module', '_theme_');
		$method	= 'js' . (in_array($return, array('url', 'path')) ? '_' . $return : ($return = ''));
		$base	= $this->attribute('base', '');
		

		foreach (array('file', 'module', 'base') as $key)
		{
			if (isset($attributes[$key]))
			{
				unset($attributes[$key]);
			}
		}

		if ( ! $return)
		{
			return $this->asset->{$method}($file, $module, $attributes, $base);
		}

		return $this->asset->{$method}($file, $module, $attributes);
	}

	/**
	 * Theme JS URL
	 *
	 * Usage:
	 *
	 * {{ theme:js_url file="" }}
	 *
	 * @param	array
	 * @return	string The js location url
	 */
	public function js_url()
	{
		return $this->js('url');
	}


	/**
	 * Theme JS PATH
	 *
	 * Usage:
	 *
	 * {{ theme:js_path file="" }}
	 *
	 * @param	array
	 * @return	string The js location path
	 */
	public function js_path()
	{
		return $this->js('path');
	}

	/**
	 *
	 * Set and get theme variables
	 *
	 * Usage:
	 * {{ theme:variables name="foo" }}
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
	 * {{ theme:favicon file="" [rel="foo"] [type="bar"] }}
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