<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Template Class
 *
 * Build your CodeIgniter pages much easier with partials, breadcrumbs, layouts and themes
 *
 * @package			CodeIgniter
 * @subpackage		Libraries
 * @category		Libraries
 * @author			Philip Sturgeon
 * @license			http://philsturgeon.co.uk/code/dbad-license
 * @link			http://philsturgeon.co.uk/code/codeigniter-template
 */
class Template
{
	private $_module = '';
	private $_controller = '';
	private $_method = '';

	private $_theme = null;
	private $_theme_path = null;
	private $_layout = false; // By default, dont wrap the view with anything
	private $_layout_subdir = ''; // Layouts and partials will exist in views/layouts
	// but can be set to views/foo/layouts with a subdirectory

	private $_title = '';
	private $_metadata = array();

	private $_partials = array();

	private $_breadcrumbs = array();

	private $_title_separator = ' | ';

	private $_parser_enabled = true;
	private $_parser_body_enabled = true;
	private $_minify_enabled = false;

	private $_theme_locations = array();

	private $_is_mobile = false;

	// Seconds that cache will be alive for
	private $cache_lifetime = 0;//7200;

	private $_ci;

	private $_data = array();

	/**
	 * Constructor - Sets Preferences
	 *
	 * The constructor can be passed an array of config values
	 */
	public function __construct($config = array())
	{
		$this->_ci =& get_instance();

		if ( ! empty($config))
		{
			$this->initialize($config);
		}

		log_message('debug', 'Template class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize preferences
	 *
	 * @param	array	$config
	 * @return	void
	 */
	public function initialize($config = array())
	{
		foreach ($config as $key => $val)
		{
			if ($key == 'theme' and $val != '')
			{
				$this->set_theme($val);
				continue;
			}

			$this->{'_'.$key} = $val;
		}

		// No locations set in config?
		if ($this->_theme_locations === array())
		{
			// Let's use this obvious default
			$this->_theme_locations = array(APPPATH . 'themes/');
		}

		// If the parse is going to be used, best make sure it's loaded
		if ($this->_parser_enabled === true)
		{
			$this->_ci->load->library('parser');
		}

		// Modular Separation / Modular Extensions has been detected
		if (method_exists( $this->_ci->router, 'fetch_module' ))
		{
			$this->_module = $this->_ci->router->fetch_module();
		}

		// What controllers or methods are in use
		$this->_controller	= $this->_ci->router->fetch_class();
		$this->_method 		= $this->_ci->router->fetch_method();

		// Load user agent library if not loaded
		$this->_ci->load->library('user_agent');

		// We'll want to know this later
		$this->_is_mobile = $this->_ci->agent->is_mobile();
	}

	// --------------------------------------------------------------------

	/**
	 * Set the module manually. Used when getting results from
	 * another module with Modules::run('foo/bar')
	 *
	 * @param	string	$module The module slug
	 * @return	mixed
	 */
	public function set_module($module)
	{
		$this->_module = $module;

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Magic Get function to get data
	 *
	 * @param	string	$name
	 * @return	mixed
	 */
	public function __get($name)
	{
		return isset($this->_data[$name]) ? $this->_data[$name] : null;
	}

	// --------------------------------------------------------------------

	/**
	 * Magic Set function to set data
	 *
	 * @param	string	$name
	 * @param	mixed	$value
	 * @return	mixed
	 */
	public function __set($name, $value)
	{
		$this->_data[$name] = $value;
	}

	// --------------------------------------------------------------------

	/**
	 * Set data using a chainable metod. Provide two strings or an array of data.
	 *
	 * @param	string	$name
	 * @param	mixed	$value
	 * @return	object	$this
	 */
	public function set($name, $value = null)
	{
		// Lots of things! Set them all
		if (is_array($name) or is_object($name))
		{
			foreach ($name as $item => $value)
			{
				$this->_data[$item] = $value;
			}
		}

		// Just one thing, set that
		else
		{
			$this->_data[$name] = $value;
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Build Template Data
	 *
	 * Gathers and builds a $template array
	 * with basic template data.
	 *
	 * @return 	array
	 */
	public function build_template_data()
	{
		// If we don't have a title, we'll take our best guess.
		// Everybody needs a title!
		if (empty($this->_title))
		{
			$this->_title = $this->_guess_title();
		}

		$template['title']			= strip_tags($this->_title);
		$template['page_title']		= $this->_title;
		$template['breadcrumbs']	= $this->_breadcrumbs;
		$template['metadata']		= $this->get_metadata() . Asset::render('extra') . $this->get_metadata('late_header');
		$template['partials']		= array();

		// Assign by reference, as all loaded views will need access to partials

		// Load this into our cached vars so plugins
		// can use it.
		$this->_ci->load->vars(array('template' => $template));

		return $template;
	}

	// --------------------------------------------------------------------

	/**
	 * Build the entire HTML output combining partials, layouts and views.
	 *
	 * @param	string	$view
	 * @param	array	$data
	 * @param	bool	$return
	 * @param	bool	$IE_cache
	 * @param 	bool 	$pre_parsed_view	Did we already parse our view?
	 * @return	string
	 */
	public function build($view, $data = array(), $return = false, $IE_cache = true, $pre_parsed_view = false, $template = array())
	{
		// Set whatever values are given. These will be available to all view files
		is_array($data) OR $data = (array) $data;

		// Merge in what we already have set
		$this->_data = array_merge($this->_data, $data);

		// We don't need you any more buddy
		unset($data);

		// If you want, you can use the build_template_data() 
		// to pre-build this template data. This is an edge case so you'll
		// probably always just leave it to array(), but it's here if
		// you need it.
		if ( ! $template) 
		{
			$template = $this->build_template_data();
		}

		$this->_data['template'] =& $template;

		// Process partials.
		foreach ($this->_partials as $name => $partial)
		{
			// We can only work with data arrays
			is_array($partial['data']) or $partial['data'] = (array) $partial['data'];

			// If it uses a view, load it
			if (isset($partial['view']))
			{
				$template['partials'][$name] = $this->_find_view($partial['view'], $partial['data']);
			}

			// Otherwise the partial must be a string
			else
			{
				if ($this->_parser_enabled === true)
				{
					$partial['string'] = $this->_ci->parser->parse_string($partial['string'], $this->_data + $partial['data'], true, true);
				}

				$template['partials'][$name] = $partial['string'];
			}
		}

		// Disable sodding IE7's constant cacheing!!
		// This is in a conditional because otherwise it errors when output is returned instead of output to browser.
		if ($IE_cache)
		{
			$this->_ci->output->set_header('Expires: Sat, 01 Jan 2000 00:00:01 GMT');
			$this->_ci->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
			$this->_ci->output->set_header('Cache-Control: post-check=0, pre-check=0, max-age=0');
			$this->_ci->output->set_header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
			$this->_ci->output->set_header('Pragma: no-cache');
		}

		// Let CI do the caching instead of the browser
		$this->cache_lifetime > 0 && $this->_ci->output->cache($this->cache_lifetime);

		// Set the _body var. If we have pre-parsed our
		// view, then our work is done. Otherwise, we will
		// find the view and parse it.
		if ($pre_parsed_view)
		{
			$this->_body = $view;
		}
		else
		{
			$this->_body = $this->_find_view($view, array(), $this->_parser_body_enabled);
		}

		// Want this file wrapped with a layout file?
		if ($this->_layout)
		{
			// Added to $this->_data['template'] by refference
			$template['body'] = $this->_body;

			if ($this->_parser_enabled)
			{
				// Persistent tags is an experiment to parse some tags after
				// parsing of all other tags, so the tag persistent should be:
				//
				// a) Defined only if depends of others tags
				// b) Plugin that is a callback, so could retrieve runtime data.
				// c) Returned with a content parsed
				$this->_data['_tags']['persistent_tags'][] = 'template:metadata';
			}

			// Find the main body and 3rd param means parse if its a theme view (only if parser is enabled)
			$this->_body = self::_load_view('layouts/'.$this->_layout, $this->_data, true, self::_find_view_folder());
		}

		if ($this->_minify_enabled && function_exists('process_data_jmr1'))
		{
			$this->_body = process_data_jmr1($this->_body);
		}
		
		// Now that *all* parsing is sure to be done we inject the {{ noparse }} contents back into the output
		if (class_exists('Lex_Parser'))
		{
			$this->_body = Lex_Parser::inject_noparse($this->_body);
		}

		// Want it returned or output to browser?
		if ( ! $return)
		{
			$this->_ci->output->set_output($this->_body);
		}

		return $this->_body;
	}

	/**
	 * Build the entire JSON output, setting the headers for response.
	 *
	 * @param	array	$data
	 * @return	void
	 */
	public function build_json($data = array())
	{
		$this->_ci->output->set_header('Content-Type: application/json; charset=utf-8');
		$this->_ci->output->set_output(json_encode((object) $data));
	}

	/**
	 * Set the title of the page
	 *
	 * @return	object	$this
	 */
	public function title()
	{
		// If we have some segments passed
		if ($title_segments = func_get_args())
		{
			$this->_title = implode($this->_title_separator, $title_segments);
		}

		return $this;
	}


	/**
	 * Put extra javascipt, css, meta tags, etc before all other head data
	 *
	 * @param	string	$line	The line being added to head
	 * @return	object	$this
	 */
	public function prepend_metadata($line, $place = 'header')
	{
		//we need to declare all new key's in _metadata as an array for the unshift function to work
		if ( ! isset($this->_metadata[$place]))
		{
			$this->_metadata[$place] = array();
		}

		array_unshift($this->_metadata[$place], $line);

		return $this;
	}


	/**
	 * Put extra javascipt, css, meta tags, etc after other head data
	 *
	 * @param	string	$line	The line being added to head
	 * @return	object	$this
	 */
	public function append_metadata($line, $place = 'header')
	{
		$this->_metadata[$place][] = $line;

		return $this;
	}
	
	/**
	 * Put extra javascipt, css, meta tags, etc after other head data
	 *
	 * @param	string	$line	The line being added to head
	 * @return	object	$this
	 */
	public function append_css($files, $min_file = null, $group = 'extra')
	{
		Asset::css($files, $min_file, $group);
		
		return $this;
	}
	
	public function append_js($files, $min_file = null, $group = 'extra')
	{
		Asset::js($files, $min_file, $group);
		
		return $this;
	}


	/**
	 * Set metadata for output later
	 *
	 * @param	string	$name		keywords, description, etc
	 * @param	string	$content	The content of meta data
	 * @param	string	$type		Meta-data comes in a few types, links for example
	 * @return	object	$this
	 */
	public function set_metadata($name, $content, $type = 'meta')
	{
		$name = htmlspecialchars(strip_tags($name));
		$content = trim(htmlspecialchars(strip_tags($content)));

		// Keywords with no comments? ARG! comment them
		if ($name == 'keywords' and ! strpos($content, ','))
		{
			$content = preg_replace('/[\s]+/', ', ', trim($content));
		}

		switch($type)
		{
			case 'meta':
				$this->_metadata['header'][$name] = '<meta name="'.$name.'" content="'.$content.'" />';
			break;

			case 'link':
				$this->_metadata['header'][$content] = '<link rel="'.$name.'" href="'.$content.'" />';
			break;

			case 'og':
				$this->_metadata['header'][md5($name.$content)] = '<meta property="'.$name.'" content="'.$content.'" />';
			break;
		}

		return $this;
	}


	/**
	 * Which theme are we using here?
	 *
	 * @param	string	$theme	Set a theme for the template library to use
	 * @return	object	$this
	 */
	public function set_theme($theme = null)
	{
		$this->_theme = $theme;
		foreach ($this->_theme_locations as $location)
		{
			if ($this->_theme and file_exists($location.$this->_theme))
			{
				$this->_theme_path = rtrim($location.$this->_theme.'/');
				break;
			}
		}

		return $this;
	}

	/**
	 * Get the current theme path
	 *
	 * @return	string The current theme path
	 */
	public function get_theme_path()
	{
		return $this->_theme_path;
	}

	/**
	 * Get the current view path
	 *
	 * @param	bool	Set if should be returned the view path full (with theme path) or the view relative the theme path
	 * @return	string	The current view path
	 */
	public function get_views_path($relative = false)
	{
		return $relative ? substr($this->_find_view_folder(), strlen($this->get_theme_path())) : $this->_find_view_folder();
	}

	/**
	 * Which theme layout should we using here?
	 *
	 * @param	string	$view
	 * @param	string	$layout_subdir
	 * @return	object	$this
	 */
	public function set_layout($view, $layout_subdir = null)
	{
		$this->_layout = $view;

		if ($layout_subdir !== null)
		{
			$this->_layout_subdir = $layout_subdir;
		}
		
		return $this;
	}

	/**
	 * Set a view partial
	 *
	 * @param	string	$name
	 * @param	string	$view
	 * @param	array	$data
	 * @return	object	$this
	 */
	public function set_partial($name, $view, $data = array())
	{
		$this->_partials[$name] = array('view' => $view, 'data' => $data);
		return $this;
	}

	/**
	 * Set a view partial
	 *
	 * @param	string	$name
	 * @param	string	$string
	 * @param	array	$data
	 * @return	object	$this
	 */
	public function inject_partial($name, $string, $data = array())
	{
		$this->_partials[$name] = array('string' => $string, 'data' => $data);
		return $this;
	}


	/**
	 * Helps build custom breadcrumb trails
	 *
	 * @param	string	$name	What will appear as the link text
	 * @param	string	$uri	The URL segment
	 * @return	object	$this
	 */
	public function set_breadcrumb($name, $uri = '', $reset = false)
	{
		// perhaps they want to start over
		if ($reset)
		{
			$this->_breadcrumbs = array();
		}

		$this->_breadcrumbs[] = array('name' => $name, 'uri' => $uri );
		return $this;
	}

	/**
	 * Set a the cache lifetime
	 *
	 * @param	int		$seconds
	 * @return	object	$this
	 */
	public function set_cache($seconds = 0)
	{
		$this->cache_lifetime = $seconds;
		return $this;
	}


	/**
	 * enable_minify
	 * Should be minify used or the output html files just delivered normally?
	 *
	 * @param	bool	$bool
	 * @return	object	$this
	 */
	public function enable_minify($bool)
	{
		$this->_minify_enabled = $bool;
		return $this;
	}


	/**
	 * enable_parser
	 * Should be parser be used or the view files just loaded normally?
	 *
	 * @param	bool	$bool
	 * @return	object	$this
	 */
	public function enable_parser($bool)
	{
		$this->_parser_enabled = $bool;
		return $this;
	}

	/**
	 * enable_parser_body
	 * Should be parser be used or the body view files just loaded normally?
	 *
	 * @param	bool	$bool
	 * @return	object	$this
	 */
	public function enable_parser_body($bool)
	{
		$this->_parser_body_enabled = $bool;
		return $this;
	}

	/**
	 * theme_locations
	 * List the locations where themes may be stored
	 *
	 * @return	array
	 */
	public function theme_locations()
	{
		return $this->_theme_locations;
	}

	/**
	 * add_theme_location
	 * Set another location for themes to be looked in
	 *
	 * @access	public
	 * @param	string	$location
	 * @return	array
	 */
	public function add_theme_location($location)
	{
		$this->_theme_locations[] = $location;
	}

	/**
	 * theme_exists
	 * Check if a theme exists
	 *
	 * @param	string	$theme
	 * @return	bool
	 */
	public function theme_exists($theme = null)
	{
		$theme OR $theme = $this->_theme;

		foreach ($this->_theme_locations as $location)
		{
			if (is_dir($location.$theme))
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * get_layouts
	 * Get all current layouts (if using a theme you'll get a list of theme layouts)
	 *
	 * @return	array
	 */
	public function get_layouts()
	{
		$layouts = array();

		foreach(glob(self::_find_view_folder().'layouts/*.*') as $layout)
		{
			$layouts[] = pathinfo($layout, PATHINFO_BASENAME);
		}

		return $layouts;
	}

	public function get_metadata($place = 'header')
	{
		return isset($this->_metadata[$place]) && is_array($this->_metadata[$place])
			? implode("\n\t\t", $this->_metadata[$place]) :	null;
	}

	/**
	 * get_layouts
	 * Get all current layouts (if using a theme you'll get a list of theme layouts)
	 *
	 * @param	string	$theme
	 * @return	array
	 */
	public function get_theme_layouts($theme = null)
	{
		$theme OR $theme = $this->_theme;

		$layouts = array();

		foreach ($this->_theme_locations as $location)
		{
			// Get special web layouts
			if( is_dir($location.$theme.'/views/web/layouts/') )
			{
				foreach(glob($location.$theme . '/views/web/layouts/*.*') as $layout)
				{
					$layouts[] = pathinfo($layout, PATHINFO_BASENAME);
				}
				break;
			}

			// So there are no web layouts, assume all layouts are web layouts
			if(is_dir($location.$theme.'/views/layouts/'))
			{
				foreach(glob($location.$theme . '/views/layouts/*.*') as $layout)
				{
					$layouts[] = pathinfo($layout, PATHINFO_BASENAME);
				}
				break;
			}
		}

		return $layouts;
	}

	/**
	 * layout_exists
	 * Check if a theme layout exists
	 *
	 * @param	string	$layout
	 * @return	bool
	 */
	public function layout_exists($layout)
	{
		// If there is a theme, check it exists in there
		if ( ! empty($this->_theme) and in_array($layout, self::get_theme_layouts()))
		{
			return true;
		}

		// Otherwise look in the normal places
		return file_exists(self::_find_view_folder().'layouts/' . $layout . self::_ext($layout));
	}


	/**
	 * layout_is
	 * Check if the current theme layout is equal the $layout argument
	 *
	 * @param	string	$layout
	 * @return	bool
	 */
	public function layout_is($layout)
	{
		return $layout === $this->_layout;
	}

	// find layout files, they could be mobile or web
	private function _find_view_folder()
	{
		if (isset($this->_ci->load->_ci_cached_vars['template_views']))
		{
			return $this->_ci->load->_ci_cached_vars['template_views'];
		}

		// Base view folder
		$view_folder = APPPATH.'views/';

		// Using a theme? Put the theme path in before the view folder
		if ( ! empty($this->_theme))
		{
			$view_folder = $this->_theme_path.'views/';
		}

		// Would they like the mobile version?
		if ($this->_is_mobile === true and is_dir($view_folder.'mobile/'))
		{
			// Use mobile as the base location for views
			$view_folder .= 'mobile/';
		}

		// Use the web version
		else if (is_dir($view_folder.'web/'))
		{
			$view_folder .= 'web/';
		}

		// Things like views/admin/web/view admin = subdir
		if ($this->_layout_subdir)
		{
			$view_folder .= $this->_layout_subdir.'/';
		}

		// If using themes store this for later, available to all views
		return $this->_ci->load->_ci_cached_vars['template_views'] = $view_folder;
	}

	/**
	 * Wrapper function for _find_view()
	 * so we can manually get a theme view
	 * that can be overriden.
	 */
	public function load_view($view, array $data, $parse_view = true)
	{
		return $this->_find_view($view, $data, $parse_view);
	}

	// A module view file can be overriden in a theme
	private function _find_view($view, array $data, $parse_view = true)
	{
		// Only bother looking in themes if there is a theme
		if ( ! empty($this->_theme))
		{
			$location		= $this->get_theme_path();
			$theme_views	= array(
				$this->get_views_path(true) . 'modules/' . $this->_module . '/' . $view,
				// This allows build('pages/page') to still overload same as build('page')
				$this->get_views_path(true) . 'modules/' . $view,
				$this->get_views_path(true) . $view
			);

			foreach ($theme_views as $theme_view)
			{
				if (file_exists($location . $theme_view . self::_ext($theme_view)))
				{
					return self::_load_view($theme_view, $this->_data + $data, $parse_view, $location);
				}
			}
		}

		// Not found it yet? Just load, its either in the module or root view
		return self::_load_view($view, $data + $this->_data, $parse_view);
	}

	private function _load_view($view, array $data, $parse_view = true, $override_view_path = null)
	{
		// Sevear hackery to load views from custom places AND maintain compatibility with Modular Extensions
		if ($override_view_path !== null)
		{
			if ($this->_parser_enabled === true and $parse_view === true)
			{
				// Load content and pass through the parser
				$content = $this->_ci->parser->parse_string($this->_ci->load->_ci_load(array(
					'_ci_path' => $override_view_path.$view.self::_ext($view),
					'_ci_vars' => $data,
					'_ci_return' => true
				)), $data, true);
			}

			else
			{
				// Load it directly, bypassing $this->load->view() as ME resets _ci_view
				$content = $this->_ci->load->_ci_load(array(
					'_ci_path' => $override_view_path.$view.self::_ext($view),
					'_ci_vars' => $data,
					'_ci_return' => true
				));
			}
		}

		// Can just run as usual
		else
		{
			// Grab the content of the view (parsed or loaded)
			$content = ($this->_parser_enabled === true AND $parse_view === true)

				// Parse that bad boy
				? $this->_ci->parser->parse($view, $data, true )

				// None of that fancy stuff for me!
				: $this->_ci->load->view($view, $data, true );
		}

		return $content;
	}

	private function _guess_title()
	{
		$this->_ci->load->helper('inflector');

		// Obviously no title, lets get making one
		$title_parts = array();

		// If the method is something other than index, use that
		if ($this->_method != 'index')
		{
			$title_parts[] = $this->_method;
		}

		// Make sure controller name is not the same as the method name
		if ( ! in_array($this->_controller, $title_parts))
		{
			$title_parts[] = $this->_controller;
		}

		// Is there a module? Make sure it is not named the same as the method or controller
		if ( ! empty($this->_module) and !in_array($this->_module, $title_parts))
		{
			$title_parts[] = $this->_module;
		}

		// Glue the title pieces together using the title separator setting
		$title = humanize(implode($this->_title_separator, $title_parts));

		return $title;
	}

	private function _ext($file)
	{
		return pathinfo($file, PATHINFO_EXTENSION) ? '' : EXT;
	}
}

// END Template class