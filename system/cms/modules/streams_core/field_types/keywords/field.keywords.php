<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Keywords Field Type
 *
 * @package		PyroStreams
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2011 - 2013, PyroCMS
 */
class Field_keywords
{
	public $field_type_slug    = 'keywords';
	public $db_col_type        = 'varchar';
	public $version            = '1.1.0';
	public $author             = array('name'=>'Osvaldo Brignoni', 'url'=>'http://obrignoni.com');
	public $custom_parameters  = array('return_type');

	// --------------------------------------------------------------------------

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('keywords/keywords');
	}

	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output($data)
	{
		$options['name'] 	= $data['form_slug'];
		$options['id']		= 'id_'.rand(100, 10000);
		$options['class']	= 'keywords_input';
		$options['value']	= Keywords::get_string($data['value']);

		return form_input($options);
	}

	public function event($field)
	{
		$this->CI->template->append_css('jquery/jquery.tagsinput.css');
		$this->CI->template->append_js('jquery/jquery.tagsinput.js');
		$this->CI->type->add_js('keywords', 'keywords.js');
	}


	public function pre_save($input, $field=null, $stream=null, $row_id=null)
	{
		// Remove any existing applied keywords
		if (!empty($row_id) and !empty($stream))
		{
			$this->CI->load->model(array('keywords/keyword_m', 'streams_core/row_m'));

			$row = $this->CI->row_m->get_row($row_id, $stream, false);
			$keyword_hash = $row->keywords;
			$this->CI->keyword_m->delete_applied($keyword_hash);
		}

		return Keywords::process($input);
	}


	public function pre_output($input, $data)
	{
		// if we want an array, format it correctly
		if (isset($data['return_type']) and $data['return_type'] === 'array') {
			$keyword_array = Keywords::get_array($input);
			$keywords = array();
			$total = count($keyword_array);

			foreach ($keyword_array as $key => $value) {
				$keywords[] = array(
					'count' => $key,
					'total' => $total,
					'is_first' => $key == 0,
					'is_last' => $key == ($total - 1),
					'keyword' => $value
				);
			}

			return $keywords;
		}

		// otherwise return it as a string
		return Keywords::get_string($input);
	}


	public function param_return_type($value = 'array') {
		return array(
			'instructions' => $this->CI->lang->line('streams:keywords.return_type.instructions'),
			'input' =>
				'<label>' . form_radio('return_type', 'array', $value == 'array') . ' Array </label><br/>'
				// String gets set as default for backwards compat
				.'<label>' . form_radio('return_type', 'string', $value !== 'array') . ' String </label> '
		);
	}
}
