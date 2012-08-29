<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Choice Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_choice
{	
	public $field_type_slug			= 'choice';
	
	public $db_col_type				= 'varchar';

	public $version					= '1.1';

	public $author					= array('name'=>'Parse19', 'url'=>'http://parse19.com');

	public $custom_parameters		= array(
										'choice_data',
										'choice_type',
										'default_value',
										'min_choices',
										'max_choices'
									);

	public $plugin_return			= 'merge';
		
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
		$choices = $this->_choices_to_array($params['custom']['choice_data'], $params['custom']['choice_type'], $field->is_required);

		// Only put in our brs for the admin
		$line_end = (defined('ADMIN_THEME')) ? '<br />' : null;
		
		if ($params['custom']['choice_type'] == 'dropdown')
		{
			// -------------------------------
			// Dropdown
			// -------------------------------
			// Drop downs are easy - the value is
			// always a string, and the choices
			// are just in an array from the field.
			// -------------------------------

			return form_dropdown($params['form_slug'], $choices, $params['value'], 'id="'.$params['form_slug'].'"');
		}	
		else
		{
			// -------------------------------
			// Checkboxes and Radio buttons
			// -------------------------------

			// Parse the value coming in.
			// If these are checkboxes, we need to put
			// the incoming data through some special processes
			if($params['custom']['choice_type'] == 'checkboxes')
			{
				// We may have an array from $_POST or a string
				// from the saved form data in the case
				// or checkboxes
				if (is_string($params['value']))
				{
					$vals = explode("\n", $params['value']);
				}
				elseif (is_array($params['value']))
				{
					$vals = $params['value'];
				}
				else
				{
					$vals = array();
				}
				
				// If we have an array of values, trim each one
				if (is_array($vals))
				{
					foreach($vals as $k => $v)
					{
						$vals[$k] = trim($v);
					}
				}
			}

			// Go through each choice and create
			// a input element.
			$return = null;

			foreach ($choices as $choice_key => $choice)
			{
				if ($params['custom']['choice_type'] == 'radio')
				{
					$selected = ($params['value'] == $choice_key) ? true : false;
			
					$return .= '<label class="checkbox">'.form_radio($params['form_slug'], $this->format_choice($choice_key), $selected, $this->active_state($choice)).'&nbsp;'.$this->format_choice($choice).'</label>'.$line_end ;
				}
				else
				{
					$selected = (in_array($choice_key, $vals)) ? true : false;
				
					$return .= '<label class="checkbox">'.form_checkbox($params['form_slug'].'[]', $this->format_choice($choice_key), $selected, 'id="'.$this->format_choice($choice_key).'" '.$this->active_state($choice)).'&nbsp;'.$this->format_choice($choice).'</label>'.$line_end ;
				}
			}
		}
		
		return $return;
	}

	// --------------------------------------------------------------------------

	/**
	 * Active state
	 *
	 * Putting a ^ in front of a line makes it checked and disabled.
	 * This set those parameters.
	 *
	 * @access 	private
	 * @param 	string
	 * @return 	string
	 */
	private function active_state($line)
	{
		$line = trim($line);

		if ( ! $line)
		{
			return $line;
		}
	
		if ($line{0} == '^')
		{
			return ' disabled="disabled" checked="checked"';
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Format a choice line
	 *
	 * Putting a ^ in front of a line makes it checked and disabled.
	 * This removes the character if it is there.
	 *
	 * @access 	private
	 * @param 	string
	 * @return 	string
	 */
	private function format_choice($line)
	{
		if ($line{0} == '^')
		{
			return substr($line, 1);
		}
		else
		{
			return $line;
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Process before outputting
	 *
	 * @access	public
	 * @param	array
	 * @return	string
	 */
	public function pre_output($input, $data)
	{
		$choices = $this->_choices_to_array($data['choice_data'], $data['choice_type']);
		
		// Checkboxes?
		if ($data['choice_type'] == 'checkboxes')
		{
			$vals = explode("\n", $input);

			$this->CI->load->helper('html');

			$selected = array();
			
			foreach ($vals as $v)
			{
				if (isset($choices[$v]))
				{
					$selected[] = $choices[$v];
				}			
			}

			return ul($selected);
		}
		
		if (isset($choices[$input]) and $input != '')
		{
			return $choices[$input];
		}	
		else
		{
			return null;
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Pre-save
	 */	
	public function pre_save($input, $field)
	{
		// We only need to do this for checkboxes
		if ($field->field_data['choice_type'] == 'checkboxes' and is_array($input))
		{
			// If we have any disabled checkboxes that have been diabled by
			// a ^ before it, then we need to go and find those and make sure
			// they are added in, because they will not be present in the post data
			$choices = explode("\n", $field->field_data['choice_data']);

			foreach($choices as $choice_line)
			{
				$choice_line = trim($choice_line);

				if ($choice_line{0} == '^')
				{
					$input[] = substr($choice_line, 1);
				}
			}

			// One per line
			return implode("\n", array_unique($input));		
		}
		else
		{
			// If this is not a checkbox field, we are
			// just returning the value.
			return $input;
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Validate input
	 *
	 * @access	public
	 * @param	string
	 * @param	string - mode: edit or new
	 * @param	object
	 * @return	mixed - true or error string
	 */
	public function validate($value, $mode, $field)
	{
		if ($field->field_data['choice_type'] == 'checkboxes' and is_array($value))
		{
			// Go through and count the number that are disabled
			$choices = explode("\n", $field->field_data['choice_data']);

			foreach($choices as $choice_line)
			{
				$choice_line = trim($choice_line);

				if ($choice_line{0} == '^')
				{
					$value[] = substr($choice_line, 1);
				}
			}
		
			$value = array_unique($value);	

			// Get the actual number of checked items
			$total_selected = count($value);

			// -------------------------------
			// Min/Max Choices
			// -------------------------------
			// Checks the total selected
			// -------------------------------

			$min = (
				isset($field->field_data['min_choices'])
				and is_numeric($field->field_data['min_choices']))
				? $field->field_data['min_choices'] : false;

			$max = (
				isset($field->field_data['max_choices'])
				and is_numeric($field->field_data['max_choices']))
				? $field->field_data['max_choices'] : false;

			// Special case: are min/max the same? If so, let's just
			// match the number.
			if ($max and $min and ($max == $min))
			{
				if ($total_selected != $max)
				{
					return str_replace('{val}', $max, lang('streams.choice.must_select_num'));
				}
			}
			else
			{
				// Min Choice
				if (is_numeric($min))
				{
					if ($min > $total_selected)
					{
						return str_replace('{val}', $max, lang('streams.choice.must_at_least'));
					}
				}

				// Max Choice
				if (is_numeric($max))
				{
					if ($max < $total_selected)
					{
						return str_replace('{val}', $max, lang('streams.choice.must_max_num'));
					}
				}

			}

		}

		return true;
	}
	
	// --------------------------------------------------------------------------

	/**
	 * Pre field add
	 *
	 * Before we add the field to a stream 
	 *
	 * @access	public
	 * @param	obj
	 * @param	obj
	 * @return	void
	 */
	public function field_assignment_construct($field, $stream)
	{
		// We need more room for checkboxes
		if ($field->field_data['choice_type'] == 'checkboxes')
		{
			$this->db_col_type = 'text';
		}
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
		$options = $this->_choices_to_array($params['choice_data'], $params['choice_type']);

		// Checkboxes
		if ($params['choice_type'] == 'checkboxes')
		{
			$this->plugin_return = 'array';
			
			$values = explode("\n", $input);
			
			$return = array();
			
			foreach ($values as $k => $v)
			{
				if (isset($options[$v]))
				{
					$return[$k]['value'] 		= $options[$v];
					$return[$k]['value.key'] 	= $v; // legacy
					$return[$k]['key'] 			= $v;
				}
				else
				{
					// We don't want undefined values
					unset($values[$k]);
				}
			}
			
			return $return;
		}

		$this->plugin_return = 'merge';
	
		if (isset($options[$input]) and $input != '')
		{
			$choices['key']		= $input;
			$choices['val']		= $options[$input]; // legacy
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
	 * Data for choice. In x : X format or just X format
	 *
	 * @access	public
	 * @param	[string - value]
	 * @return	string
	 */	
	public function param_choice_data($value = null)
	{
		return array(
				'input' 		=> form_textarea('choice_data', $value),
				'instructions'	=> $this->CI->lang->line('streams.choice.instructions')
			);
	}

	// --------------------------------------------------------------------------

	/**
	 * Display as Dropdown
	 *
	 * @access	public
	 * @param	[string - value]
	 * @return	string
	 */	
	public function param_choice_type($value = null)
	{
		$choices = array(
			'dropdown' 	=> $this->CI->lang->line('streams.choice.dropdown'),
			'radio' 	=> $this->CI->lang->line('streams.choice.radio_buttons'),
			'checkboxes'=> $this->CI->lang->line('streams.choice.checkboxes')
		);
		
		return form_dropdown('choice_type', $choices, $value);
	}

	// --------------------------------------------------------------------------

	/**
	 * Minimum Number of Choices
	 *
	 * @access	public
	 * @param	[string - value]
	 * @return	string
	 */	
	public function param_min_choices($value = null)
	{
		return array(
				'input' 		=> form_input('min_choices', $value),
				'instructions'	=> $this->CI->lang->line('streams.choice.checkboxes_only')
			);
	}

	// --------------------------------------------------------------------------

	/**
	 * Minimum Number of Choices
	 *
	 * @access	public
	 * @param	[string - value]
	 * @return	string
	 */	
	public function param_max_choices($value = null)
	{
		return array(
				'input' 		=> form_input('max_choices', $value),
				'instructions'	=> $this->CI->lang->line('streams.choice.checkboxes_only')
			);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Take a string of choices and make them into an array
	 *
	 * @access	public
	 * @param	string - raw choices data
	 * @param	string - type od choice form input
	 * @param	string - fied is required - yes or no
	 * @return	array
	 */
	public function _choices_to_array($choices_raw, $type = 'dropdown', $is_required = 'no')
	{
		$lines = explode("\n", $choices_raw);
		
		if ($type == 'dropdown' and $is_required == 'no')
		{
			$choices[null] = get_instance()->config->item('dropdown_choose_null');
		}
		
		foreach ($lines as $line)
		{
			$bits = explode(' : ', $line, 2);

			$key_bit = trim($bits[0]);
		
			if (count($bits) == 1)
			{
				$choices[$key_bit] = $this->CI->fields->translate_label($key_bit);
			}
			else
			{
				$choices[$key_bit] = $this->CI->fields->translate_label(trim($bits[1]));
			}
		}
		
		return $choices;
	}

}