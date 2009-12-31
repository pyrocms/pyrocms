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
    private $_view = '';
    
    private $_partials = array();
    
    private $_breadcrumbs = array();

    private $title_separator = ' | ';
    
    private $_parser_enabled = TRUE;
    
    // Seconds that cache will be alive for
    private $cache_lifetime = 0;//7200;

    private $CI;
    
    // DEPRECATED: TODO kill it
    var $data;

    /**
     * Constructor - Calls the CI instance and sets a debug message
     *
     * The constructor can be passed an array of config values
     */
    function __construct()
    {
        $this->CI =& get_instance();
        log_message('debug', 'Template class Initialized');

    	// Work out the controller and method
    	if( method_exists( $this->CI->router, 'fetch_module' ) )
    	{
    		$this->_module 	= $this->CI->router->fetch_module();
    	}
    	
        $this->_controller	= $this->CI->router->fetch_class();
        $this->_method 		= $this->CI->router->fetch_method();
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
    	$this->CI->load->vars($data);
    	unset($data);
    	
        if(empty($this->_title))
        {
        	$this->_title = $this->_guess_title();
        }

        // Output template variables to the template
        $template['title']			= $this->_title;
        $template['breadcrumbs']	= array();
        $template['metadata']		= implode("\n\t\t", $this->_metadata);
        
        $this->data->template =& $template;
        
        ##### DEPRECATED!! #################################################
        ## TODO: Nuke these variables
        // Set the basic defaults
        $this->data->page_title				= $template['title'];
        $this->data->breadcrumbs            = $template['breadcrumbs'];
        $this->data->extra_head_content		= $template['metadata'];
        ####################################################################
        

        // Disable sodding IE7's constant cacheing!!
        $this->CI->output->set_header('HTTP/1.0 200 OK');
        $this->CI->output->set_header('HTTP/1.1 200 OK');
        $this->CI->output->set_header('Expires: Sat, 01 Jan 2000 00:00:01 GMT');
        $this->CI->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->CI->output->set_header('Cache-Control: post-check=0, pre-check=0, max-age=0');
        $this->CI->output->set_header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
        $this->CI->output->set_header('Pragma: no-cache');

        // Let CI do the caching instead of the browser
        $this->CI->output->cache( $this->cache_lifetime );

        // Test to see if this file 
    	$this->_body = $this->_load_view( $view );
    	
    	$template['partials'] = array();
    	foreach( $this->_partials as $name => $partial )
    	{
    		$template['partials'][$name] = $this->_load_view( $partial['view'] , $partial['search']);
    	}
    	
        // Want this file wrapped with a layout file?
        if( $this->_layout )
        {
	        ##### DEPRECATED!! #################################################
	        ## TODO: Nuke these variables and replace with $template
			$this->data->page_output = $this->_body;
			####################################################################
			
			$template['body'] = $this->_body;
			
			// If using a theme, use the layout in the theme
			if( $this->_theme )
			{
				// If directory is set, use it
				$this->data->theme_view_folder = '../themes/'.$this->_theme.'/views/';
	            $layout_view = $this->data->theme_view_folder.$this->_layout;
			}
            
			// Otherwise use whatever is given
			else
			{
				$layout_view = $this->_layout;
			}
			
			// Parse if parser is enabled, or its a theme view
			if($this->_parser_enabled === TRUE || $this->_theme)
			{
				$this->_body = $this->CI->parser->parse( $layout_view, $this->data, TRUE );
			}
			
			else
			{
				$this->_body = $this->CI->load->view( $layout_view, $this->data, TRUE );
			}
        }
        
        // Want it returned or output to browser?
        if($return)
        {
            return $this->_body;
        }
        
        else
        {
            // Send it to output
            $this->CI->output->set_output($this->_body);
        }

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
    		$this->_title = implode($this->title_separator, $title_segments);
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
        	$this->CI->load->helper('inflector');
        	$content = keywords($content);
        }
        
        switch($type)
        {
        	case 'meta':
        		$meta = '<meta name="'.$name.'" content="'.$content.'" />';
        	break;
        	
        	case 'link':
        		$meta = '<link rel="'.$name.'" href="'.$content.'" />';
        	break;
        }
        
    	$this->append_metadata($meta);
    	
        return $this;
    }


    /**
     * Which theme are we using here?
     *
     * @access    public
     * @param     string	$theme	Set a theme for the template library to use	
     * @return    void
     */
    public function set_theme($theme = '')
    {
        $this->_theme = $theme;
        return $this;
    }

    
    /**
     * Which Template file are we using here?
     *
     * @access    public
     * @param     string	$view
     * @return    void
     */
    public function set_layout($view = '')
    {
        $this->_layout = $view;
        return $this;
    }
    
    
    public function set_partial( $name, $view, $search = TRUE )
    {
    	$this->_partials[$name] = array('view' => $view, 'search' => $search);
    	return $this;
    }


    /**
     * Helps build custom breadcrumb trails
     *
     * @access    public
     * @param     string	$name		What will appear as the link text
     * @param     string	$url_ref	The URL segment
     * @return    void
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
    
    // A module view file can be overriden in a theme
    private function _load_view($view = '', $search = TRUE)
    {
    	// Hunt it down like a dog, through themes and modules
    	if($search == TRUE)
    	{
    		$theme_view = 'themes/' . $this->_theme . '/views/modules/' . $this->_module . '/' . $view;
    		
    		if( $this->_theme && file_exists( APPPATH . $theme_view . EXT ))
	    	{
	    		$this->CI->load->library('parser');
	    		return $this->CI->parser->parse('../'.$theme_view, $this->data, TRUE);
	    	}

		    // Nope, just use whatever's in the module
	    	else
	    	{
	    		if($this->_parser_enabled === TRUE)
				{
					$this->CI->load->library('parser');
					return $this->CI->parser->parse( $this->_module.'/'.$view, $this->data, TRUE );
				}
				
				else
				{
					return $this->CI->load->view( $this->_module.'/'.$view, $this->data, TRUE );
				}
	    	}
    	}
    	
    	// Load exactly what we asked for, no f**king around!
    	else
    	{
    		if($this->_parser_enabled === TRUE)
			{
				$this->CI->load->library('parser');
				return $this->CI->parser->parse( $view, $this->data, TRUE );
			}
			
			else
			{
				return $this->CI->load->view( $view, $this->data, TRUE );
			}
    	}
    }


    private function _guess_title()
    {
        $this->CI->load->helper('inflector');

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
        $title = humanize(implode($this->title_separator, $title_parts));

        return $title;
    }

}

// END Template class