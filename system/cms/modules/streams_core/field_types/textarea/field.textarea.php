<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Textarea Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Adam Fairholm
 * @copyright	Copyright (c) 2011 - 2012, Adam Fairholm
 */
class Field_textarea
{
	public $field_type_slug			= 'textarea';
	
	public $db_col_type				= 'longtext';

	public $version					= '1.1';

	public $author					= array('name' => 'Adam Fairholm', 'url' => 'http://adamfairholm.com');

	public $custom_parameters		= array('default_text');
	
	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output($data, $entry_id, $field)
	{
		// Value
		// We only use the default value if this is a new
		// entry.
		if ( ! $entry_id)
		{
			$value = (isset($field->field_data['default_text'])) ? $field->field_data['default_text'] : null;

			// If we still don't have a default value, maybe we have it in
			// the old default value string. So backwards compat.
			if ( ! $value and isset($field->field_data['default_vlaue']))
			{
				$value = $field->field_data['default_vlaue'];
			}
		}
		else
		{
			$value = $data['value'];
		}	

		$options = array(
			'name'		=> $data['form_slug'],
			'id'		=> $data['form_slug'],
			'value'		=> $value
		);

		return form_textarea($options);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Default Textarea Value
	 *
	 * @access	public
	 * @param	[string - value]
	 * @return	string
	 */
	public function param_default_text($value = null)
	{
		$options = array(
			'name'		=> 'default_text',
			'id'		=> 'default_text',
			'value'		=> $value,
		);
		
		return form_textarea($options);
	}	
}