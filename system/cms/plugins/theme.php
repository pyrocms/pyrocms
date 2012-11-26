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
	 * {{ theme:partial name="header" }}
	 *
	 * @return string The final rendered partial view.
	 */
	public function partial()
	{
		$name = $this->attribute('name');

		$path = $this->load->get_var('template_views');
		$data = $this->load->get_vars();

		$string = $this->load->file($path.'partials/'.$name.'.html', true);
		return $this->parser->parse_string($string, $data, true, true);
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
		$type = $this->attribute('type', 'text/css');
        $rel = $this->attribute('rel', 'stylesheet');

		return link_tag($this->css_url($file), $rel, $type, $title, $media);
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

    /**
     * Theme Language line
     *
     * Fetch a single line of text from the language array
     *
     * Usage:
     *   {{ theme:lang lang="theme" line="theme_title" [default="PyroCMS"] }}
     *
     * @return string.
     */
    public function lang()
    {
        $lang_file = $this->attribute('lang');
        $line = $this->attribute('line');
        $default = $this->attribute('default');
        // Return an empty string as the attribute LINE is missing
        if ( !isset($line) ) {
            return "";
        }

        $deft_lang = CI::$APP->config->item('language');
        if ($lang = Modules::load_file($lang_file.'_lang', CI::$APP->template->get_theme_path().'/language/'.$deft_lang.'/', 'lang'))
        {
            CI::$APP->lang->language = array_merge(CI::$APP->lang->language, $lang);
            CI::$APP->lang->is_loaded[] = $lang_file . '_lang'.EXT;
            unset($lang);
        }
        $value = $this->lang->line($line);

        return $value?$value:$default;
    }

	// --------------------------------------------------------------------------
	
	
	/**
	* 
	* return the body class for a layout
	* 
	* @param void
	* @return string
	*/
	// usage <body {{ theme:body_class }}>
	// returns class="page[ body_class][ layout_class]" for a pyro page
	// returns class="blog[ category_slug][ single]" for a pyro blog page
	// returns class="profile" for user-profile page
	// returns class="module module_slug" for a custom-module page
	function body_class()
	{ 
		$classes = array();
		 
		// use the cached vars to find what we need
		$data = & $this->load->_ci_cached_vars;
		
		if (!$this->uri->segment(1)) // no segments == homepage
		{
			array_push($classes, 'home', 'page');
			if (isset($data['page']->layout->body_class)) array_push($classes, $data['page']->layout->body_class);
			if (isset($data['page']->body_class)) array_push($classes, $data['page']->body_class);
		}
		else
		{
			switch($data['module_details']['slug'])
			{
			case 'pages':
				array_push($classes, 'page');
				if (isset($data['page']->layout->body_class)) array_push($classes, $data['page']->layout->body_class);
				if (isset($data['page']->body_class)) array_push($classes, $data['page']->body_class);
				break;
			
			case 'blog':
				array_push($classes, 'blog');
				
				if (isset($data['post'])) // on "permalink" page
				{
					array_push($classes, 'single', $data['post']->category->slug);
				}
				elseif (isset($data['category'])) // archive/index page for category
				{
					array_push($classes, 'category-index', $data['category']->slug);
				}
				break;
				
			case 'users':
				array_push($classes, 'profile');
				break;
				
			default: // custom module
				array_push($classes, 'module', $data['module_details']['slug']);
				break;
			}
		}
		
		$classes = array_filter(array_unique($classes));
		$classes = implode(' ', $classes);
		return 'class="' . $classes . '"';

	}
	
	// --------------------------------------------------------------------------
	
	/**
	 *
	 * return the page id for a page
	 * 
	 * @param void
	 * @return string
	 */
	// usage: <body {{ theme:body_id }}>
	// returns id="body_id | page_slug" for a pyro page
	// returns id="url_title(post_title)" for a blog "permalink" page, 
	//		id="category_slug-index" for a blog category index
	//		id="blog-index" for main blog index
	// returns id="segment_1" for users page
	// returns id="module_slug-[index]|[method_name]" for custom-module page 
	function body_id()
	{
		$id = '';
		
		$data = & $this->load->_ci_cached_vars;
				
		if (!$this->uri->segment(1))
		{
			$id = !empty($data['page']->body_id) ? $data['page']->body_id : 'home';	
		}
		else
		{
			switch($data['module_details']['slug'])
			{
			case 'pages':
				$id = !empty($data['page']->body_id) ? $data['page']->body_id : $data['page']->slug;
				break;
				
			case 'blog':
				if (isset($data['post']))
				{
					$id = url_title($data['post']->title, '-', true);
				}
				elseif (isset($data['category']))
				{
					$id = $data['category']->slug . '-index';
				}
				else
				{
					$id = 'blog-index';
				}
				break;
				
			case 'users':
				$id = $this->uri->segment(1);
				break;
				
			default: // custom module
				if ($this->uri->segment(2))
				{
					$id = $this->uri->segment(1) . '-' . $this->uri->segment(2);
				}
				else
				{
					$id = $this->uri->segment(1) . '-index';
				}
				break;			
			}			
		}
		
		return (!empty($id)) ? 'id="' . $id . '"' : '';
	}	 
}