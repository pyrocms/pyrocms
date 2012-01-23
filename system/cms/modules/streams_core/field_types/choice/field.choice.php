<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Choice Field Type
 *
 * @package		PyroStreams
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

	public $custom_parameters		= array('choice_data', 'choice_type', 'default_value');
	
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
		$return = null;
		
		$choices = $this->_choices_to_array($params['custom']['choice_data'], $params['custom']['choice_type'], $field->is_required);
		
		// Put it into a drop down
		if($params['custom']['choice_type'] == 'dropdown'):
		
			$return = form_dropdown($params['form_slug'], $choices, $params['value'], 'id="'.$params['form_slug'].'"');
			
		else:

			// If these are checkboxes, then break up the vals
			if($params['custom']['choice_type'] == 'checkboxes'):
			
				// We may have an array from $_POST or a string
				// from the data
				if(is_string($params['value'])):
				
					$vals = explode("\n", $params['value']);
				
				else:
				
					$vals = $params['value'];
				
				endif;
				
				foreach($vals as $k => $v): $vals[$k] = trim($v); endforeach;
			
			endif;
		
			$return .= '<ul class="form_list">';
		
			foreach( $choices as $choice_key => $choice ):
						
				if($params['custom']['choice_type'] == 'radio'):

					($params['value'] == $choice_key) ? $selected = TRUE : $selected = FALSE;
			
					$return .= '<li><label>'.form_radio($params['form_slug'], $choice_key, $selected).'&nbsp;'.$choice.'</label></li>';
				
				else:
				
					(in_array($choice_key, $vals)) ? $selected = TRUE : $selected = FALSE;
				
					$return .= '<li><label>'.form_checkbox($params['form_slug'].'[]', $choice_key, $selected, 'id="'.$choice_key.'"').'&nbsp;'.$choice.'</label></li>';
				
				endif;
			
			endforeach;

			$return .= '</ul>';
		
		endif;
		
		return $return;
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
		$choices = $this->_choices_to_array( $data['choice_data'], $data['choice_type'] );
		
		// Checkboxes?
		if($data['choice_type'] == 'checkboxes'):
		
			$vals = explode("\n", $input);
			
			$html = '<ul>';

			foreach($vals as $v):
			
				if(isset($choices[$v])) $html .= '<li>'.$choices[$v].'</li>';				
				
			endforeach;
					
			return $html .= '</ul>';
		
		endif;
		
		if( isset($choices[$input]) and $input != '' ):
		
			return $choices[$input];
			
		elseif( isset($choices[$input]) and $input == '' ):
		
			return;
		
		else:
		
			return '';
		
		endif;
	}

	// --------------------------------------------------------------------------

	/**
	 * Pre-save
	 */	
	public function pre_save($input, $field)
	{
		// We only need to do this for checkboxes
		if($field->field_data['choice_type'] == 'checkboxes' and is_array($input)):

			// One per line
			return implode("\n", $input);		

		else:
		
			// Booooo
			return $input;
		
		endif;
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
		if($field->field_data['choice_type'] == 'checkboxes'):
		
			$this->db_col_type = 'text';
		
		endif;
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
		if($params['choice_type'] == 'checkboxes'):
		
			$this->plugin_return = 'array';
			
			$values = explode("\n", $input);
			
			$return = array();
			
			foreach($values as $k => $v):
			
				if(isset($options[$v])):
				
					$return[$k]['value'] 		= $options[$v];
					$return[$k]['value.key'] 	= $v; // @legacy
					$return[$k]['key'] 			= $v;
				
				else:
				
					// We don't want undefined values
					unset($values[$k]);
				
				endif;
			
			endforeach;
			
			return $return;
		
		endif;

		$this->plugin_return = 'merge';
	
		if( isset($options[$input]) and $input != '' ):
		
			$choices['key']	= $input;
			$choices['val']	= $options[$input]; // @legacy
			$choices['value']	= $options[$input];
			
			return $choices;
		
		else:
		
			return '';
		
		endif;
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
		$instructions = '<p class="note">'.$this->CI->lang->line('streams.choice.instructions').'</p>';
	
		return '<div style="float: left;">'.form_textarea('choice_data', $value).$instructions.'</div>';
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
		
		if($type == 'dropdown' and $is_required == 'no'):
			
			$choices[null] = get_instance()->config->item('dropdown_choose_null');
		
		endif;
		
		foreach( $lines as $line ):
		
			$bits = explode(":", $line);
			
			if( count($bits) == 1 ):

				$choices[trim($bits[0])] = trim($bits[0]);
			
			else:
			
				$choices[trim($bits[0])] = trim($bits[1]);
			
			endif;
		
		endforeach;
		
		return $choices;
	}
	
}

/* End of file field.choice.php */