<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams US State Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @license		http://parse19.com/pyrostreams/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_timezone
{
	public $field_type_slug			= 'timezone';
	
	public $db_col_type				= 'varchar';

	public $version					= '1.0';

	public $author					= array('name'=>'Ryun Shonfer', 'url'=>'http://humboldtweb.com');

	public static $regions = array(
		'America'    => DateTimeZone::AMERICA,
		'Europe'     => DateTimeZone::EUROPE,
		'Asia'       => DateTimeZone::ASIA,
		'Africa'     => DateTimeZone::AFRICA,
		'Atlantic'   => DateTimeZone::ATLANTIC,
		'Antarctica' => DateTimeZone::ANTARCTICA,
		'Indian'     => DateTimeZone::INDIAN,
		'Pacific'    => DateTimeZone::PACIFIC
	);

	public static $tz_array = array();
	

	// --------------------------------------------------------------------------

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

		return form_dropdown($data['form_slug'], $this->get_tz_array(), $data['value'], 'id="'.$data['form_slug'].'"');
	}

	private function get_tz_array()
	{
		if (empty(self::$tz_array))
		{
			foreach (self::$regions as $name => $mask)
			{
				$tz = array();
				foreach(DateTimeZone::listIdentifiers($mask) as $val)
				{
					$tz[$val] = $val;
				}
			    self::$tz_array[$name] = $tz;
			}
		}
		return self::$tz_array;
	}
}