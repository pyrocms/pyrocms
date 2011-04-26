<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Dwoo Parser Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Parser
 * @license	 http://philsturgeon.co.uk/code/dbad-license
 * @link		http://philsturgeon.co.uk/code/codeigniter-dwoo
 */

class MY_Parser extends CI_Parser {

	private $_ci;

	function __construct($config = array())
	{
		$this->_ci = & get_instance();
	}

	// --------------------------------------------------------------------

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
	function parse($template, $data = array(), $return = FALSE, $is_include = FALSE)
	{
		$string = $this->_ci->load->view($template, $data, TRUE);

		return $this->_parse($string, $data, $return, $is_include);
	}

	// --------------------------------------------------------------------

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
	function parse_string($string, $data = array(), $return = FALSE, $is_include = FALSE)
	{
		return $this->_parse($string, $data, $return, $is_include);
	}

	// --------------------------------------------------------------------

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
	function _parse($string, $data, $return = FALSE, $is_include = FALSE)
	{
		// Start benchmark
		$this->_ci->benchmark->mark('parse_start');

		// Convert from object to array
		if ( ! is_array($data))
		{
			$data = (array) $data;
		}

		$data = array_merge($data, $this->_ci->load->_ci_cached_vars);

		// TAG SUPPORT
		$this->_ci->load->library('tags');
		$this->_ci->tags->set_trigger(config_item('tags_trigger').':');
		$parsed = $this->_ci->tags->parse($string, $data, array($this, 'parser_callback'));
		// END TAG SUPPORT

		// Finish benchmark
		$this->_ci->benchmark->mark('parse_end');

		// Return results or not ?
		if ( ! $return)
		{
			$this->_ci->output->append_output($parsed['content']);
			return;
		}

		return $parsed['content'];
	}

	// --------------------------------------------------------------------

	/**
	 * Callback from template parser
	 *
	 * @param	array
	 * @return	 mixed
	 */
	public function parser_callback($data)
	{
		$this->_ci->load->library('plugins');

		$return_data = $this->_ci->plugins->locate($data);

		if (is_array($return_data) && $return_data)
		{
			if ( ! $this->_is_multi($return_data))
			{
				$return_data = $this->_make_multi($return_data);
			}

			$content = $data['content'];
			$parsed_return = '';

			$simpletags = new Tags;
			$simpletags->set_trigger(config_item('tags_trigger').':');

			foreach ($return_data as $result)
			{
				if ($data['skip_content'])
				{
					$simpletags->set_skip_content($data['skip_content']);
				}

				$parsed = $simpletags->parse($content, $result, array($this, 'parser_callback'));
				$parsed_return .= $parsed['content'];
			}

			unset($simpletags);

			$return_data = $parsed_return;
		}

		return $return_data ? $return_data : NULL;
	}

	// ------------------------------------------------------------------------

	/**
	 * Ensure we have a multi array
	 *
	 * @param	array
	 * @return	 int
	 */
	private function _is_multi($array)
	{
		return (count($array) != count($array, 1));
	}

	// --------------------------------------------------------------------

	/**
	 * Forces a standard array in multidimensional.
	 * 
	 * @param	array
	 * @param	int		Used for recursion
	 * @return	array	The multi array
	 */
	private function _make_multi($flat, $i=0)
	{
		$multi = array();
		$return = array();
		foreach ($flat as $item => $value)
		{
			if (is_object($value))
			{
				$return[$item] = (array) $value;
			}
			else
			{
				$return[$i][$item] = $value;
			}
		}
		return $return;
	}
}

// END MY_Parser Class

/* End of file MY_Parser.php */
/* Location: ./application/libraries/MY_Parser.php */