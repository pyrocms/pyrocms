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

	public function __construct($config = array())
	{
		$this->_ci = & get_instance();
		
		if ( ! class_exists('Lex_Autoloader'))
		{
			include APPPATH.'/libraries/Lex/Autoloader.php';
		}
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
	public function parse($template, $data = array(), $return = false, $is_include = false, $streams_parse = array())
	{
		$string = $this->_ci->load->view($template, $data, true);

		return $this->_parse($string, $data, $return, $is_include, $streams_parse);
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
	public function parse_string($string, $data = array(), $return = false, $is_include = false, $streams_parse = array())
	{
		return $this->_parse($string, $data, $return, $is_include, $streams_parse);
	}

	// --------------------------------------------------------------------

	/**
	 *  Parse
	 *
	 * Parses pseudo-variables contained in the specified template,
	 * replacing them with the data in the second param
	 *
	 * @access	protected
	 * @param	string
	 * @param	array
	 * @param	bool
	 * @return	string
	 */
	protected function _parse($string, $data, $return = false, $is_include = false, $streams_parse = array())
	{
		// Start benchmark
		$this->_ci->benchmark->mark('parse_start');

		// Convert from object to array
		is_array($data) or $data = (array) $data;

		$data = array_merge($data, $this->_ci->load->_ci_cached_vars);

		Lex_Autoloader::register();

		if ($streams_parse and isset($streams_parse['stream']) and isset($streams_parse['namespace']))
		{
			// In some very rare cases (mainly in the pages module), we need to
			// change the field that is being passed to plugin_override() as row_id.
			// This is where that happens.
			$id_name = (isset($streams_parse['id_name']) and $streams_parse['id_name']) ? $streams_parse['id_name'] : 'id';

			$this->_ci->load->driver('Streams');
			$parsed = $this->_ci->streams->parse->parse_tag_content($string, $data, $streams_parse['stream'], $streams_parse['namespace'], false, null, $id_name);
		}
		else
		{
			$parser = new Lex_Parser();
			$parser->scope_glue(':');
			$parser->cumulative_noparse(true);
			$parsed = $parser->parse($string, $data, array($this, 'parser_callback'));
		}
		
		// Finish benchmark
		$this->_ci->benchmark->mark('parse_end');
		
		// Return results or not ?
		if ( ! $return)
		{
			$this->_ci->output->append_output($parsed);
			return;
		}

		return $parsed;
	}

	// --------------------------------------------------------------------

	/**
	 * Callback from template parser
	 *
	 * @param	array
	 * @return	 mixed
	 */
	public function parser_callback($plugin, $attributes, $content)
	{
		$this->_ci->load->library('plugins');

		$return_data = $this->_ci->plugins->locate($plugin, $attributes, $content);

		if (is_array($return_data) && $return_data)
		{
			if ( ! $this->_is_multi($return_data))
			{
				$return_data = $this->_make_multi($return_data);
			}

			// $content = $data['content']; # TODO What was this doing other than throw warnings in 2.0?
			$parsed_return = '';

			$parser = new Lex_Parser();
			$parser->scope_glue(':');
			
			foreach ($return_data as $result)
			{
				// if ($data['skip_content'])
				// {
				// 	$simpletags->set_skip_content($data['skip_content']);
				// }

				$parsed_return .= $parser->parse($content, $result, array($this, 'parser_callback'));
			}

			unset($parser);

			$return_data = $parsed_return;
		}

		return $return_data ? $return_data : null;
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