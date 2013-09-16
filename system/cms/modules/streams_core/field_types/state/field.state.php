<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Streams_core\Core\Field\AbstractField;

/**
 * PyroStreams US State Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Adam Fairholm
 */
class Field_state extends AbstractField
{
	public $field_type_slug			= 'state';

	public $db_col_type				= 'string';

	public $version					= '1.3.0';

	public $author					= array('name' => 'Adam Fairholm', 'url' => 'http://adamfairholm.com');

	public $custom_parameters		= array('state_display', 'default_state');

	// --------------------------------------------------------------------------

	/**
	 * Our glorious 50 states!
	 *
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
	public function form_output()
	{
		// Value
		// We only use the default value if this is a new
		// entry.
		if ($this->value and $this->entry->getKey()) {
			$value = $this->value;
		} else {
			$value = $this->getParameter('default_state');
		}

		return form_dropdown(
			$this->form_slug, 
			$this->states($field->is_required, 
			$this->getParameter('state_display', 'abbr'), 
			$value, 
			'id="'.$this->form_slug.'"'
		);
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
	public function pre_output_plugin()
	{
		if ( ! $this->value) return null;

		return array(
			'abbr'	=> $this->value,
			'full' 	=> $this->raw_states[$this->value]
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
	public function pre_output()
	{
		// Default is abbr for backwards compat.
		$states = $this->states('yes', $this->getParameter('state_display', 'abbr'));

		return $this->getState($this->value);
	}

	// --------------------------------------------------------------------------

	/**
	 * Do we want the state full name of abbreviation?
	 *
	 * @return	string
	 */
	public function param_state_display()
	{
		$options = array(
			'full' => ci()->lang->line('streams:state.full'),
			'abbr' => ci()->lang->line('streams:state.abbr')
		);

		return form_dropdown('state_display', $options, $this->value);
	}

	/**
	 * Default Country Parameter
	 *
	 * @return 	string
	 */
	public function param_default_state()
	{
		// Return a drop down of countries
		// but we don't require them to give one.
		return form_dropdown('default_state', $this->states('no', 'full'), $this->value);
	}

	public function getState($name = null)
	{
		return isset($states[$this->value]) ? $states[$this->value] : null;
	}

	/**
	 * State
	 *
	 * Returns an array of states
	 *
	 * @return	array
	 */
	private function states($is_required, $state_display = 'abbr')
	{
		if( $state_display != 'abbr' and $state_display != 'full') $state_display = 'abbr';

		$choices = array();

		if($is_required == 'no') $choices[null] = ci()->config->item('dropdown_choose_null');

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
