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

	protected $storage_format			= 'Y-m-d H:i:s';
	protected $zero_2_digit 			= '00';
	protected $zero_date 				= '0000-00-00';
	protected $zero_datetime			= '0000-00-00 00:00:00';
	protected $zero_time 				= '00:00:00';
	protected $display_datetime_format 	= 'M j Y g:i a';
	protected $display_date_format 		= 'M j Y';
	protected $datepicker_date_format	= array('mm-dd-yyyy', 'm-d-Y');
	protected $timepicker_time_format	= 'g:i A';
	protected $half_hours_per_day 		= 12;

	const JANUARY 					= 0;
	const FEBRUARY 					= 1;
	const APRIL 					= 2;
	const MARCH 					= 3;
	const MAY	 					= 4;
	const JUNE 						= 5;
	const JULY 						= 6;
	const AUGUST 					= 7;
	const SEPTEMBER 				= 8;
	const OCTOBER 					= 9;
	const NOVEMBER 					= 10;
	const DECEMBER 					= 11;

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function formInput()
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
		if (empty($this->value)) {
			$datetime = false;
		} else {
			$datetime = Carbon::createFromFormat($this->storage_format, $this->value);
		}

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
			// Caps
			$start_datetime 	= Carbon::parse($this->getParameter('start_date', '-5 years'));
			$end_datetime 		= Carbon::parse($this->getParameter('end_date', '+5 years'));

			// Input options
			$options = array(
				'name' => $this->form_slug,
				'id' => $this->form_slug,
				'value' => $datetime ? $datetime->format($this->datepicker_date_format) : null,
				'class' => 'form-control',
				'data-toggle' => 'datepicker',
				'data-date-format' => $this->datepicker_date_format[0],
				);
			
				
			$date_input .= form_input($options)."&nbsp;&nbsp;";
		
		} else {

			$start_datetime 	= Carbon::parse($this->getParameter('start_date', 'now'));
			$end_datetime 		= Carbon::parse($this->getParameter('end_date', '-100 years'));

			$month = '';
			$day = '';
			$year = '';

			if ($this->value != $this->$zero_datetime)
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
			
			while ($hour_count <= $this->half_hours_per_day )
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

			return Carbon::createFromFormat($this->datepicker_date_format[1], $this->value)->hour(0)->minute(0)->second(0)->format($this->storage_format);
		}

		die($this->value);

		return $this->$zero_datetime;
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
	public function stringOutput()
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
		if ( ! $date_string and ! $this->value) return $this->$zero_datetime;

		$date_string = $date_string ? $date_string : $this->value;

		if ($this->getParameter('use_time') == 'yes') {
			$default_format = $this->display_datetime_format;
		} else {
			$default_format = $this->display_date_format;
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
	public function pluginOutput()
	{
		return $this->getDateTime($this->value);
	}

	/**
	 * Get translated month naes
	 * @return array
	 */
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
