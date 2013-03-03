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

	public $admin_display			= 'full';

	public $version					= '1.1.0';

	public $author					= array('name' => 'Adam Fairholm', 'url' => 'http://adamfairholm.com');

	public $custom_parameters		= array('default_text', 'allow_tags');
	
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
			$value = (isset($field->field_data['default_text']) and $field->field_data['default_text']) 
								? $field->field_data['default_text'] : $data['value'];

			// If we still don't have a default value, maybe we have it in
			// the old default value string. So backwards compat.
			if ( ! $value and isset($field->field_data['default_value']))
			{
				$value = $field->field_data['default_value'];
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

	public function pre_save($input)
	{
		return $input;
	}

	// --------------------------------------------------------------------------

	/**
	 * Pre-Ouput content
	 *
	 * @access 	public
	 * @return 	string
	 */
	public function pre_output($input, $params)
	{
		$parse_tags = ( ! isset($params['allow_tags'])) ? 'n' : $params['allow_tags'];

		// If this isn't the admin and we want to allow tags,
		// let it through. Otherwise we will escape them.
		if (defined('ADMIN_THEME') or $parse_tags == 'y')
		{
			return $input;
		}
		else
		{
			$this->CI->load->helper('text');
			return escape_tags($input);
		}
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

	// --------------------------------------------------------------------------
	
	/**
	 * Allow tags param.
	 *
	 * Should tags go through or be converted to output?
	 */
	public function param_allow_tags($value = null)
	{
		$options = array(
			'n'	=> lang('global:no'),
			'y'	=> lang('global:yes')
		);

		// Defaults to No
		$value = ($value) ? $value : 'n';
	
		return form_dropdown('allow_tags', $options, $value);
	}	

}
