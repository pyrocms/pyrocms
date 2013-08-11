<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Merge Tags Field Type
 *
 * @author		Ryan Thompson
 * @copyright	Copyright (c) 2008-2013, AI Web Systems, Inc.
 * @link		http://aiwebsystems.com/
 */
class Field_merge_tags
{
	public $field_type_name 		= 'Merge Tags';
	
	public $field_type_slug			= 'merge_tags';
	
	public $db_col_type				= 'string';

	public $custom_parameters		= array('pattern');

	public $version					= '1.1';

	public $author					= array('name' => 'Ryan Thompson', 'url' => 'http://www.aiwebsystems.com/');
	
	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @access 	public
	 * @param	array
	 * @return	string
	 */
	public function form_output($data, $entry_id, $field)
	{
		return form_hidden($field->field_slug, '1').'This should be hidden.';
	}

	public function pre_save($input, $field)
	{
		return ci()->parser->parse_string($field->field_data['pattern'], $_POST, true);
	}
}