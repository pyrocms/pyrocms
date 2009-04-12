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
 * CodeIgniter Layout Class
 *
 * Permits admin pages to be constructed easier.
 *
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	Philip Sturgeon
 * @link
 */
class Layout {

    var $page_body = '';
    var $_directory = '';
    var $_module = '';
    var $_controller = '';
    var $_method = '';

    var $_page_title = '';
    var $_extra_head_content = '';
    var $_breadcrumbs = array();

    // Default wrapper files
    var $layout_file = 'layout.php';

    var $title_separator = ' | ';
    
    var $folder_mode = 'matchbox'; // 'subdir', 'matchbox'
    var $wrap_mode = true;
    var $html_mode = false;

    // Seconds that cache will be alive for
    var $cache_lifetime = 0;//7200;

    var $CI;
    var $data;

    /**
     * Constructor - Calls the CI instance and sets a debug message
     *
     * The constructor can be passed an array of config values
     */
    function __construct()
    {
        $this->CI =& get_instance();
        log_message('debug', "Template Class Initialized");

        if($this->folder_mode == 'subdir'):

            if($this->_module == '' && $this->CI->uri->router->fetch_directory() != '/'):
                $this->_module = str_replace('/', '', $this->CI->uri->router->fetch_directory());
            endif;

        elseif($this->folder_mode == 'matchbox'):

            if($this->_module == '' && $this->CI->matchbox->fetch_module() != ''):
                $this->_module = str_replace(array('modules/', '/'), '', $this->CI->matchbox->fetch_module());
            endif;
            
        endif;
        
        $this->_controller	= strtolower(get_class($this->CI));
        $s 					= $this->CI->uri->rsegment_array();
        $n 					= array_search($this->_controller, $s);
        $this->_method 		= $this->CI->uri->rsegment($n+1);
    }

    // --------------------------------------------------------------------

    /**
     * Set the mode of the creation
     *
     * @access    public
     * @param    string

     * @return    void
     */
    function create($page_body = '', $data = array(), $return = false, $module = '')
    {
        if($page_body != '') $this->page_body = $page_body;
        if($module != '')    $this->_module = $module;

        // Merge all the data together
        $this->CI->load->helper('array');
        array_object_merge($this->data, $data);

        if(empty($this->_page_title)) $this->_guess_title();

        // Set the basic defaults
        $this->data->page_title				= $this->_page_title;
        $this->data->breadcrumbs            = $this->_create_breadcrumbs();
        $this->data->extra_head_content		= $this->_extra_head_content;

        // Disable sodding IE7's constant cacheing!!
        $this->CI->output->set_header("HTTP/1.0 200 OK");
        $this->CI->output->set_header("HTTP/1.1 200 OK");
        $this->CI->output->set_header('Expires: Sat, 01 Jan 2000 00:00:01 GMT');
        $this->CI->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->CI->output->set_header("Cache-Control: post-check=0, pre-check=0, max-age=0");
        $this->CI->output->set_header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
        $this->CI->output->set_header("Pragma: no-cache");

        // Let CI do the caching instead of bloody IE7
        $this->CI->output->cache($this->cache_lifetime);

        // Time to make the body, load view or parse HTML?
        if($this->html_mode):
        	$output = $this->page_body;

        else:
            // If directory or module is set, use it
            $view_file = (!empty($this->_directory)) ? $this->_directory.'/'.$this->page_body : $this->page_body;
            $output = $this->CI->load->view($view_file, $this->data, true, $this->_module);
        endif;
        
        // Want this file wrapped with the layout file?
        if($this->wrap_mode):
			// Send what we have so far to the layout view
			$this->data->page_output = $output;
			
            // If directory is set, use it
            $layout_file = (!empty($this->_directory)) ? $this->_directory.'/'.$this->layout_file : $this->layout_file;
            $output = $this->CI->load->view($layout_file, $this->data, true);
        
        else:
        	 $this->data->page_output = $output;
        endif;

        // Want it returned or output to browser?
        if($return):
            return $output;
        else:
            // Send it to output
            $this->CI->output->set_output($output);
        endif;

    }

    /**
     * Set the title of the page
     *
     * @access    public
     * @param    string
     * @return    void
     */

    function title()
    {
    	// If we have some segments passed
    	if($title_segments =& func_get_args())
    	{
    		$this->_page_title = implode($this->title_separator, $title_segments);
    	}
    }

    /**
     * Put extra javascipt, css, meta tags, etc
     *
     * @access    public
     * @param    string
     * @return    void
     */

    function extra_head($str = '')
    {
    	$this->_extra_head_content .= $str."\n";
    }

    function module($module = '')
    {
        $this->_module = $module;
    }

    /**
     * Should we include headers and footers?
     *
     * @access    public
     * @param    string
     * @return    void
     */

    function html_mode($html = true)
    {
        $this->html_mode = $html;
    }

    /**
     * Should we include headers and footers?
     *
     * @access    public
     * @param    string
     * @return    void
     */

    function wrap_mode($wrap = true)
    {
        $this->wrap_mode = $wrap;
    }


    /**
     * Helps build custom breadcrumb trails
     *
     * @access    public
     * @param    string
     * @param    string
     * @return    void
     */

    function add_breadcrumb($name, $url_ref = '')
    {
        foreach($this->_breadcrumbs as &$breadcrumb):
        	$breadcrumb['current_page'] = FALSE;
        endforeach;
    	
    	$this->_breadcrumbs[] = array('name'=>$name, 'url_ref'=>$url_ref, 'current_page'=> TRUE );
    }


    function _guess_title()
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
        $this->_page_title = humanize(implode($this->title_separator, $title_parts));

        return $this->_page_title;
    }


    // Build the array into a string with anchors and ->'s
    function _create_breadcrumbs()
    {
        $this->CI->load->helper('inflector');

        // No crumbs?
        if(count($this->_breadcrumbs) == 0):

        	$url_parts = array();
        	$segment_array = $this->CI->uri->segment_array();
        	$last_segment = array_pop($segment_array);
        	foreach($segment_array as $url_ref):
        		
        		// Skip if we already have this breadcrumb and its not admin
        		if(in_array($url_ref, $url_parts) or $url_ref == 'admin') continue;

        		$url_parts[] = $url_ref;
        		$this->_breadcrumbs[] = array('name'=>humanize(str_replace('-', ' ', $url_ref)), 'url_ref'=>implode('/', $url_parts), 'current_page' => FALSE );
        	endforeach;
        	
        	$url_parts[] = $last_segment;
        	$this->_breadcrumbs[] = array('name'=>humanize(str_replace('-', ' ', $last_segment)), 'url_ref'=>implode('/', $url_parts), 'current_page' => TRUE );

        endif;

        return $this->_breadcrumbs;
    }

}
// END Layout class
?>