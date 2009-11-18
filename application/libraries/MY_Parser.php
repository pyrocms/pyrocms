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
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/parser.html
 */
include(APPPATH.'libraries/dwoo/dwooAutoload.php');

class MY_Parser extends CI_Parser {
    
	private $CI;
	
	private $dwoo;
	
	function __construct()
	{
	 	$this->CI =& get_instance();
	 	
		$this->CI->config->load('parser', TRUE);
        $config = $this->CI->config->item('parser');
        
        // Main Dwoo object
        $this->dwoo = new Dwoo();

         // The directory where compiled templates are located
		$this->dwoo->setCompileDir( $config['parser_compile_dir'] );
		$this->dwoo->setCacheDir( $config['parser_cache_dir'] );
		$this->dwoo->setCacheTime( $config['parser_cache_time'] );
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
	function parse($template, $data, $return = FALSE)
	{
		$string = $this->CI->load->view($template, $data, TRUE);
		
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
	function string_parse($string, $data = NULL, $return = FALSE)
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
        $this->CI->benchmark->mark('dwoo_parse_start');
        
        // Object containing data
        $dwoo_data = new Dwoo_Data();
        
        // Convert from object to array
        if(is_object($data))
        {
        	$data = (array) $data;
        }
        
        // If not an empty array, set data
        if(is_array($data) && $data !== array())
        {
	        $dwoo_data->setData($data);
        }
        
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
        $this->CI->benchmark->mark('dwoo_parse_end');

        // Return results or not ?
		if ( !$return )
		{
			$this->CI->output->append_output($parsed_string);
		}
		
		return $parsed_string;
	}
	
	// --------------------------------------------------------------------
	
}
// END MY_Parser Class

/* End of file MY_Parser.php */
/* Location: ./application/libraries/MY_Parser.php */