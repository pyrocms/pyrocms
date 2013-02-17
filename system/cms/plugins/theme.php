<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Theme Plugin
 *
 * Load partials and access data
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Plugins
 */
class Plugin_Theme extends Plugin
{

	public $version = '1.1.0';
	public $name = array(
		'en' => 'Theme',
	);
	public $description = array(
		'en' => 'Load and display theme assets.',
		'el' => 'Φορτώνει και προβάλλει πόρους του θέματος εμφάνισης.',
		'fr' => 'Permet de charger et d\'afficher les différentes ressources du thème.',
		'it' => 'Carica e mostra gli asset del tema'
	);

	/**
	 * Returns a PluginDoc array that PyroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * All options are listed here but refer 
	 * to the Blog plugin for a larger example
	 *
	 * @todo fill the  array with details about this plugin, then uncomment the return value.
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'your_method' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Displays some data from some module.'
				),
				'single' => true,// will it work as a single tag?
				'double' => false,// how about as a double tag?
				'variables' => '',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(
					'order-dir' => array(// this is the order-dir="asc" attribute
						'type' => 'flag',// Can be: slug, number, flag, text, array, any.
						'flags' => 'asc|desc|random',// flags are predefined values like this.
						'default' => 'asc',// attribute defaults to this if no value is given
						'required' => false,// is this attribute required?
					),
					'limit' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '20',
						'required' => false,
					),
				),
			),// end first method
		);
	
		//return $info;
		return array();
	}

	/**
	 * Partial
	 *
	 * Loads a theme partial
	 *
	 * Usage:
	 *
	 *     {{ theme:partial name="header" any_random_data="foo" }}
	 *
	 * @return string The final rendered partial view.
	 */
	public function partial()
	{
		$attributes = $this->attributes();

		if (empty($attributes['name'])) {
			throw new Exception('Attributes must have a name="" attribute.');
		}

		$name = $attributes['name'];
		unset($attributes['name']);

		$path = $this->load->get_var('template_views');
		$data = array_merge($this->load->get_vars(), $attributes);

		$string = $this->load->file($path . 'partials/' . $name . '.html', true);

		return $this->parser->parse_string($string, $data, true, true);
	}

	/**
	 * Path
	 *
	 * Get the path to the theme
	 *
	 * Usage:
	 *
	 *     {{ theme:assets }}
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
	 *
	 *     {{ theme:path }}
	 *
	 * @return string The path to the theme (relative to web root).
	 */
	public function path()
	{
		$path = & rtrim($this->load->get_var('template_views'), '/');

		return preg_replace('#(\/views(\/web|\/mobile)?)$#', '', $path) . '/';
	}

	/**
	 * Theme CSS
	 *
	 * Insert a CSS tag with location based for url or path from the theme or module
	 *
	 * Usage:
	 *
	 *     {{ theme:css file="" }}
	 *
	 * @return string The link HTML tag for the stylesheets.
	 */
	public function css()
	{
		$file  = $this->attribute('file');
		$title = $this->attribute('title', ''); // CodeIgniter stupidly checks for '' not empty
		$media = $this->attribute('media', ''); // CodeIgniter stupidly checks for '' not empty
		$type  = $this->attribute('type', 'text/css');
		$rel   = $this->attribute('rel', 'stylesheet');

		return link_tag($this->css_url($file), $rel, $type, $title, $media);
	}

	/**
	 * Theme CSS URL
	 *
	 * Usage:
	 *
	 *     {{ theme:css_url file="" }}
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
	 *
	 *     {{ theme:image file="" }}
	 *
	 * @return string An empty string or the image tag.
	 */
	public function image()
	{
		$file       = $this->attribute('file');
		$alt        = $this->attribute('alt', $file);
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
	 *
	 *     {{ theme:image_url file="" }}
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
	 *
	 *     {{ theme:image_path file="" }}
	 *
	 * @return string The image location path
	 */
	public function image_path()
	{
		$file = $this->attribute('file');

		return BASE_URI . Asset::get_filepath_img($file, false);
	}

	/**
	 * Theme JS
	 *
	 * Insert a JS tag with location based for url or path from the theme or module
	 *
	 * Usage:
	 *
	 *     {{ theme:js file="" }}
	 *
	 * @param string $return Not used
	 *
	 * @return string An empty string or the script tag.
	 */
	public function js($return = '')
	{
		$file = $this->attribute('file');

		return '<script src="' . $this->js_url($file) . '" type="text/javascript"></script>';
	}

	/**
	 * Theme JS URL
	 *
	 * Usage:
	 *
	 *     {{ theme:js_url file="" }}
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
	 *
	 *     {{ theme:js_path file="" }}
	 *
	 * @return string The javascript asset location path.
	 */
	public function js_path()
	{
		$file = $this->attribute('file');

		return BASE_URI . Asset::get_filepath_js($file, false);
	}

	/**
	 * Set and get theme variables
	 *
	 * Usage:
	 *
	 *     {{ theme:variables name="foo" }}
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

		if ($value !== null)
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
     * Specs:
     *
     *     http://www.w3.org/TR/html5/links.html#rel-icon
     *
	 * Usage:
	 *
	 *     {{ theme:favicon file="" [rel="foo"] [type="bar"] [sizes="16x16 72x72 …"] }}
	 *
	 * @return string The link HTML tag for the favicon.
	 */
	public function favicon()
	{
		$this->load->library('asset');
		$file = Asset::get_filepath_img($this->attribute('file', 'favicon.ico'), true);

		$rel      = $this->attribute('rel', 'shortcut icon');
		$sizes    = $this->attribute('sizes', '');
		$type     = $this->attribute('type', 'image/x-icon');
		$is_xhtml = str_to_bool($this->attribute('xhtml', true));

		$link = '<link ';
		$link .= 'href="' . $file . '" ';
		$link .= 'rel="' . $rel . '" ';
		$link .= $sizes ? 'sizes="' . $sizes . '" ' : '';
		$link .= 'type="' . $type . '" ';
		$link .= ($is_xhtml ? '/' : '') . '>';

		return $link;
	}

	/**
	 * Theme Language line
	 *
	 * Fetch a single line of text from the language array
	 *
	 * Usage:
	 *
	 *     {{ theme:lang lang="theme" line="theme_title" [default="PyroCMS"] }}
	 *
	 * @return string.
	 */
	public function lang()
	{
		$lang_file = $this->attribute('lang');
		$line      = $this->attribute('line');
		$default   = $this->attribute('default');
		// Return an empty string as the attribute LINE is missing
		if ( ! isset($line))
		{
			return "";
		}

		$deft_lang = CI::$APP->config->item('language');
		if ($lang = Modules::load_file($lang_file . '_lang', CI::$APP->template->get_theme_path() . '/language/' . $deft_lang . '/', 'lang'))
		{
			CI::$APP->lang->language = array_merge(CI::$APP->lang->language, $lang);
			CI::$APP->lang->is_loaded[] = $lang_file . '_lang' . EXT;
			unset($lang);
		}
		$value = $this->lang->line($line);

		return $value ? $value : $default;
	}

}
