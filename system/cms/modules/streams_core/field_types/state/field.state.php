<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
  * This is a State Field Types for PyroCMS
  *
  * @author		Jaap Jolman, Geoffrey Monté
  * @package	State Field Types
  * @copyright	Copyright (c) 2008 - 2013, ODIN-ADDONS
**/

class Field_state
{
	public $field_type_slug			= 'state';
	
	public $db_col_type				= 'varchar';

	public $version					= '1.3';

	public $author					= array('name'=>'Jaap Jolman, Geoffrey Monté', 'url'=>'http://www.odin-addons.com');
	
	public $custom_parameters		= array('state_display','country');

	// --------------------------------------------------------------------------

	/**
	 *
	 * @access 	public
	 * @var 	array
	 */
	public $raw_states = array(
		'US' => array(
			'AL'	=> 'Alabama',
			'AK'	=> 'Alaska',
			'AZ'	=> 'Arizona',
			'AR'	=> 'Arkansas',
			'CA'	=> 'California',
			'CO'	=> 'Colorado',
			'CT'	=> 'Connecticut',
			'DE'	=> 'Deleware',
			'DC'	=> 'District of Columbia',
			'FL'	=> 'Florida',
			'GA'	=> 'Georgia',
			'HI'	=> 'Hawaii',
			'ID'	=> 'Idaho',
			'IL'	=> 'Illinois',
			'IN'	=> 'Indiana',
			'IA'	=> 'Iowa',
			'KS'	=> 'Kansas',
			'KY'	=> 'Kentucky',
			'LA'	=> 'Louisiana',
			'ME'	=> 'Maine',
			'MD'	=> 'Maryland',
			'MA'	=> 'Massachusetts',
			'MI'	=> 'Michigan',
			'MN'	=> 'Minnesota',
			'MS'	=> 'Mississippi',
			'MO'	=> 'Missouri',
			'MT'	=> 'Montana',
			'NE'	=> 'Nebraska',
			'NV'	=> 'Nevada',
			'NH'	=> 'New Hampshire',
			'NJ'	=> 'New Jersey',
			'NM'	=> 'New Mexico',
			'NY'	=> 'New York',
			'NC'	=> 'North Carolina',
			'ND'	=> 'North Dakota',
			'OH'	=> 'Ohio',
			'OK'	=> 'Oklahoma',
			'OR'	=> 'Oregon',
			'PA'	=> 'Pennsylvania',
			'RI'	=> 'Rhode Island',
			'SC'	=> 'South Carolina',
			'SD'	=> 'South Dakota',
			'TN'	=> 'Tennessee',
			'TX'	=> 'Texas',
			'UT'	=> 'Utah',
			'VT'	=> 'Vermont',
			'VA'	=> 'Virginia',
			'WA'	=> 'Washington',
			'WV'	=> 'West Virginia',
			'WI'	=> 'Wisconsin',
			'WY'	=> 'Wyoming'
		),
		'NL' => array(
			'GR'	=> 'Groningen',
			'FR'	=> 'Friesland',
			'DR'	=> 'Drenthe',
			'OV'	=> 'Overijsel',
			'FL'	=> 'Flevoland',
			'GE'	=> 'Gelderland',
			'UT'	=> 'Utrecht',
			'NH'	=> 'Noord-Holland',
			'ZH'	=> 'Zuid-Holland',
			'ZL'	=> 'Zeeland',
			'BB'	=> 'Brabant',
			'LM'	=> 'Limburg'
		),
		'FR' => array(
			'01'	=> 'Ain',
			'02'	=> 'Aisne',
			'03'	=> 'Allier',
			'04'	=> 'Alpes de Haute Provence',
			'05'	=> 'Alpes Hautes',
			'06'	=> 'Alpes Maritimes',
			'07'	=> 'Ardèche',
			'08'	=> 'Ardennes',
			'09'	=> 'Ariège',
			'10'	=> 'Aube',
			'11'	=> 'Aude',
			'12'	=> 'Aveyron',
			'13'	=> 'Bouches du Rhône',
			'14'	=> 'Calvados',
			'15'	=> 'Cantal',
			'16'	=> 'Charente',
			'17'	=> 'Charente Maritime',
			'18'	=> 'Cher',
			'19'	=> 'Corrèze',
			'2A'	=> 'Corse du sud',
			'2B'	=> 'Corse Haute',
			'21'	=> 'Côte d\'or',
			'22'	=> 'Cotes d\'Armor',
			'23'	=> 'Creuse',
			'24'	=> 'Dordogne',
			'25'	=> 'Doubs',
			'26'	=> 'Drôme',
			'27'	=> 'Eure',
			'28'	=> 'Eure et Loir',
			'29'	=> 'Finistère',
			'30'	=> 'Gard',
			'31'	=> 'Garonne',
			'32'	=> 'Gers',
			'33'	=> 'Gironde',
			'34'	=> 'Hérault',
			'35'	=> 'Ille et Vilaine',
			'36'	=> 'Indre',
			'37'	=> 'Indre et Loire',
			'38'	=> 'Isère',
			'39'	=> 'Jura',
			'40'	=> 'Landes',
			'41'	=> 'Loir et Cher',
			'42'	=> 'Loire',
			'43'	=> 'Loire',
			'44'	=> 'Loire Atlantique',
			'45'	=> 'Loiret',
			'46'	=> 'Lot',
			'47'	=> 'Lot et Garonne',
			'48'	=> 'Lozère',
			'49'	=> 'Maine et Loire',
			'50'	=> 'Manche',
			'51'	=> 'Marne',
			'52'	=> 'Marne Haute : Chaumont',
			'53'	=> 'Mayenne',
			'54'	=> 'Meurthe et Moselle',
			'55'	=> 'Meuse',
			'56'	=> 'Morbihan',
			'57'	=> 'Moselle : Metz',
			'58'	=> 'Nièvre',
			'59'	=> 'Nord',
			'60'	=> 'Oise',
			'61'	=> 'Orne',
			'62'	=> 'Pas de Calais',
			'63'	=> 'Puy de dôme',
			'64'	=> 'Pyrénées-Atlantiques',
			'65'	=> 'Pyrénées',
			'66'	=> 'Pyrénées Orientales',
			'67'	=> 'Rhin bas',
			'68'	=> 'Rhin Haut',
			'69'	=> 'Rhône',
			'70'	=> 'Saône haute',
			'71'	=> 'Saône et loire',
			'72'	=> 'Sarthe',
			'73'	=> 'Savoie',
			'74'	=> 'Savoie haute',
			'75'	=> 'Paris',
			'76'	=> 'Seine Maritime',
			'77'	=> 'Seine et Marne',
			'78'	=> 'Yvelines',
			'79'	=> 'Sèvres deux',
			'80'	=> 'Somme',
			'81'	=> 'Tarn',
			'82'	=> 'Tarn et Garonne',
			'83'	=> 'Var',
			'84'	=> 'Vaucluse',
			'85'	=> 'Vendée',
			'86'	=> 'Vienne',
			'87'	=> 'Vienne Haute',
			'88'	=> 'Vosges',
			'89'	=> 'Yonne',
			'90'	=> 'Territoire de Belfort',
			'91'	=> 'Essonne',
			'92'	=> 'Hauts de seine',
			'93'	=> 'Seine st Denis',
			'94'	=> 'Val de Marne',
			'95'	=> 'Val d\'Oise',
			'971'	=> 'Guadeloupe',
			'972'	=> 'Martinique',
			'973'	=> 'Guyane',
			'974'	=> 'Réunion',
			'975'	=> 'St Pierre et Miquelon',
			'985'	=> 'Nouvelle Calédonie',
			'986'	=> 'Wallis et Futuna',
			'987'	=> 'Polynésie Française',
			'976'	=> 'Mayotte : Mamoutzou',
			'984'	=> 'Terres australes et Antartiques Françaises'
		)
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
		if( ! isset($data['custom']['state_display']) ):
		
			$data['custom']['state_display'] = 'abbr';
	
		endif;
		
		if( ! isset($data['custom']['country']) ):
		
			$data['custom']['country'] = 'US';
	
		endif;
	
	
		return form_dropdown($data['form_slug'], $this->states($field->is_required, $data['custom']['state_display'], $data['custom']['country']), $data['value'], 'id="'.$data['form_slug'].'"');
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
		$full= '';
		if(isset($this->raw_states['US'][$input])) 
			{ $full = $this->raw_states['NL'][$input]; }
		elseif(isset($this->raw_states['NL'][$input])) 
			{ $full = $this->raw_states['NL'][$input]; }
		elseif(isset($this->raw_states['FR'][$input])) 
			{ $full = $this->raw_states['FR'][$input]; }
		
		return array(
			'abbr'	=> $input,
			'full' 	=> $full
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
		// Default is US.
		if( ! isset($data['country']) ):
		
			$data['country'] = 'US';
	
		endif;		
		$states = $this->states('yes', $data['state_display'], $data['country']);
	
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
			'full' => $this->CI->lang->line('streams.state.full'),
			'abbr' => $this->CI->lang->line('streams.state.abbr')
		);
	
		return form_dropdown('state_display', $options, $value);
	}

	// --------------------------------------------------------------------------
	
	// --------------------------------------------------------------------------

	/**
	 * Do we want the state full name of abbreviation?
	 *
	 * @access	public
	 * @return	string
	 */	
	public function param_country($value = null)
	{	
		$options = array(
			'US' => $this->CI->lang->line('streams.state.us'),
			'NL' => $this->CI->lang->line('streams.state.nl'),
			'FR' => $this->CI->lang->line('streams.state.fr')
		);
	
		return form_dropdown('country', $options, $value);
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
	private function states($is_required, $state_display = 'abbr', $country = 'US')
	{	
		if( $state_display != 'abbr' and $state_display != 'full') $state_display = 'abbr';
	

		$states = array();
		
		if($state_display == 'abbr'):
		
			foreach($this->raw_states[$country] as $abbr => $full):
			
				$states[$abbr] = $abbr;
			
			endforeach;
			
		else:
		
			$states = $this->raw_states[$country];
		
		endif; 
		
		 if($is_required == 'no') $states[null]=get_instance()->config->item('dropdown_choose_null');
		return $states;
	}
}

/* End of file field.state.php */
/* Location: ./system/cms/modules/streams_core/field_types/state/field.state.php */