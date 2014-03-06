<?php namespace Pyro\FieldType;

use Pyro\Module\Streams_core\AbstractFieldType;

/**
 * Merge Tags Field Type
 *
 * @author		Ryan Thompson
 * @copyright	Copyright (c) 2008-2013, AI Web Systems, Inc.
 * @link		http://aiwebsystems.com/
 */
class MergeTags extends AbstractFieldType
{
	public $field_type_name 		= 'Merge Tags';
	
	public $field_type_slug			= 'merge_tags';
	
	public $db_col_type				= 'string';

	public $custom_parameters		= array('pattern');

	public $version					= '1.1';

	public $author					= array('name' => 'Ryan Thompson', 'url' => 'http://www.aiwebsystems.com/');
	
	///////////////////////////////////////////////////////////////////////////////
	// -------------------------	Methods 	  ------------------------------ //
	///////////////////////////////////////////////////////////////////////////////

	/**
	 * Input for form
	 *
	 * @access 	public
	 * @return	string
	 */
	public function formInput()
	{
		return $this->value;
	}

	/**
	 * Output for string use
	 * @return string
	 */
	public function stringOutput()
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
	 * @param  string $value The saved value or null
	 * @return array        The form array
	 */
	public function paramPattern($value = null)
	{
		return array(
			'input' 		=> form_textarea('pattern', $value),
			'instructions'	=> lang('streams:merge_tags.pattern.instructions')
		);
	}
}
