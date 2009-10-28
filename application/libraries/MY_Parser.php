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
class MY_Parser extends CI_Parser {

	var $helper_delim = ':';
	var $param_delim = '|';
	var $func_l_delim = '[';
	var $func_r_delim = ']';
		
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
		$CI =& get_instance();
		$template = $CI->load->view($template, $data, TRUE);
		
		return $this->_parse($template, $data, $return);	
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
	function string_parse($template, $data = NULL, $return = FALSE)
	{
		return $this->_parse($template, $data, $return);	
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
	function _parse($template, $data, $return = FALSE)
	{
		$CI =& get_instance();
		
		$this->_data =& $data;
		
		if ($template == '')
		{
			return FALSE;
		}
		
		if(is_array($this->_data))
		{
			foreach ($this->_data as $key => $val)
			{
				if (is_array($val))
				{
					$template = $this->_parse_pair($key, $val, $template);		
				}
				else
				{
					$template = $this->_parse_single($key, (string)$val, $template);
				}
			}
		}
		
		// -- Helper stuff
		
		// Now lets find our functions
		$pattern = '/%1$s(([a-z0-9_]+)%2$s)?([a-z0-9_]+)(\%3$s([^%4$s]+)\])?%5$s/';
		$pattern = sprintf($pattern, $this->l_delim, $this->helper_delim, $this->func_l_delim, $this->func_r_delim, $this->r_delim);
		
		preg_match_all($pattern, $template, $matches);

		$matches_count = count($matches[0]);
		
		$from = array();
		$to = array();
		
		for($i = 0; $i < $matches_count; $i++)
		{
			// If a value is returned for this tag, use it. If not, perhaps it is text?
			if($val = $this->_parse_function($matches[2][$i], $matches[3][$i], $matches[5][$i]))
			{
				$from[] = $matches[0][$i];
				$to[] = $val;
				
				$template = str_replace($from, $to, $template);
			}
		}
		
		if($matches_count > 0)
		{
			$template = str_replace($from, $to, $template);
		}
		
		// -- End helper stuff
		
		if ($return == FALSE)
		{
			$CI->output->append_output($template);
		}
		
		return $template;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 *  Parse function
	 * 
	 * Parses a function or helper found in tbe template.
	 *
	 * @access	private
	 * @param	string
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function _parse_function($helper, $function, $parameters)
	{
		$CI =& get_instance();
		
		// If there is a helper file (not a native PHP function) and it has not yet been loaded
		if(!empty($helper) && !array_key_exists($helper, $CI->load->_ci_helpers))
		{
			// This includes the helper, but will only include it once
			$CI->load->helper($helper);
		}
		
		if(function_exists($function))
		{
			if($parameters !== '')
			{
				return call_user_func_array( $function, $this->_parse_parameters($parameters) );
			}
			
			else
			{
				return $function();
			}
		}
		
		return FALSE;
	}
	
	// --------------------------------------------------------------------
	

	/**
	 * Parse Parameters
	 *  
	 * Parse a parameter string into an array of parameters
	 *
	 * @access	private
	 * @param	string
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function _parse_parameters($parameter_string = '')
	{
		$double_string = '"[^(\\'.$this->func_r_delim .'|\\'. $this->param_delim.')]*"';
		$single_string = '\'[^(\\'.$this->func_r_delim .'|\\'. $this->param_delim.')]*\'';
		$bool = '(true|false|null)';
		$int = '[0-9., ]+';
		$variable = '\$[a-z_]+';
		
		$pattern = sprintf('/(\%s|\%s)?(%s|%s|%s|%s|%s)+/i', $this->func_l_delim, $this->param_delim, $double_string, $single_string, $bool, $int, $variable);
		
		preg_match_all($pattern, $parameter_string, $matches);

		$matches_count = count($matches[0]);
		$dirty_parameters =& $matches[2];

		$parameters = array();
		foreach($dirty_parameters as $param)
		{
			$first_char = substr($param, 0, 1);
			switch( $first_char )
			{
				// Parameter is a string, remove first and last "" or ''
				case "'":
				case '"':
					$param = substr($param, 1, -1);
				break;
				
				// Parameter is a CI view variable
				case '$':
					$param = substr($param, 1);
					$param = array_key_exists($param, $this->_data) ? $this->_data[$param] : NULL;
				break;
				
				// What else could it be?
				default:

					// Param is true/TRUE
					if(strtoupper($param) === 'TRUE')
					{
						$param = TRUE;
					}
					
					// Param is false/FALSE
					elseif(strtoupper($param) === 'FALSE')
					{
						$param = FALSE;
					}
					
					// Param is null/NULL
					elseif(strtoupper($param) === 'NULL')
					{
						$param = NULL;
					}
				
				break;
				
			}

			$parameters[] = $param;
		}

		return $parameters;
	}
	
	// --------------------------------------------------------------------
	
}
// END MY_Parser Class

/* End of file MY_Parser.php */
/* Location: ./application/libraries/MY_Parser.php */