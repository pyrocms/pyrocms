<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package        CodeIgniter
 * @author        Rick Ellis
 * @copyright    Copyright (c) 2006, EllisLab, Inc.
 * @license        http://www.codeignitor.com/user_guide/license.html
 * @link        http://www.codeigniter.com
 * @since        Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Template Class
 *
 * Build your CodeIgniter pages much easier with partials, breadcrumbs, layouts and themes
 *
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	Philip Sturgeon
 * @link
 */
class Template
{
    private $_module = '';
    private $_controller = '';
    private $_method = '';

    private $_theme = '';
    private $_layout = FALSE; // By default, dont wrap the view with anything

    private $_title = '';
    private $_metadata = array();

	private $_partials = array();

    private $_breadcrumbs = array();

    private $_title_separator = ' | ';

    private $_parser_enabled = TRUE;
    private $_parser_body_enabled = TRUE;

	private $_theme_locations = array();

    // Seconds that cache will be alive for
    private $cache_lifetime = 0;//7200;

    private $_ci;

    private $data = array();

	/**
	 * Constructor - Sets Preferences
	 *
	 * The constructor can be passed an array of config values
	 */
	function __construct($config = array())
	{
        $this->_ci =& get_instance();

		if (!empty($config))
		{
			$this->initialize($config);
		}

        log_message('debug', 'Template class Initialized');

    	// Work out the controller and method
    	if( method_exists( $this->_ci->router, 'fetch_module' ) )
    	{
    		$this->_module 	= $this->_ci->router->fetch_module();
    	}

        $this->_controller	= $this->_ci->router->fetch_class();
        $this->_method 		= $this->_ci->router->fetch_method();
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize preferences
	 *
	 * @access	public
	 * @param	array
	 * @return	void
	 */
	function initialize($config = array())
	{
		foreach ($config as $key => $val)
		{
			$this->{'_'.$key} = $val;
		}

		if(empty($this->_theme_locations))
		{
			$this->_theme_locations = array(APPPATH . 'themes/' => '../themes/');
		}

		if ($this->_parser_enabled === TRUE)
		{
			$this->_ci->load->library('parser');
		}
	}

    // --------------------------------------------------------------------

    /**
     * Set the mode of the creation
     *
     * @access    public
     * @param    string

     * @return    void
     */
    public function build($view = '', $data = array(), $return = FALSE)
    {
		// Set whatever values are given. These will be available to all view files
    	$this->data = is_object($data) ? (array) $data : $data;

        if(empty($this->_title))
        {
        	$this->_title = $this->_guess_title();
        }

        // Output template variables to the template
        $template['title']	= $this->_title;
        $template['breadcrumbs'] = $this->_breadcrumbs;
        $template['metadata']	= implode("\n\t\t", $this->_metadata);
    	$template['partials']	= array();

    	// Assign by reference, as all loaded views will need access to partials
        $this->data['template'] =& $template;

    	foreach( $this->_partials as $name => $partial )
    	{
			// If its an array, use details to find it.
    		if (isset($partial['view']))
			{
				$template['partials'][$name] = $this->_load_view($partial['view'], $partial['search']);
			}

			// Otherwise, jam that bloody string in!
			else
			{
				if($this->_parser_enabled === TRUE)
				{
					$partial['string'] = $this->_ci->parser->parse_string($partial['string'], $this->data + $partial['data'], TRUE, TRUE);
				}

				$template['partials'][$name] = $partial['string'];
			}

    	}

        // Disable sodding IE7's constant cacheing!!
        $this->_ci->output->set_header('Expires: Sat, 01 Jan 2000 00:00:01 GMT');
        $this->_ci->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->_ci->output->set_header('Cache-Control: post-check=0, pre-check=0, max-age=0');
        $this->_ci->output->set_header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
        $this->_ci->output->set_header('Pragma: no-cache');

        // Let CI do the caching instead of the browser
        $this->_ci->output->cache( $this->cache_lifetime );

        // Test to see if this file
    	$this->_body = $this->_load_view( $view, TRUE, $this->_parser_body_enabled );

        // Want this file wrapped with a layout file?
        if( $this->_layout )
        {
			$template['body'] = $this->_body;

			// If using a theme, use the layout in the theme
			foreach ($this->_theme_locations as $location => $offset)
			{
				if( $this->_theme && file_exists($location.$this->_theme.'/views/layouts/' . $this->_layout . self::_ext($this->_layout)))
				{
					// If directory is set, use it
					$this->data['theme_view_folder'] = $offset.$this->_theme.'/views/';
					$layout_view = $this->data['theme_view_folder'] . 'layouts/' . $this->_layout;

					break;
				}
			}

			// No theme layout file was found, lets use whatever they gave us
			isset($layout_view) || $layout_view = $this->_layout;

			// Parse if parser is enabled, or its a theme view
			if($this->_parser_enabled === TRUE || $this->_theme)
			{
				$this->_body = $this->_ci->parser->parse($layout_view, $this->data, TRUE, TRUE);
			}

			else
			{
				$this->_body = $this->_ci->load->view($layout_view, $this->data, TRUE);
			}
        }

        // Want it returned or output to browser?
        if(!$return)
        {
            // Send it to output
            $this->_ci->output->set_output($this->_body);
        }

        return $this->_body;
    }


    /**
     * Set the title of the page
     *
     * @access    public
     * @param    string
     * @return    void
     */
    public function title()
    {
    	// If we have some segments passed
    	if($title_segments =& func_get_args())
    	{
    		$this->_title = implode($this->_title_separator, $title_segments);
    	}

        return $this;
    }


    /**
     * Put extra javascipt, css, meta tags, etc before all other head data
     *
     * @access    public
     * @param     string	$line	The line being added to head
     * @return    void
     */
    public function prepend_metadata($line)
    {
    	array_unshift($this->_metadata, $line);
        return $this;
    }


	/**
     * Put extra javascipt, css, meta tags, etc after other head data
     *
     * @access    public
     * @param     string	$line	The line being added to head
     * @return    void
     */
    public function append_metadata($line)
    {
    	$this->_metadata[] = $line;
        return $this;
    }


    /**
     * Set metadata for output later
     *
     * @access    public
     * @param	  string	$name		keywords, description, etc
     * @param	  string	$content	The content of meta data
     * @param	  string	$type		Meta-data comes in a few types, links for example
     * @return    void
     */
    public function set_metadata($name, $content, $type = 'meta')
    {
        $name = htmlspecialchars(strip_tags($name));
        $content = htmlspecialchars(strip_tags($content));

        // Keywords with no comments? ARG! comment them
        if($name == 'keywords' && !strpos($content, ','))
        {
        	$content = preg_replace('/[\s]+/', ', ', trim($content));
        }

        switch($type)
        {
        	case 'meta':
        		$this->_metadata[$name] = '<meta name="'.$name.'" content="'.$content.'" />';
        	break;

        	case 'link':
        		$this->_metadata[$content] = '<link rel="'.$name.'" href="'.$content.'" />';
        	break;
        }

        return $this;
    }


	/**
	 * Which theme are we using here?
	 *
	 * @access	public
	 * @param	string	$theme	Set a theme for the template library to use
	 * @return	void
	 */
	public function set_theme($theme = '')
	{
		$this->_theme = $theme;
		return $this;
	}


	/**
	 * Which theme layout should we using here?
	 *
	 * @access	public
	 * @param	string	$view
	 * @return	void
	 */
	public function set_layout($view = '')
	{
		$this->_layout = $view;
		return $this;
	}

	/**
	 * Set a view partial
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	boolean
	 * @return	void
	 */
	public function set_partial($name, $view, $search = TRUE)
	{
		$this->_partials[$name] = array('view' => $view, 'search' => $search);
		return $this;
	}

	/**
	 * Set a view partial
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	boolean
	 * @return	void
	 */
	public function inject_partial($name, $string, $data = array())
	{
		$this->_partials[$name] = array('string' => $string, 'data' => $data);
		return $this;
	}


	/**
	 * Helps build custom breadcrumb trails
	 *
	 * @access	public
	 * @param	string	$name		What will appear as the link text
	 * @param	string	$url_ref	The URL segment
	 * @return	void
	 */
    public function set_breadcrumb($name, $uri = '')
    {
    	$this->_breadcrumbs[] = array('name' => $name, 'uri' => $uri );
        return $this;
    }


    /**
     * enable_parser
     * Should be parser be used or the view files just loaded normally?
     *
     * @access    public
     * @param     string	$view
     * @return    void
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
     * @access    public
     * @param     string	$view
     * @return    void
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
     * @access    public
     * @param     string	$view
     * @return    array
     */
    public function theme_locations()
    {
        return $this->_theme_locations;
    }

    /**
     * add_theme_location
     * Set another location for themes to be looked in
     *
     * @access    public
     * @param     string	$view
     * @return    array
     */
    public function add_theme_location($location, $offset)
    {
        $this->_theme_locations[$location] = $offset;
    }

    /**
     * theme_exists
     * Check if a theme exists
     *
     * @access    public
     * @param     string	$view
     * @return    array
     */
	public function theme_exists($theme = NULL)
	{
		$theme || $theme = $this->_theme;

		foreach ($this->_theme_locations as $location => $offset)
		{
			if( is_dir($location.$theme) )
			{
				return TRUE;
			}
		}

		return FALSE;
	}

    /**
     * layout_exists
     * Check if a theme layout exists
     *
     * @access    public
     * @param     string	$view
     * @return    array
     */
	public function theme_layout_exists($layout, $theme = NULL)
	{
		$theme || $theme = $this->_theme;

		foreach ($this->_theme_locations as $location => $offset)
		{
			if( is_dir($location.$theme) )
			{
				return file_exists($location.$theme . '/views/layouts/' . $layout . self::_ext($layout));
			}
		}

		return FALSE;
	}
    /**
     * layout_exists
     * Check if a theme layout exists
     *
     * @access    public
     * @param     string	$view
     * @return    array
     */
	public function get_theme_layouts($theme = NULL)
	{
		$theme || $theme = $this->_theme;

		$layouts = array();

		foreach ($this->_theme_locations as $location => $offset)
		{
			if( is_dir($location.$theme) )
			{
				foreach(glob($location.$theme . '/views/layouts/*.*') as $layout)
				{
					$layouts[] = pathinfo($layout, PATHINFO_BASENAME);
				}
			}
		}

		return $layouts;
	}

    // A module view file can be overriden in a theme
    private function _load_view($view = '', $search = TRUE, $parse_view = TRUE)
    {
    	// Load exactly what we asked for, no f**king around!
    	if($search !== TRUE)
    	{
    		if($this->_parser_enabled === TRUE && $parse_view === TRUE)
			{
				return $this->_ci->parser->parse( $view, $this->data, TRUE );
			}

			else
			{
				return $this->_ci->load->view( $view, $this->data, TRUE );
			}
    	}

		// Only bother looking in themes if there is a theme
		if($this->_theme != '')
		{
			foreach ($this->_theme_locations as $location => $offset)
			{
				$theme_view = $this->_theme . '/views/modules/' . $this->_module . '/' . $view;

				if( file_exists( $location . $theme_view . self::_ext($theme_view) ))
				{
					if($this->_parser_enabled === TRUE && $parse_view === TRUE)
					{
						return $this->_ci->parser->parse( $offset.$theme_view, $this->data, TRUE );
					}

					else
					{
						return $this->_ci->load->view( $offset.$theme_view, $this->data, TRUE );
					}
				}
			}
		}

		// Not found it yet? Just load, its either in the module or root view
		if($this->_parser_enabled === TRUE && $parse_view === TRUE)
		{
			return $this->_ci->parser->parse( $this->_module.'/'.$view, $this->data, TRUE );
		}

		else
		{
			return $this->_ci->load->view( $this->_module.'/'.$view, $this->data, TRUE );
		}

    }

    private function _guess_title()
    {
        $this->_ci->load->helper('inflector');

        // Obviously no title, lets get making one
        $title_parts = array();

        // If the method is something other than index, use that
        if($this->_method != 'index')
        {
        	$title_parts[] = $this->_method;
        }

        // Make sure controller name is not the same as the method name
        if(!in_array($this->_controller, $title_parts))
        {
        	$title_parts[] = $this->_controller;
        }

        // Is there a module? Make sure it is not named the same as the method or controller
        if(!empty($this->_module) && !in_array($this->_module, $title_parts))
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