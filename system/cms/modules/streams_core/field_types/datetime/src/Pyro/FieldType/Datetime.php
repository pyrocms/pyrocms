<?php namespace Pyro\FieldType;

use Carbon\Carbon;
use Pyro\Module\Streams_core\Core\Field\AbstractField;

/**
 * PyroStreams Date/Time Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Datetime extends AbstractField
{	
	public $field_type_slug			= 'datetime';
	
	public $db_col_type				= 'datetime';

	public $custom_parameters		= array('use_time', 'start_date', 'end_date', 'input_type', 'date_format');

	public $version					= '2.0.0';

	public $author					= array('name'=>'Parse19', 'url'=>'http://parse19.com');

	const  STORAGE_DATE_FORMAT		= 'Y-m-d H:i:s';
	const  ZERO_2_DIGIT 			= '00';
	const  ZERO_DATE 				= '0000-00-00';
	const  ZERO_DATETIME			= '0000-00-00 00:00:00';
	const  ZERO_TIME 				= '00:00:00';
	const  DISPLAY_DATETIME_FORMAT 	= 'M j Y g:i a';
	const  DISPLAY_DATE_FORMAT 		= 'M j Y';
	const  DATEPICKER_DATE_FORMAT	= 'yy-mm-dd';
	const  JS_DATE_RANGE_FORMAT		= 'Y,m,d,G,i,s';
	const  HALF_HOURS_PER_DAY 		= 12;

	const  JANUARY 					= 0;
	const  FEBRUARY 				= 1;
	const  APRIL 					= 2;
	const  MARCH 					= 3;
	const  MAY	 					= 4;
	const  JUNE 					= 5;
	const  JULY 					= 6;
	const  AUGUST 					= 7;
	const  SEPTEMBER 				= 8;
	const  OCTOBER 					= 9;
	const  NOVEMBER 				= 10;
	const  DECEMBER 				= 11;

	/**
	 * Validate input
	 *
	 * @access	public
	 * @param	string
	 * @param	string - mode: edit or new
	 * @param	object
	 * @return	mixed - true or error string
	 */
	public function validate()
	{
		// Up front, let's determine if this 
		// a required field.
		$field_data = ci()->form_validation->field_data($this->field->field_slug);
	
		// Determine required
		$rules = $field_data['rules'];
		$rules_array = explode('|', $rules);
		$required = (in_array('required', $rules_array)) ? true : false;

		// -------------------------------
		// Drop Down Required
		// -------------------------------
		// Since drop down requires three
		// separte fields, we do required
		// here. A dummy field is already
		// set up in the form to pass
		// required validation.
		// -------------------------------

		if ($this->getParameter('input_type', 'datepicker') == 'dropdown' and $required)
		{
			// Are all three fields available?
			if ( ! $month = $this->getMonthValue() or ! $day = $this->getDayValue() or ! $day = $this->getYearValue())
			{
				return lang('required');
			}
		}

		// -------------------------------
		// Date Range Validation
		// -------------------------------
/*
		if (is_array($restrict = $this->parse_restrict()))
		{
			// Man we gotta convert this now if it's the dropdown format
			if ($this->getParameter('input_type', 'datepicker') == 'dropdown')
			{
				if (( ! $month = $this->getMonthValue() or ! $day = $this->getDayValue() or ! $day = $this->getYearValue()) and $required)
				{
					return lang('streams:invalid_input_for_date_range_check');
				}

				$this->value = $month.'-'.$day;
			}


			ci()->load->helper('date');

			// Make sure input is in unix time
			if ( ! is_numeric($this->value))
			{
				$this->value = mysql_to_unix($this->value);
			}

			// Is either one blank? If so, we handle these
			// special.
			if ( ! $restrict['start_stamp'] and $restrict['end_stamp'])
			{
				// Is now after the future point
				if ($this->value > $restrict['end_stamp'])
				{
					return lang('streams:date_out_or_range');
				}
			}
			elseif ( ! $restrict['end_stamp'] and $restrict['start_stamp'])
			{
				// Is now before the past point
				if ($this->value < $restrict['start_stamp'])
				{
					return lang('streams:date_out_or_range');
				}
			}
			elseif ( ! $restrict['end_stamp'] and ! $restrict['start_stamp'])
			{
				// Two blank ranges means we don't need
				// to check any range.
				return true;
			}
			else
			{
				// Is the point before the start or
				// after the end?
				if ($this->value < $restrict['start_stamp'] or $this->value > $restrict['end_stamp'])
				{ 
					return lang('streams:date_out_or_range');
				}
			}
		}*/

		return true;
	}

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function formOutput()
	{
		// Form input type. Defaults to datepicker
		$input_type = $this->getParameter('input_type', 'datepicker');
		// -------------------------------------
		// Parse Date Range
		// -------------------------------------
		// Using the start_date and end_date
		// functions, figure out the unix values
		// of the date range.
		// -------------------------------------

		// -------------------------------------
		// Get/Parse Current Date
		// -------------------------------------
		$datetime = $this->getDateTime($this->value);

		// This is our form output type
		$date_input = null;

		// -------------------------------------
		// Date
		// -------------------------------------
		// We can either choose the date via
		// the jQuery datepicker or a series
		// of drop down menus.
		// ------------------------------------	
		if ($input_type == 'datepicker')
		{
			$start_datetime 	= Carbon::parse($this->getParameter('start_date', '-5 years'));
			$end_datetime 		= Carbon::parse($this->getParameter('end_date', '+5 years'));

			// -------------------------------------
			// jQuery Datepicker
			// -------------------------------------

			$dp_mods = array('dateFormat: "'.static::DATEPICKER_DATE_FORMAT.'"');
			
			// Start Date
			$dp_mods[] = 'minDate: new Date('.$start_datetime->format(static::JS_DATE_RANGE_FORMAT).')';

			// End Date
			$dp_mods[] = 'maxDate: new Date('.$end_datetime->format(static::JS_DATE_RANGE_FORMAT).')';
				
			$date_input = '';// '<script>$(function() {$("#'.$this->form_slug.'" ).datepicker({ '.implode(', ', $dp_mods).'});});</script>';

			$options['name'] 	= $this->form_slug;

			$options['id']		= $this->form_slug;

			$options['value']	= $datetime->year.'-'.$datetime->month.'-'.$datetime->day;

			$options['class']	= 'form-control';

			$options['data-date-format'] = static::DATEPICKER_DATE_FORMAT;
			
			$options['data-toggle'] = 'datepicker';
				
			$date_input .= form_input($options)."&nbsp;&nbsp;";
		
		} else {

			$start_datetime 	= Carbon::parse($this->getParameter('start_date', 'now'));
			$end_datetime 		= Carbon::parse($this->getParameter('end_date', '-100 years'));

			$month = '';
			$day = '';
			$year = '';

			if ($this->value != static::ZERO_DATETIME)
			{
				$month = $datetime->month;
				$day = $datetime->day;
				$year = $datetime->year;
			}

			// -------------------------------------
			// Drop down menu
			// -------------------------------------

			// Months
			$month_names = $this->getMonthNames();

			$months = array_combine($months = range(1, Carbon::MONTHS_PER_YEAR), $month_names);

			if ( ! $this->field->is_required)
			{
				$months = array('' => '---')+$months;
			}

			$date_input .= form_dropdown($this->form_slug.'_month', $months, $month);

			// Days
			$days = array_combine($days = range(1, 31), $days);

			if ( ! $this->field->is_required)
			{
				$days = array('' => '---')+$days;
			}

			$date_input .= form_dropdown($this->form_slug.'_day', $days, $day, 'style="min-width: 100px; width:100px;"');

			// Find the end year
			$years = array_combine($years = range($start_datetime->year, $end_datetime->year), $years);

	    	arsort($years, SORT_NUMERIC);

			if ( ! $this->field->is_required)
			{
				$years = array('' => '---')+$years;
			}

			$date_input .= form_dropdown($this->form_slug.'_year', $years, $year, 'style="min-width: 100px; width:100px;"');
		}
					
		// -------------------------------------
		// Time
		// -------------------------------------
		
		if ($this->getParameter('use_time') == 'yes')
		{
			// Hour	
			$hour_count = 0;
			
			$hours = array();
			
			while ($hour_count <= static::HALF_HOURS_PER_DAY )
			{
				$hour_key = $hour_count;
			
				if (strlen($hour_key) == 1)
				{
					$hour_key = '0'.$hour_key;
				}
			
				$hours[$hour_key] = $hour_count;
	
				$hour_count++;
			}

			$date_input .= lang('global:at').'&nbsp;&nbsp;'.form_dropdown($this->form_slug.'_hour', $hours, $datetime->format('h'), 'style="min-width: 100px; width:100px;" id="'.$this->form_slug.'_hour"');
			
			// Minute
			$minute_count = 0;
			
			$minutes = array();
			
			while ($minute_count <= Carbon::MINUTES_PER_HOUR-1)
			{
				$minute_key = $minute_count;
				
				if (strlen($minute_key) == 1)
				{
					$minute_key = '0'.$minute_key;
				}
			
				$minutes[$minute_key] = $minute_key;
			
				$minute_count++;
			}

			$date_input .= form_dropdown($this->form_slug.'_minute', $minutes, $datetime->minute, 'style="min-width: 100px; width:100px;"');
		
			// AM/PM
			$am_pm = array('am' => 'am', 'pm' => 'pm');
			
			$date_input .= form_dropdown($this->form_slug.'_am_pm', $am_pm, $datetime->format('a'), 'style="min-width: 100px; width:100px;"');
		
		}

		// Add hidden value for drop downs
		if ($input_type == 'dropdown')
		{
			// We always set this to 1 because we are performing
			// the required check in the validate function.
			$date_input .= form_hidden($this->form_slug, '1');
		}

		return $date_input;
	}

	/**
	 * Process before saving to database
	 *
	 * @access	public
	 * @param	array
	 * @param	obj
	 * @return	string
	 */
	public function preSave()
	{
		if ($this->getParameter('input_type', 'datepicker') == 'datepicker') {

			$hour = (int) $this->getHourValue(0);
			$minute = (int) $this->getMinuteValue(0);

			$date = explode('-', $this->value);

			if ($hour and $minute) {
			
				$datetime = Carbon::create($date[0], $date[1], $date[2], $hour, $minute, 0);
				$datetime = $this->to24Hour($datetime, $hour);
				
				return $datetime->format(static::STORAGE_DATE_FORMAT);
			
			} else {
			
				return $this->value.' '.static::ZERO_TIME;
			
			}
		}

		if ((bool) $this->getYearValue() and 
			(bool) $this->getMonthValue() and 
			(bool) $this->getDayValue() and
			(bool) $this->getHourValue() and
			(bool) $this->getMinuteValue()) {

			return (string) $this->getValueAsDatetime();
		}

		return static::ZERO_DATETIME;
	}
	
	/**
	 * Gets the posted date as a datetime object
	 *
	 * @access	private
	 * @param	string
	 * @return	array
	 */
	private function getValueAsDatetime()
	{
		$datetime = $this->getDateTime($this->value);

		if ($this->getParameter('input_type', 'datepicker') == 'dropdown' and $this->value == '1')
		{
			$datetime->year = $this->getYearValue($datetime->year);

			$datetime->month = $this->getMonthValue($datetime->month);

			$datetime->day = $this->getDayValue($datetime->day);
		}

		$datetime = $this->to24Hour($datetime, $this->getHourValue($datetime->hour));

		$datetime->minute = $this->getMinuteValue($datetime->minute);

		return $datetime;
	}
	
	/**
	 * Start Date
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	public function paramStartDate($value = null)
	{
		$options['name'] 	= 'start_date';
		$options['id']		= 'start_date';
		$options['value']	= $value;
		
		return array(
			'input' 		=> form_input($options),
			'instructions'	=> lang('streams:datetime.rest_instructions')
		);
	}

	/**
	 * End Date
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	public function paramEndDate($value = null)
	{
		$options['name'] 	= 'end_date';
		$options['id']		= 'end_date';
		$options['value']	= $value;
		
		return array(
			'input' 		=> form_input($options),
			'instructions'	=> lang('streams:datetime.rest_instructions')
		);
	}
	
	/**
	 * Should we use time? Extra parameter
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	public function paramUseTime($value = null)
	{
		if ($value == 'no')
		{
			$no_select 		= true;
			$yes_select 	= false;
		}
		else
		{
			$no_select 		= false;
			$yes_select 	= true;
		}
	
		$form  = '<ul><li><label>'.form_radio('use_time', 'yes', $yes_select).' Yes</label></li>';
		
		$form .= '<li><label>'.form_radio('use_time', 'no', $no_select).' No</label></li>';
		
		return $form;
	}

	/**
	 * How should we store this in the DB?
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	public function paramInputType($value = null)
	{
		$options = array(
			'datepicker'	=> 'Datepicker',
			'dropdown'		=> 'Dropdown'
		);
			
		return form_dropdown('input_type', $options, $value);
	}

	/** Date format
	 * @param  string
	 * @return string
	 */
	public function paramDateFormat($value = null)
	{
		$data = array(
        	'name'        => 'date_format',
            'id'          => 'date_format',
        	'value'       => $value,
        	'maxlength'   => '255'
 		);

		return form_input($data);
	}

	/**
	 * Process before outputting
	 *
	 * @access	public
	 * @param	array
	 * @return	string
	 */
	public function preOutput()
	{
		return $this->format();
	}

	/**
	 * Format date
	 * 
	 * @param  string $date_string  The date string
	 * @param  string $format Datetime format
	 * @return string
	 */
	public function format($date_string = null, $format = null)
	{
		if ( ! $date_string and ! $this->value) return static::ZERO_DATETIME;

		$date_string = $date_string ? $date_string : $this->value;

		if ($this->getParameter('use_time') == 'yes') {
			$default_format = static::DISPLAY_DATETIME_FORMAT;
		} else {
			$default_format = static::DISPLAY_DATE_FORMAT;
		}

		$format = $format ? $format : $this->getParameter('date_format', $default_format);
		
		return $this->getDateTime($date_string)->format($format);
	}

	/**
	 * Pre Ouput Plugin
	 *
	 * Ouput the UNIX time.
	 * 
	 * @access	public
	 * @param	array
	 * @return	string
	 */
	public function preOutputPlugin()
	{
		if ( ! $this->value) return null;

		return $this->getDateTime($this->value);
	}

	/**
	 * Return a timestamp as DateTime object.
	 *
	 * @param  mixed  $value
	 * @return \Carbon\Carbon
	 */
	public function getDateTime($date_string = null)
	{
		if ($date_string === static::ZERO_DATETIME or $date_string === null) return Carbon::createFromTime(0,0,0);

		if (is_string($date_string)) {
			$date_time = explode(' ', $date_string);

			$date = $date_time[0];
			$time = ! empty($date_time[1]) ? $date_time[1] : '';

			$date = explode('-', $date);
			$time = explode(':', $time);

			if (count($date) == 3) {
				$year = $date[0];
				$month = $date[1];
				$day = $date[2];
				$hour = ! empty($time[0]) ? $time[0] : 0;
				$minute = ! empty($time[1]) ? $time[1] : 0;

				return Carbon::create($year, $month, $day, $hour, $minute, 0);	
			}
		}

		// If this value is an integer, we will assume it is a UNIX timestamp's value
		// and format a Carbon object from this timestamp. This allows flexibility
		// when defining your date fields as they might be UNIX timestamps here.
		if (is_numeric($date_string))
		{
			return Carbon::createFromTimestamp($date_string);
		}
		elseif ( ! $date_string instanceof DateTime)
		{
			return Carbon::createFromFormat(static::STORAGE_DATE_FORMAT, $date_string);
		}
		
		return Carbon::instance($date_string);
	}

	protected function to24Hour($datetime, $hour = 0)
	{
		if ($this->getAmPmValue() == 'pm' and $hour <= static::HALF_HOURS_PER_DAY)
		{
			$datetime->addHours(static::HALF_HOURS_PER_DAY);
		}

		return $datetime;
	}

	protected function to12Hour($hour = 0)
	{
		return ($hour <= static::HALF_HOURS_PER_DAY) ? $hour : (int) $hour - static::HALF_HOURS_PER_DAY;
	}

	public function getMonthNames()
	{
		ci()->lang->load('calendar');

		return array(
			static::JANUARY		=> lang('cal_january'),
			static::FEBRUARY 	=> lang('cal_february'),
			static::MARCH		=> lang('cal_march'),
			static::MAY 		=> lang('cal_april'),
			static::APRIL		=> lang('cal_mayl'),
			static::JUNE		=> lang('cal_june'),
			static::JULY		=> lang('cal_july'),
			static::AUGUST		=> lang('cal_august'),
			static::SEPTEMBER	=> lang('cal_september'),
			static::OCTOBER		=> lang('cal_october'),
			static::NOVEMBER	=> lang('cal_november'),
			static::DECEMBER	=> lang('cal_december'),
		);
	}
}
