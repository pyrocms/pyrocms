<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Theme Plugin
 *
 * Load partials and access data
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Plugins
 */
class Plugin_Theme extends Plugin
{

	/**
	 * Partial
	 *
	 * Loads a theme partial
	 *
	 * Usage:
	 * {{ theme:partial file="header" }}
	 *
	 * @return string The final rendered partial view.
	 */
	public function partial()
	{
		$name = $this->attribute('name');

		$path = $this->load->get_var('template_views');
		$data = $this->load->get_vars();

		$string = $this->load->file($path.'partials/'.$name.'.html', TRUE);
		return $this->parser->parse_string($string, $data, TRUE, TRUE);
	}

	/**
	 * Path
	 *
	 * Get the path to the theme
	 *
	 * Usage:
	 * {{ theme:assets }}
	 *
	 * @return string The rendered assets (CSS/Js) for the theme.
	 */
	public function assets()
	{
		return Asset::render('theme');
	}

	/**
	 * Path
	 *
	 * Get the path to the theme
	 *
	 * Usage:
	 * {{ theme:path }}
	 *
	 * @return string The path to the theme (relative to web root).
	 */
	public function path()
	{
		$path = & rtrim($this->load->get_var('template_views'), '/');
		return preg_replace('#(\/views(\/web|\/mobile)?)$#', '', $path).'/';
	}

	/**
	 * Theme CSS
	 *
	 * Insert a CSS tag with location based for url or path from the theme or module
	 *
	 * Usage:
	 *  {{ theme:css file="" }}
	 *
	 * @return string The link HTML tag for the stylesheets.
	 */
	public function css()
	{
		$file = $this->attribute('file');
		$title = $this->attribute('title');
		$media = $this->attribute('media');

		return link_tag($this->css_url($file), 'stylesheet', 'text/css', $title, $media);
	}

	/**
	 * Theme CSS URL
	 *
	 * Usage:
	 *  {{ theme:css_url file="" }}
	 *
	 * @return string The CSS URL
	 */
	public function css_url()
	{
		$file = $this->attribute('file');
		return Asset::get_filepath_css($file, true);
	}

	/**
	 * Theme CSS PATH
	 *
	 * Usage:
	 *   {{ theme:css_path file="" }}
	 *
	 * @return string The CSS location path
	 */
	public function css_path()
	{
		$file = $this->attribute('file');
		return Asset::get_filepath_css($file, false);
	}

	/**
	 * Theme Image
	 *
	 * Insert a image tag with location based for url or path from the theme or module
	 *
	 * Usage:
	 *   {{ theme:image file="" }}
	 *
	 * @return string An empty string or the image tag.
	 */
	public function image()
	{
		$file = $this->attribute('file');
		$alt = $this->attribute('alt', $file);
		$attributes = $this->attributes();

		foreach (array('file', 'alt') as $key)
		{
			if (isset($attributes[$key]))
			{
				unset($attributes[$key]);
			}
			else if ($key == 'file')
			{
				return '';
			}
		}

		try
		{
			return Asset::img($file, $alt, $attributes);
		}
		catch (Asset_Exception $e)
		{
			return '';
		}
	}

	/**
	 * Theme Image URL
	 *
	 * Usage:
	 *   {{ theme:image_url file="" }}
	 *
	 * @return string The image URL
	 */
	public function image_url()
	{
		$file = $this->attribute('file');
		return Asset::get_filepath_img($file, true);
	}

	/**
	 * Theme Image PATH
	 *
	 * Usage:
	 *   {{ theme:image_path file="" }}
	 *
	 * @return string The image location path
	 */
	public function image_path()
	{
		$file = $this->attribute('file');
		return BASE_URI.Asset::get_filepath_img($file, false);
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
	 * @param string $return Not used
	 * @return string An empty string or the script tag.
	 */
	public function js($return = '')
	{
		$file = $this->attribute('file');
		return '<script src="'.$this->js_url($file).'" type="text/javascript"></script>';
	}

	/**
	 * Theme JS URL
	 *
	 * Usage:
	 *   {{ theme:js_url file="" }}
	 *
	 * @return string The javascript asset URL.
	 */
	public function js_url()
	{
		$file = $this->attribute('file');
		return Asset::get_filepath_js($file, true);
	}

	/**
	 * Theme JS PATH
	 *
	 * Usage:
	 *   {{ theme:js_path file="" }}
	 *
	 * @return string The javascript asset location path.
	 */
	public function js_path()
	{
		$file = $this->attribute('file');
		return BASE_URI.Asset::get_filepath_js($file, false);
	}

	/**
	 * Set and get theme variables
	 *
	 * Usage:
	 * {{ theme:variables name="foo" }}
	 *
	 * @return string The variable value.
	 */
	public function variables()
	{
		if (!isset($variables))
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

	/**
	 * Theme Favicon
	 *
	 * Insert a link tag for favicon from your theme
	 *
	 * Usage:
	 *   {{ theme:favicon file="" [rel="foo"] [type="bar"] }}
	 *
	 * @return string The link HTML tag for the favicon.
	 */
	public function favicon()
	{
		$this->load->library('asset');
		$file = Asset::get_filepath_img($this->attribute('file', 'favicon.ico'), true);

		$rel = $this->attribute('rel', 'shortcut icon');
		$type = $this->attribute('type', 'image/x-icon');
		$is_xhtml = in_array($this->attribute('xhtml', 'true'), array('1', 'y', 'yes', 'true'));

		$link = '<link ';
		$link .= 'href="'.$file.'" ';
		$link .= 'rel="'.$rel.'" ';
		$link .= 'type="'.$type.'" ';
		$link .= ($is_xhtml ? '/' : '').'>';

		return $link;
	}

}