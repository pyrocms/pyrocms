<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams US State Field Type
 *
 * @package		PyroStreams
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2011 - 2013, PyroCMS
 */
class Field_state
{
	public $field_type_slug			= 'state';
	
	public $db_col_type				= 'varchar';

	public $version					= '1.3.0';

	public $author					= array('name' => 'Adam Fairholm', 'url' => 'http://adamfairholm.com');
	
	public $custom_parameters		= array('state_display', 'default_state');

	// --------------------------------------------------------------------------

	/**
	 * Our glorious 50 states!
	 *
	 * @access 	public
	 * @var 	array
	 */
	public $raw_states = array(
		'AL' => 'Alabama',  
		'AK'=> 'Alaska',  
		'AZ'=> 'Arizona',  
		'AR'=> 'Arkansas',
		'CA'=> 'California',  
		'CO'=> 'Colorado',  
		'CT'=> 'Connecticut',  
		'DE'=> 'Deleware',
		'DC'=> 'District of Columbia',
		'FL'=> 'Florida',
		'GA'=> 'Georgia',
		'HI'=> 'Hawaii',
		'ID'=> 'Idaho',
		'IL'=> 'Illinois',
		'IN'=> 'Indiana',  
		'IA'=> 'Iowa',
		'KS'=> 'Kansas', 
		'KY'=> 'Kentucky',
		'LA'=> 'Louisiana',
		'ME'=> 'Maine',
		'MD'=> 'Maryland',
		'MA'=> 'Massachusetts',
		'MI'=> 'Michigan',  
		'MN'=> 'Minnesota',
		'MS'=> 'Mississippi',
		'MO'=> 'Missouri',
		'MT'=> 'Montana',
		'NE'=> 'Nebraska',
		'NV'=> 'Nevada',
		'NH'=> 'New Hampshire',
		'NJ'=> 'New Jersey',
		'NM'=> 'New Mexico',
		'NY'=> 'New York',
		'NC'=> 'North Carolina',
		'ND'=> 'North Dakota',
		'OH'=> 'Ohio',
		'OK'=> 'Oklahoma', 
		'OR'=> 'Oregon',
		'PA'=> 'Pennsylvania',
		'RI'=> 'Rhode Island',  
		'SC'=> 'South Carolina',
		'SD'=> 'South Dakota',
		'TN'=> 'Tennessee',
		'TX'=> 'Texas',
		'UT'=> 'Utah',
		'VT'=> 'Vermont', 
		'VA'=> 'Virginia',
		'WA'=> 'Washington',
		'WV'=> 'West Virginia',
		'WI'=> 'Wisconsin',
		'WY'=> 'Wyoming'
	);

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
		// Default is abbr for backwards compat.
		if ( ! isset($data['custom']['state_display']))
		{
			$data['custom']['state_display'] = 'abbr';
		}

		// Value
		// We only use the default value if this is a new
		// entry.
		if ( ! $data['value'] and ! $entry_id)
		{
			$value = (isset($field->field_data['default_state'])) ? $field->field_data['default_state'] : null;
		}
		else
		{
			$value = $data['value'];
		}
	
		return form_dropdown($data['form_slug'], $this->states($field->is_required, $data['custom']['state_display']), $value, 'id="'.$data['form_slug'].'"');
	}

	// --------------------------------------------------------------------------

	/**
	 * Pre Output for Plugin
	 * 
	 * Has two options:
	 *
	 * - abbr
	 * - full
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function pre_output_plugin($input, $data)
	{
		if ( ! $input) return null;

		return array(
			'abbr'	=> $input,
			'full' 	=> $this->raw_states[$input]
		);
	}

	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function pre_output($input, $data)
	{	
		// Default is abbr for backwards compat.
		if( ! isset($data['state_display']) ):
		
			$data['state_display'] = 'abbr';
	
		endif;

		$states = $this->states('yes', $data['state_display']);
	
		return ( isset($states[$input]) ) ? $states[$input] : null;
	}

	// --------------------------------------------------------------------------

	/**
	 * Do we want the state full name of abbreviation?
	 *
	 * @access	public
	 * @return	string
	 */	
	public function param_state_display($value = null)
	{	
		$options = array(
			'full' => $this->CI->lang->line('streams:state.full'),
			'abbr' => $this->CI->lang->line('streams:state.abbr')
		);
	
		return form_dropdown('state_display', $options, $value);
	}

	// --------------------------------------------------------------------------

	/**
	 * Default Country Parameter
	 *
	 * @access 	public
	 * @return 	string
	 */
	public function param_default_state($input)
	{
		// Return a drop down of countries
		// but we don't require them to give one.
		return form_dropdown('default_state', $this->states('no', 'full'), $input);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * State
	 *
	 * Returns an array of states
	 *
	 * @access	private
	 * @return	array
	 */
	private function states($is_required, $state_display = 'abbr')
	{	
		if( $state_display != 'abbr' and $state_display != 'full') $state_display = 'abbr';
	
		$choices = array();
	
		if($is_required == 'no') $choices[null] = get_instance()->config->item('dropdown_choose_null');
	
		$states = array();
		
		if($state_display == 'abbr'):
		
			foreach($this->raw_states as $abbr => $full):
			
				$states[$abbr] = $abbr;
			
			endforeach;
			
		else:
		
			$states = $this->raw_states;
		
		endif; 
		
		return array_merge($choices, $states);
	}
	
}