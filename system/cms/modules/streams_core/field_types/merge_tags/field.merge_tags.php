<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Streams_core\Core\Field\AbstractField;

/**
 * Merge Tags Field Type
 *
 * @author		Ryan Thompson
 * @copyright	Copyright (c) 2008-2013, AI Web Systems, Inc.
 * @link		http://aiwebsystems.com/
 */
class Field_merge_tags extends AbstractField
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
	public function form_output()
	{
		return $this->value;
	}

	/**
	 * Pre save
	 * @return string The parsed string
	 */
	public function pre_save()
	{
		return ci()->parser->parse_string($this->getParameter('pattern'), $this->form_data, true);
	}

	public function param_pattern($value = null)
	{
		return array(
			'input' 		=> form_textarea('pattern', $value),
			'instructions'	=> lang('streams:merge_tags.pattern.instructions')
		);;
	}
}