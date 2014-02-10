<?php

use Pyro\Support\Contracts\ArrayableInterface;

/**
 * CodeIgniter Dwoo Parser Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Parser
 * @license	 http://philsturgeon.co.uk/code/dbad-license
 * @link		http://philsturgeon.co.uk/code/codeigniter-dwoo
 */
class MY_Parser extends CI_Parser
{
    public function __construct()
    {
        parent::__construct();

        $this->parser = new Lex\Parser;
    }

    /**
     *  Parse a view file
     *
     * Parses pseudo-variables contained in the specified template,
     * replacing them with the data in the second param
     *
     * @param	string
     * @param	array
     * @param	bool
     * @return	string
     */
    public function parse($template, $data = array(), $return = false, $is_include = false, $streams_parse = array(), $include_cached_vars = true)
    {
        $string = ci()->load->view($template, $data, true);

        return $this->_parse($string, $data, $return, $is_include, $streams_parse, $include_cached_vars);
    }

    /**
     *  String parse
     *
     * Parses pseudo-variables contained in the string content,
     * replacing them with the data in the second param
     *
     * @param	string
     * @param	array
     * @param	bool
     * @return	string
     */
    public function parse_string($string, $data = array(), $return = false, $is_include = false, $streams_parse = array(), $include_cached_vars = true)
    {
        return $this->_parse($string, $data, $return, $is_include, $streams_parse, $include_cached_vars);
    }

    /**
     *  Parse
     *
     * Parses pseudo-variables contained in the specified template,
     * replacing them with the data in the second param
     *
     * @param	string
     * @param	array
     * @param	bool
     * @return	string
     */
    protected function _parse($string, $data, $return = false, $is_include = false, $streams_parse = array(), $include_cached_vars = true)
    {
        // Start benchmark
        ci()->benchmark->mark('parse_start');

        // Convert from object to array
        $data = $this->toArray($data);

        // Include cached vars too?
        if ($include_cached_vars)
            $data = array_merge($data, ci()->load->_ci_cached_vars);

        if ($streams_parse and isset($streams_parse['stream']) and isset($streams_parse['namespace'])) {
            // In some very rare cases (mainly in the pages module), we need to
            // change the field that is being passed to plugin_override() as row_id.
            // This is where that happens.
            $id_name = (isset($streams_parse['id_name']) and $streams_parse['id_name']) ? $streams_parse['id_name'] : 'id';

            ci()->load->driver('Streams');
            $parsed = ci()->streams->parse->parse_tag_content($string, $data, $streams_parse['stream'], $streams_parse['namespace'], false, null, $id_name);
        } else {
            $parser = new Lex\Parser();
            $parser->scopeGlue(':');
            $parser->cumulativeNoparse(true);
            $parsed = $parser->parse($string, $data, array($this, 'parser_callback'));
        }

        // Finish benchmark
        ci()->benchmark->mark('parse_end');

        // Return results or not ?
        if ($return) {
            return $parsed;
        }

        ci()->output->append_output($parsed);
    }

    /**
     * Callback from template parser
     *
     * @param	array
     * @return	 mixed
     */
    public function parser_callback($plugin, $attributes, $content)
    {
        ci()->load->library('plugins');

        $return_data = ci()->plugins->locate($plugin, $attributes, $content);

        if (is_array($return_data) && $return_data) {
            if ( ! $this->isMulti($return_data)) {
                $return_data = $this->makeMulti($return_data);
            }

            // $content = $data['content']; # TODO What was this doing other than throw warnings in 2.0?
            $parsed_return = '';

            $parser = new Lex\Parser();
            $parser->scopeGlue(':');

            foreach ($return_data as $result) {
                $parsed_return .= $parser->parse($content, $result, array($this, 'parser_callback'));
            }

            unset($parser);

            $return_data = $parsed_return;
        }

        return $return_data ?: null;
    }

    // ------------------------------------------------------------------------

    /**
     * Ensure we have a multi array
     *
     * @param	array
     * @return	 int
     */
    private function isMulti($array)
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
    private function makeMulti($flat, $i=0)
    {
        $return = array();
     
        foreach ($flat as $item => $value) {

            if ($value instanceof ArrayableInterface) {
                $return[$item] = $value->toArray();
            }
            elseif (is_object($value)) {
                $return[$item] = (array) $value;
            } else {
                $return[$i][$item] = $value;
            }
        }
        return $return;
    }

    /**
     * toArray for output (recursively)
     * @param  mixed $data 
     * @return mixed        String or array
     */
    public function toArray($data)
    {
        return $this->parser->toArray($data);
    }
}

/* End of file MY_Parser.php */
