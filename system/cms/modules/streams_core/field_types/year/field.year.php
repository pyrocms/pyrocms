<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Streams Year Field Type
 *
 * @package		PyroStreams
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2011 - 2013, PyroCMS
 */
class Field_year
{
	public $field_type_slug			= 'year';
	
	public $db_col_type				= 'char';
	
	public $col_constraint			= 4;

	public $custom_parameters		= array('start_year', 'end_year', 'default_year');

	public $extra_validation		= 'integer';

	public $version					= '1.0.0';

	public $author					= array('name'=>'Parse19', 'url'=>'http://parse19.com');

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
		$start_year 	= $this->_process_year_input( $data['custom']['start_year'] );
		$end_year 		= $this->_process_year_input( $data['custom']['end_year'] );
		
		$years 			= array();
		
		// If this is not required, then
		// let's allow a null option
		if ($field->is_required == 'no')
		{
			$years[null] = get_instance()->config->item('dropdown_choose_null');
		}
		
		while ($end_year >= $start_year)
		{
			$years[$end_year] = $end_year;
			
			--$end_year;
		}

		// Value
		// We only use the default value if this is a new
		// entry.
		if ( ! $data['value'] and ! $entry_id)
		{
			$value = (isset($field->field_data['default_year'])) ? $field->field_data['default_year'] : null;
		}
		else
		{
			$value = $data['value'];
		}	

		return form_dropdown($data['form_slug'], $years, $value);
	}

	// --------------------------------------------------------------------------

	/**
	 * Process Year Input
	 *
	 * Make sense of user input field. It accepts:
	 *
	 * - An actual year
	 * - 'current' for the current year
	 * - +num or -num for an offset of the current year
	 *
	 * @access	private
	 * @param	string
	 * @return	string
	 */
	private function _process_year_input($years_data)
	{
		if ( ! $years_data)
		{
			return date('Y');
		}
	
		// Do they want the current year?
		if ($years_data == 'current')
		{
			return date('Y');
		}
	
		// Is this numeric? If so then cool.		
		if ($years_data[0] != '-' and $years_data[0] != '+' and is_numeric($years_data))
		{
			return $years_data;
		}
		
		// Else, we have + or - from the current time
		if ($years_data[0] == '+')
		{
			$num = str_replace('+', '', $years_data);
			
			if (is_numeric($num))
			{
				return date('Y')+$num;
			}
		}
		elseif ($years_data[0] == '-')
		{
			$num = str_replace('-', '', $years_data);
			
			if (is_numeric($num))
			{
				return date('Y')-$num;
			}
		}
		
		// Default just return the current year
		return date('Y');
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Start Year
	 *
	 * @access	public
	 * @param	[string - value]
	 * @return	string
	 */
	public function param_start_year($value = null)
	{
		$options['name'] 	= 'start_year';
		$options['id']		= 'start_year';
		$options['value']	= $value;
		
		return form_input($options);
	}

	// --------------------------------------------------------------------------

	/**
	 * End Year
	 *
	 * @access	public
	 * @param	[string - value]
	 * @return	string
	 */
	public function param_end_year($value = null)
	{
		$options['name'] 	= 'end_year';
		$options['id']		= 'end_year';
		$options['value']	= $value;
		
		return form_input($options);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Start Year
	 *
	 * @access	public
	 * @param	[string - value]
	 * @return	string
	 */
	public function param_default_year($value = null)
	{
		$options = array(
			'name'		=> 'default_year',
			'id'		=> 'default_year',
			'value'		=> $value,
			'maxlength' => 4
		);
		
		return form_input($options);
	}

}