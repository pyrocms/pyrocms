<?php namespace Pyro\FieldType;

use Pyro\Module\Streams_core\Core\Field\AbstractField;

/**
 * Merge Tags Field Type
 *
 * @author		Ryan Thompson
 * @copyright	Copyright (c) 2008-2013, AI Web Systems, Inc.
 * @link		http://aiwebsystems.com/
 */
class MergeTags extends AbstractField
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
	public function formInput()
	{
		return $this->value;
	}

	/**
	 * Pre save
	 * @return string The parsed string
	 */
	public function preSave()
	{
		return ci()->parser->parse_string($this->getParameter('pattern'), $this->form_values, true);
	}

	/**
	 * Pattern parameter
	 * @param  mixed $value The saved value or null
	 * @return array        The form array
	 */
	public function paramPattern($value = null)
	{
		return array(
			'input' 		=> form_textarea('pattern', $value),
			'instructions'	=> lang('streams:merge_tags.pattern.instructions')
		);;
	}
}