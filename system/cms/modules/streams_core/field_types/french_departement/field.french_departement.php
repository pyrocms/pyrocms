<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams French Departement Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Geoffrey Monte Twitter : @PyroCMS_France - Jaap Jolmann
 */
class Field_french_departement
{
	public $field_type_slug			= 'french_departement';
	
	public $db_col_type				= 'varchar';

	public $version					= '1.0';

	public $author					= array('name'=>'Geoffrey Monté', 'url'=>'http://www.pyrocms.fr');
	
	public $custom_parameters		= array('departement_display');

	// --------------------------------------------------------------------------

	/**
	 * list of departements !
	 *
	 * @access 	public
	 * @var 	array
	 */
    public $raw_departement = array(
        '01'        =>    'Ain',
        '02'        =>    'Aisne',
        '03'        =>    'Allier',
        '04'        =>    'Alpes de Haute Provence',
        '05'        =>    'Alpes Hautes',
        '06'        =>    'Alpes Maritimes',
        '07'        =>    'Ardèche',
        '08'        =>    'Ardennes',
        '09'        =>    'Ariège',
        '10'    =>    'Aube',
        '11'    =>    'Aude',
        '12'    =>    'Aveyron',
        '13'    =>    'Bouches du Rhône',
        '14'    =>    'Calvados',
        '15'    =>    'Cantal',
        '16'    =>    'Charente',
        '17'    =>    'Charente Maritime',
        '18'    =>    'Cher',
        '19'    =>    'Corrèze',
        '2A'    =>    'Corse du sud',
        '2B'    =>    'Corse Haute',
        '21'    =>    'Côte d\'or',
        '22'    =>    'Cotes d\'Armor',
        '23'    =>    'Creuse',
        '24'    =>    'Dordogne',
        '25'    =>    'Doubs',
        '26'    =>    'Drôme',
        '27'    =>    'Eure',
        '28'    =>    'Eure et Loir',
        '29'    =>    'Finistère',
        '30'    =>    'Gard',
        '31'    =>    'Garonne',
        '32'    =>    'Gers',
        '33'    =>    'Gironde',
        '34'    =>    'Hérault',
        '35'    =>    'Ille et Vilaine',
        '36'    =>    'Indre',
        '37'    =>    'Indre et Loire',
        '38'    =>    'Isère',
        '39'    =>    'Jura',
        '40'    =>    'Landes',
        '41'    =>    'Loir et Cher',
        '42'    =>    'Loire',
        '43'    =>    'Loire',
        '44'    =>    'Loire Atlantique',
        '45'    =>    'Loiret',
        '46'    =>    'Lot',
        '47'    =>    'Lot et Garonne',
        '48'    =>    'Lozère',
        '49'    =>    'Maine et Loire',
        '50'    =>    'Manche',
        '51'    =>    'Marne',
        '52'    =>    'Marne Haute : Chaumont',
        '53'    =>    'Mayenne',
        '54'    =>    'Meurthe et Moselle',
        '55'    =>    'Meuse',
        '56'    =>    'Morbihan',
        '57'    =>    'Moselle : Metz',
        '58'    =>    'Nièvre',
        '59'    =>    'Nord',
        '60'    =>    'Oise',
        '61'    =>    'Orne',
        '62'    =>    'Pas de Calais',
        '63'    =>    'Puy de dôme',
        '64'    =>    'Pyrénées-Atlantiques',
        '65'    =>    'Pyrénées',
        '66'    =>    'Pyrénées Orientales',
        '67'    =>    'Rhin bas',
        '68'    =>    'Rhin Haut',
        '69'    =>    'Rhône',
        '70'    =>    'Saône haute',
        '71'    =>    'Saône et loire',
        '72'    =>    'Sarthe',
        '73'    =>    'Savoie',
        '74'    =>    'Savoie haute',
        '75'    =>    'Paris',
        '76'    =>    'Seine Maritime',
        '77'    =>    'Seine et Marne',
        '78'    =>    'Yvelines',
        '79'    =>    'Sèvres deux',
        '80'    =>    'Somme',
        '81'    =>    'Tarn',
        '82'    =>    'Tarn et Garonne',
        '83'    =>    'Var',
        '84'    =>    'Vaucluse',
        '85'    =>    'Vendée',
        '86'    =>    'Vienne',
        '87'    =>    'Vienne Haute',
        '88'    =>    'Vosges',
        '89'    =>    'Yonne',
        '90'    =>    'Territoire de Belfort',
        '91'    =>    'Essonne',
        '92'    =>    'Hauts de seine',
        '93'    =>    'Seine st Denis',
        '94'    =>    'Val de Marne',
        '95'    =>    'Val d\'Oise',
        '971'    =>    'Guadeloupe',
        '972'    =>    'Martinique',
        '973'    =>    'Guyane',
        '974'    =>    'Réunion',
        '975'    =>    'St Pierre et Miquelon',
        '985'    =>    'Nouvelle Calédonie',
        '986'    =>    'Wallis et Futuna',
        '987'    =>    'Polynésie Française',
        '976'    =>    'Mayotte : Mamoutzou',
        '984'   =>    'Terres australes et Antartiques Françaises'
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
		if( ! isset($data['custom']['departement_display']) ):
		
			$data['custom']['departement_display'] = 'abbr';
	
		endif;
	
		return form_dropdown($data['form_slug'], $this->departement($field->is_required, $data['custom']['departement_display']), $data['value'], 'id="'.$data['form_slug'].'"');
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
			'full' 	=> $this->raw_departement[$input]
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
		if( ! isset($data['departement_display']) ):
		
			$data['departement_display'] = 'abbr';
	
		endif;

		$departement = $this->departement('yes', $data['departement_display']);
	
		return ( isset($departement[$input]) ) ? $departement[$input] : null;
	}

	// --------------------------------------------------------------------------

	/**
	 * Do we want the departement full name of abbreviation?
	 *
	 * @access	public
	 * @return	string
	 */	
	public function param_departement_display($value = null)
	{	
		$options = array(
			'full' => $this->CI->lang->line('streams.french_departement.full'),
			'abbr' => $this->CI->lang->line('streams.french_departement.abbr')
		);
	
		return form_dropdown('departement_display', $options, $value);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * departement
	 *
	 * Returns an array of departement
	 *
	 * @access	private
	 * @return	array
	 */
	private function departement($is_required, $departement_display = 'abbr')
	{	
		if( $departement_display != 'abbr' and $departement_display != 'full') $departement_display = 'abbr';
	
		/*$choices = array();
	
		if($is_required == 'no') $choices[null] = get_instance()->config->item('dropdown_choose_null');*/
	
		$departement = array();
		
		if($departement_display == 'abbr'):
		
			foreach($this->raw_departement as $abbr => $full):
			
				$departement[$abbr] = $abbr;
			
			endforeach;
			
		else:
		
			$departement = $this->raw_departement;
		
		endif; 
		if($is_required == 'no') $departement[null]=get_instance()->config->item('dropdown_choose_null');
		return $departement;

	}
	
}