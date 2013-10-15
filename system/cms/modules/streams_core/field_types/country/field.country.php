<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Streams_core\Core\Field\AbstractField;

/**
 * PyroStreams Country Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Adam Fairholm
 * @copyright	Copyright (c) 2011 - 2012, Adam Fairholm
 */
class Field_country extends AbstractField
{
	public $field_type_slug			= 'country';

	public $db_col_type				= 'string';

	public $version					= '1.1.0';

	public $custom_parameters   	= array('default_country');

	public $author					= array('name' => 'Adam Fairholm', 'url' => 'http://adamfairholm.com');

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
		if ( ! $this->value and ! $this->entry->getKey())
		{
			$value = $this->getParameter('default_country');
		} 
		else
		{
			$value = $this->value;
		}

		return form_dropdown($this->form_slug, $this->countries($this->field->is_required), $this->value, 'id="'.$this->form_slug.'"');
	}

	// --------------------------------------------------------------------------

	/**
	 * Output filter input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function filterOutput()
	{
		// Value
		// We only use the default value if this is a new
		// entry.

		return form_dropdown($this->getFilterSlug('is'), $this->countries(false), $this->getFilterSlug('is'), 'class="skip form-control"');
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
		$countries = $this->countries('yes');

		if (trim($this->value) != '') {
			return $countries[$this->value];
		} else {
			return null;
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function pre_output_plugin()
	{
		$countries = $this->countries('yes');

		$this->value = trim($this->value);

		if ($this->value != '') {
			$return['name'] = $countries[$this->value];
			$return['code']	= $this->value;

			return $return;
		} else {
			return null;
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Default Country Parameter
	 *
	 * @return 	string
	 */
	public function param_default_country($value = null)
	{
		// Return a drop down of countries
		// but we don't require them to give one.
		return form_dropdown('default_country', $this->countries('no'), $value);
	}

	// --------------------------------------------------------------------------

	/**
	 * Countries
	 *
	 * Returns an array of country choices
	 *
	 * @param 	bool 	$is_required 	If set to true, it will add a null value to array
	 * @return	array
	 */
	public function countries($is_required = false)
	{
		$choices = array();

		if ($is_required == 'no') {
			$choices[null] = get_instance()->config->item('dropdown_choose_null');
		}

		$countries = array(
	    	"AF" => "Afghanistan",
		    "AX" => "Aland Islands",
		    "AL" => "Albania",
		    "DZ" => "Algeria",
		    "AS" => "American Samoa",
		    "AD" => "Andorra",
		    "AO" => "Angola",
		    "AI" => "Anguilla",
		    "AQ" => "Antarctica",
		    "AG" => "Antigua and Barbuda",
		    "AR" => "Argentina",
		    "AM" => "Armenia",
		    "AW" => "Aruba",
		    "AU" => "Australia",
		    "AT" => "Austria",
		    "AZ" => "Azerbaijan",
		    "BS" => "Bahamas",
		    "BH" => "Bahrain",
		    "BD" => "Bangladesh",
		    "BB" => "Barbados",
		    "BY" => "Belarus",
		    "BE" => "Belgium",
		    "BZ" => "Belize",
		    "BJ" => "Benin",
		    "BM" => "Bermuda",
		    "BT" => "Bhutan",
		    "BO" => "Bolivia",
		    "BA" => "Bosnia and Herzegovina",
		    "BW" => "Botswana",
		    "BV" => "Bouvet Island",
		    "BR" => "Brazil",
		    "IO" => "British Indian Ocean Territory",
		    "VG" => "British Virgin Islands",
		    "BN" => "Brunei",
		    "BG" => "Bulgaria",
		    "BF" => "Burkina Faso",
		    "BI" => "Burundi",
		    "KH" => "Cambodia",
		    "CM" => "Cameroon",
		    "CA" => "Canada",
		    "CV" => "Cape Verde",
		    "KY" => "Cayman Islands",
		    "CF" => "Central African Republic",
		    "TD" => "Chad",
		    "CL" => "Chile",
		    "CN" => "China",
		    "CX" => "Christmas Island",
		    "CC" => "Cocos (Keeling) Islands",
		    "CO" => "Colombia",
		    "KM" => "Comoros",
		    "CG" => "Congo (Brazzaville)",
		    "CD" => "Congo (Kinshasa)",
		    "CK" => "Cook Islands",
		    "CR" => "Costa Rica",
		    "HR" => "Croatia",
		    "CU" => "Cuba",
		    "CW" => "Curaçao",
		    "CY" => "Cyprus",
		    "CZ" => "Czech Republic",
		    "DK" => "Denmark",
		    "DJ" => "Djibouti",
		    "DM" => "Dominica",
		    "DO" => "Dominican Republic",
		    "EC" => "Ecuador",
		    "EG" => "Egypt",
		    "SV" => "El Salvador",
		    "GQ" => "Equatorial Guinea",
		    "ER" => "Eritrea",
		    "EE" => "Estonia",
		    "ET" => "Ethiopia",
		    "FK" => "Falkland Islands",
		    "FO" => "Faroe Islands",
		    "FJ" => "Fiji",
		    "FI" => "Finland",
		    "FR" => "France",
		    "GF" => "French Guiana",
		    "PF" => "French Polynesia",
		    "TF" => "French Southern Territories",
		    "GA" => "Gabon",
		    "GM" => "Gambia",
		    "GE" => "Georgia",
		    "DE" => "Germany",
		    "GH" => "Ghana",
		    "GI" => "Gibraltar",
		    "GR" => "Greece",
		    "GL" => "Greenland",
		    "GD" => "Grenada",
		    "GP" => "Guadeloupe",
		    "GU" => "Guam",
		    "GT" => "Guatemala",
		    "GG" => "Guernsey",
		    "GN" => "Guinea",
		    "GW" => "Guinea-Bissau",
		    "GY" => "Guyana",
		    "HT" => "Haiti",
		    "HM" => "Heard Island and McDonald Islands",
		    "HN" => "Honduras",
		    "HK" => "Hong Kong S.A.R., China",
		    "HU" => "Hungary",
		    "IS" => "Iceland",
		    "IN" => "India",
		    "ID" => "Indonesia",
		    "IR" => "Iran",
		    "IQ" => "Iraq",
		    "IE" => "Ireland",
		    "IM" => "Isle of Man",
		    "IL" => "Israel",
		    "IT" => "Italy",
		    "CI" => "Ivory Coast",
		    "JM" => "Jamaica",
		    "JP" => "Japan",
		    "JE" => "Jersey",
		    "JO" => "Jordan",
		    "KZ" => "Kazakhstan",
		    "KE" => "Kenya",
		    "KI" => "Kiribati",
		    "KW" => "Kuwait",
		    "KG" => "Kyrgyzstan",
		    "LA" => "Laos",
		    "LV" => "Latvia",
		    "LB" => "Lebanon",
		    "LS" => "Lesotho",
		    "LR" => "Liberia",
		    "LY" => "Libya",
		    "LI" => "Liechtenstein",
		    "LT" => "Lithuania",
		    "LU" => "Luxembourg",
		    "MO" => "Macao S.A.R., China",
		    "MK" => "Macedonia",
		    "MG" => "Madagascar",
		    "MW" => "Malawi",
		    "MY" => "Malaysia",
		    "MV" => "Maldives",
		    "ML" => "Mali",
		    "MT" => "Malta",
		    "MH" => "Marshall Islands",
		    "MQ" => "Martinique",
		    "MR" => "Mauritania",
		    "MU" => "Mauritius",
		    "YT" => "Mayotte",
		    "MX" => "Mexico",
		    "FM" => "Micronesia",
		    "MD" => "Moldova",
		    "MC" => "Monaco",
		    "MN" => "Mongolia",
		    "ME" => "Montenegro",
		    "MS" => "Montserrat",
		    "MA" => "Morocco",
		    "MZ" => "Mozambique",
		    "MM" => "Myanmar",
		    "NA" => "Namibia",
		    "NR" => "Nauru",
		    "NP" => "Nepal",
		    "NL" => "Netherlands",
		    "AN" => "Netherlands Antilles",
		    "NC" => "New Caledonia",
		    "NZ" => "New Zealand",
		    "NI" => "Nicaragua",
		    "NE" => "Niger",
		    "NG" => "Nigeria",
		    "NU" => "Niue",
		    "NF" => "Norfolk Island",
		    "KP" => "North Korea",
		    "MP" => "Northern Mariana Islands",
		    "NO" => "Norway",
		    "OM" => "Oman",
		    "PK" => "Pakistan",
		    "PW" => "Palau",
		    "PS" => "Palestinian Territory",
		    "PA" => "Panama",
		    "PG" => "Papua New Guinea",
		    "PY" => "Paraguay",
		    "PE" => "Peru",
		    "PH" => "Philippines",
		    "PN" => "Pitcairn",
		    "PL" => "Poland",
		    "PT" => "Portugal",
		    "PR" => "Puerto Rico",
		    "QA" => "Qatar",
		    "RE" => "Reunion",
		    "RO" => "Romania",
		    "RU" => "Russia",
		    "RW" => "Rwanda",
		    "BL" => "Saint Barthélemy",
		    "SH" => "Saint Helena",
		    "KN" => "Saint Kitts and Nevis",
		    "LC" => "Saint Lucia",
		    "MF" => "Saint Martin (French part)",
		    "PM" => "Saint Pierre and Miquelon",
		    "VC" => "Saint Vincent and the Grenadines",
		    "WS" => "Samoa",
		    "SM" => "San Marino",
		    "ST" => "Sao Tome and Principe",
		    "SA" => "Saudi Arabia",
		    "SN" => "Senegal",
		    "RS" => "Serbia",
		    "SC" => "Seychelles",
		    "SL" => "Sierra Leone",
		    "SG" => "Singapore",
		    "SK" => "Slovakia",
		    "SI" => "Slovenia",
		    "SB" => "Solomon Islands",
		    "SO" => "Somalia",
		    "ZA" => "South Africa",
		    "GS" => "South Georgia and the South Sandwich Islands",
		    "KR" => "South Korea",
		    "ES" => "Spain",
		    "LK" => "Sri Lanka",
		    "SD" => "Sudan",
		    "SR" => "Suriname",
		    "SJ" => "Svalbard and Jan Mayen",
		    "SZ" => "Swaziland",
		    "SE" => "Sweden",
		    "CH" => "Switzerland",
		    "SY" => "Syria",
		    "TW" => "Taiwan",
		    "TJ" => "Tajikistan",
		    "TZ" => "Tanzania",
		    "TH" => "Thailand",
		    "TL" => "Timor-Leste",
		    "TG" => "Togo",
		    "TK" => "Tokelau",
		    "TO" => "Tonga",
		    "TT" => "Trinidad and Tobago",
		    "TN" => "Tunisia",
		    "TR" => "Turkey",
		    "TM" => "Turkmenistan",
		    "TC" => "Turks and Caicos Islands",
		    "TV" => "Tuvalu",
		    "VI" => "U.S. Virgin Islands",
		    "UG" => "Uganda",
		    "UA" => "Ukraine",
		    "AE" => "United Arab Emirates",
		    "GB" => "United Kingdom",
			"US" => "United States",
		    "UM" => "United States Minor Outlying Islands",
		    "UY" => "Uruguay",
		    "UZ" => "Uzbekistan",
		    "VU" => "Vanuatu",
		    "VA" => "Vatican",
		    "VE" => "Venezuela",
		    "VN" => "Vietnam",
		    "WF" => "Wallis and Futuna",
		    "EH" => "Western Sahara",
		    "YE" => "Yemen",
		    "ZM" => "Zambia",
		    "ZW" => "Zimbabwe",
		);

		return array_merge($choices, $countries);
	}

}
