<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Status Field Type
 *
 * Creates a simple drop down with default "Live" and "Draft" statuses
 * with the option to add new statuses.
 *
 * Stores the key status value in the database (so it can be used in queries)
 * and then gives access to the key and value in templates:
 *
 * {{ my_field:key }}
 * {{ my_field:value }}
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		PyroCMS - Adam Fairholm
 * @copyright	Copyright (c) 2011 - 2012, PryoCMS
 */
class Field_status
{	
	public $field_type_slug			= 'status';
	
	public $db_col_type				= 'varchar';

	public $version					= '1.0';

	public $author					= array('name' => 'PyroCMS', 'url' => 'http://www.pyrocms.com');

	public $custom_parameters		= array('extra_statuses', 'default_status');
		
	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output($params, $entry_id, $field)
	{
		$choices = $this->_choices_to_array($params['custom']['extra_statuses'], $field->is_required);

		// Check for default status.
		$default_value = (isset($params['custom']['default_status'])) ? $params['custom']['default_status'] : null;

		// If this is a new input, we need to use the default value or go null
		$value = ( ! $entry_id) ? $default_value : $params['value']; 

		return form_dropdown($params['form_slug'], $choices, $value, 'id="'.$params['form_slug'].'"');
	}

	// --------------------------------------------------------------------------

	/**
	 * Process before outputting in admin.
	 *
	 * @access	public
	 * @param	array
	 * @return	string
	 */
	public function pre_output($input, $data)
	{
		$choices = $this->_choices_to_array($data['extra_statuses'], $data['extra_statuses'], 'no', false);
		
		return (isset($choices[$input]) and $input != '') ? $choices[$input] : null;
	}

	// --------------------------------------------------------------------------

	/**
	 * Breaks up the items into key/val for template use
	 *
	 * @access	public
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	array
	 */
	public function pre_output_plugin($input, $params)
	{
		$options = $this->_choices_to_array($params['extra_statuses'], $params['extra_statuses'], 'no', false);
	
		if (isset($options[$input]) and $input != '')
		{
			$choices['key']		= $input;
			$choices['val']		= $options[$input]; // Some devs may still be using this.
			$choices['value']	= $options[$input];
			
			return $choices;
		}
		else
		{
			return null;
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Extra Statuses
	 *
	 * Extra statuses can be put on a line each, like
	 * in the choices field type:
	 *
	 * key
	 * key : Value
	 * 
	 * @access	public
	 * @param	[string - value]
	 * @return	string
	 */	
	public function param_extra_statuses($value = null)
	{
		return array(
			'input' 		=> form_textarea('extra_statuses', $value),
			'instructions'	=> $this->CI->lang->line('streams:extra_statuses.instructions')
		);
	}

	// --------------------------------------------------------------------------

	/**
	 * Default Status
	 *
	 * Should be the key. Status on default.
	 *
	 * @access	public
	 * @param	[string - value]
	 * @return	string
	 */	
	public function param_default_status($value = null)
	{
		return array(
			'input' 		=> form_input('default_status', $value),
			'instructions'	=> $this->CI->lang->line('streams:default_status.instructions')
		);
	}
	// --------------------------------------------------------------------------
	
	/**
	 * Choices to Array
	 *
	 * Take a string of choices and make them into an array
	 *
	 * @access	public
	 * @param	string 	$choices_raw 	raw choices data
	 * @param	string  [$is_required]  type od choice form input
	 * @return	array 	choices array
	 */
	public function _choices_to_array($choices_raw, $is_required = 'no')
	{
		$choices = array();

		$this->CI->lang->load('blog/blog');

		$lines = explode("\n", $choices_raw);
		
		// If it is not required, then let's add a null value
		if ($is_required == 'no')
		{
			$choices[null] = get_instance()->config->item('dropdown_choose_null');
		}
		
		// We always have draft and live
		$choices['draft'] 	= lang('blog:draft_label');
		$choices['live'] 	= lang('blog:live_label');

		foreach ($lines as $line)
		{
			$bits = explode(' : ', $line, 2);

			$key_bit = trim($bits[0]);
		
			if (count($bits) == 1)
			{
				$choices[$key_bit] = lang_label($key_bit);
			}
			else
			{
				$choices[$key_bit] = lang_label(trim($bits[1]));
			}
		}
		
		return $choices;
	}

}