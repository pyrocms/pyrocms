<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Template Field Type
 *
 * @author  Osvaldo Brignoni
 * @package PyroCMS\Addon\FieldType
 */
class Field_template
{
	/**
	 * Field Type Name
	 *
	 * @var 	string
	 */
	public $field_type_name 		= 'Template';
	
	/**
	 * Field Type Slug
	 *
	 * @var 	string
	 */
	public $field_type_slug			= 'template';
	
	/**
	 * Alt Process
	 *
	 * This field type is alternatively processed.
	 *
	 * @var 	bool
	 */
	public $alt_process				= true;
	
	/**
	 * Database Column Type
	 *
	 * There is NO column to manage. This field is used to display data from other columns.
	 *
	 * @var 	string|bool
	 */
	public $db_col_type				= false;

	/**
	 * Custom Parameters
	 *
	 * Our only parameter is 'template',
	 * Where we design the template with HTML and Lex tags for displaying row data
	 * This is an example that displays syntax for Variables where {{ name }} is another row column.
	 * <div class="syntax">{{ noparse }} {{ {{ /noparse }} variables:{{ name }} {{ noparse }} }} {{ /noparse }}</div>
	 *
	 * @var 	array
	 */
    public $custom_parameters   = array('template');

	/**
	 * Version Number
	 *
	 * @var 	string
	 */
	public $version					= '1.0';

	/**
	 * Author
	 *
	 * @var 	string
	 */
	public $author					= array('name' => 'Osvaldo Brignoni', 'url' => 'http://obrignoni.com');

	public function alt_pre_output($row_id, $params, $field_type, $stream)
	{
		$row = $this->CI->row_m->get_row($row_id, $stream, false, false);

		return $this->CI->parser->parse_string(html_entity_decode($params['template'], ENT_COMPAT, "utf-8"), $row, true);
	}

	public function form_output($data, $entry_id, $field)
	{
		$row = $this->CI->row_m->get_row($entry_id, $field, false, false);

		return $this->CI->parser->parse_string($data['custom']['template'], $row, true);
	}

	public function param_template($value)
	{
		return array(
			'input' => form_textarea('template', html_entity_decode($value, ENT_COMPAT, "utf-8")),
			'instructions' => lang('streams:template.template_instructions')
		);
	}
}