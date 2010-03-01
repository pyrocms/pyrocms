<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Parser Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Parser
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/codeigniter-dwoo
 */
include(APPPATH.'libraries/dwoo/dwooAutoload.php');

class MY_Parser extends CI_Parser {
    
	private $ci;
	
	private $dwoo;
	
	function __construct()
	{
	 	$this->ci =& get_instance();
	 	
		$this->ci->config->load('parser', TRUE);
        $config = $this->ci->config->item('parser');
        
        // Main Dwoo object
        $this->dwoo = new Dwoo;

         // The directory where compiled templates are located
		$this->dwoo->setCompileDir( $config['parser_compile_dir'] );
		$this->dwoo->setCacheDir( $config['parser_cache_dir'] );
		$this->dwoo->setCacheTime( $config['parser_cache_time'] );
		
		// Security
		$security = new Dwoo_Security_Policy;
		
		$security->setPhpHandling($config['parser_allow_php_tags']);
		$security->allowPhpFunction($config['parser_allowed_php_functions']);
		
		$this->dwoo->setSecurityPolicy( $security );
		
	}
	
	/**
	 *  Parse a view file
	 *
	 * Parses pseudo-variables contained in the specified template,
	 * replacing them with the data in the second param
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @param	bool
	 * @return	string
	 */
	function parse($template, $data = array(), $return = FALSE)
	{
		$string = $this->ci->load->view($template, $data, TRUE);
		
		return $this->_parse($string, $data, $return);	
	}
	
	/**
	 *  String parse
	 *
	 * Parses pseudo-variables contained in the string content,
	 * replacing them with the data in the second param
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @param	bool
	 * @return	string
	 */
	function string_parse($string, $data = array(), $return = FALSE)
	{
		return $this->_parse($string, $data, $return);
    }
	
	/**
	 *  Parse
	 *
	 * Parses pseudo-variables contained in the specified template,
	 * replacing them with the data in the second param
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @param	bool
	 * @return	string
	 */
	function _parse($string, $data, $return = FALSE)
	{
        // Start benchmark
        $this->ci->benchmark->mark('dwoo_parse_start');
        
		// Compatibility with PyroCMS v0.9.7 style links
		// TODO: Remove this for v1.0
		$string = preg_replace('/\{page_url\[([0-9]+)\]\}/', '{page_url($1)}', $string);
		
        // Convert from object to array
        if(!is_array($data))
        {
        	$data = (array) $data;
        }
        
        $data = array_merge($data, $this->ci->load->_ci_cached_vars);
        
        $data['ci'] =& $this->ci;

        // Object containing data
        $dwoo_data = new Dwoo_Data;
        $dwoo_data->setData($data);
        
        try
        {
	        // Object of the template
	        $tpl = new Dwoo_Template_String($string);
	        
	        // render the template
	        $parsed_string = $this->dwoo->get($tpl, $dwoo_data);
        }
        
        catch(Dwoo_Compilation_Exception $e)
        {
        	show_error($e);
        }
        
        // Finish benchmark
        $this->ci->benchmark->mark('dwoo_parse_end');

        // Return results or not ?
		if ( !$return )
		{
			$this->ci->output->append_output($parsed_string);
			return;
		}
		
		return $parsed_string;
	}
	
	// --------------------------------------------------------------------
	
}
// END MY_Parser Class

/* End of file MY_Parser.php */
/* Location: ./application/libraries/MY_Parser.php */