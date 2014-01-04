<?php namespace Pyro\FieldType;

use Carbon\Carbon;
use Pyro\Module\Streams_core\AbstractFieldType;

/**
 * PyroStreams Date/Time Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Datetime extends AbstractFieldType
{	
	public $field_type_slug = 'datetime';
	
	public $db_col_type = 'datetime';

	public $custom_parameters = array(
		'use_time',
		'start_date',
		'end_date',
		'input_type',
		'date_format',
		);

	public $version = '2.0.0';

	public $author = array(
		'name'=>'Ryan Thompson - PyroCMS',
		'url'=>'http://pyrocms.com/'
		);

	protected $storage_format			= 'Y-m-d H:i:s';
	protected $zero_2_digit 			= '00';
	protected $zero_date 				= '0000-00-00';
	protected $zero_datetime			= '0000-00-00 00:00:00';
	protected $zero_time 				= '00:00:00';
	protected $display_datetime_format 	= 'M j Y g:i a';
	protected $display_date_format 		= 'M j Y';
	protected $half_hours_per_day 		= 12;
	public $datepicker_date_format		= array('mm-dd-yyyy', 'm-d-Y');
	public $timepicker_time_format		= 'g:i A';

	const JANUARY 						= 0;
	const FEBRUARY 						= 1;
	const APRIL 						= 2;
	const MARCH 						= 3;
	const MAY	 						= 4;
	const JUNE 							= 5;
	const JULY 							= 6;
	const AUGUST 						= 7;
	const SEPTEMBER 					= 8;
	const OCTOBER 						= 9;
	const NOVEMBER 						= 10;
	const DECEMBER 						= 11;

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
		// Get the datetime value in question
		// -------------------------------------

		$datetime = false;

		if (ci()->input->post($this->form_slug)) {

			// Make some safety catches
			$time = ci()->input->post($this->form_slug.'_time');
			$date = ci()->input->post($this->form_slug);

			// So we have a post value - grab it
			if (! isset($this->value) or $this->value == null or $this->value == $this->zero_datetime or $this->value == $this->zero_time) {
				
			} else {

				// Yep - are we using time?
				if ($this->getParameter('use_time', 'no') == 'no') {
					return Carbon::createFromFormat($this->datepicker_date_format[1], $date)->hour(0)->minute(0)->second(0)->format($this->storage_format);
				} elseif ($this->getParameter('use_time') == 'yes' and $time !== null) {
					return Carbon::createFromFormat($this->datepicker_date_format[1].' '.$this->timepicker_time_format, $date.' '.$time)->second(0)->format($this->storage_format);
				}
			}
		} else {

			// So we have a post value - grab it
			if ($this->value == null or $this->value == $this->zero_datetime) {
				
			} else {
				$datetime = Carbon::createFromFormat($this->storage_format, $this->value);
			}
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
				'value' => $datetime ? $datetime->format($this->datepicker_date_format[1]) : null,
				'class' => 'form-control',
				'data-toggle' => 'datepicker',
				'data-date-format' => $this->datepicker_date_format[0],
				'placeholder' => $this->datepicker_date_format[0],
				);
			
				
			$date_input .= '<div class="col-lg-3 input-group"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>'.form_input($options).'</div>';
		
		} else {

			$start_datetime 	= Carbon::parse($this->getParameter('start_date', 'now'));
			$end_datetime 		= Carbon::parse($this->getParameter('end_date', '-100 years'));

			$month = '';
			$day = '';
			$year = '';

			if ($this->value != $this->zero_datetime and $datetime)
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
			// Input options
			$options = array(
				'name' => $this->form_slug.'_time',
				'id' => $this->form_slug.'_time',
				'value' => $datetime ? $datetime->format($this->timepicker_time_format) : null,
				'class' => 'form-control',
				'data-toggle' => 'timepicker',
				'placeholder' => 'hh:mm aa',
				);
			
				
			$date_input .= '<div class="col-lg-3 input-group"><span class="input-group-addon"><i class="fa fa-clock-o"></i></span>'.form_input($options).'</div>';
		
		}

		// Add hidden value for drop downs
		if ($input_type == 'dropdown')
		{
			// We always set this to 1 because we are performing
			// the required check in the validate function.
			$date_input .= form_hidden($this->form_slug, '1');
		}

		return '<div>'.$date_input.'</div>';
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
		// Make some safety catches
		$time = ci()->input->post($this->form_slug.'_time');
		$date = ci()->input->post($this->form_slug);

		$month = ci()->input->post($this->form_slug.'_month');
		$day = ci()->input->post($this->form_slug.'_day');
		$year = ci()->input->post($this->form_slug.'_year');

		// Are we using a datepicker?
		if ($this->getParameter('input_type', 'datepicker') == 'datepicker' and $date != null and $data != $this->zero_date and ($this->getParameter('use_time', 'no') == 'no' and $time != $this->zero_time)) {

			// Yep - are we using time?
			if ($this->getParameter('use_time', 'no') == 'no') {
				return Carbon::createFromFormat($this->datepicker_date_format[1], $date)->hour(0)->minute(0)->second(0)->format($this->storage_format);
			} elseif ($this->getParameter('use_time') == 'yes' and $time !== null) {
				return Carbon::createFromFormat($this->datepicker_date_format[1].' '.$this->timepicker_time_format, $date.' '.$time)->second(0)->format($this->storage_format);
			}

		// Nope we're using the dropdown method
		} elseif ($month != null and $day != null and $year != null and ($this->getParameter('use_time', 'no') == 'no' and $time != $this->zero_time)) {

			// Yep - are we using time?
			if ($this->getParameter('use_time', 'no') == 'no') {
				return Carbon::createFromFormat('n-j-Y', $month.'-'.$day.'-'.$year)->hour(0)->minute(0)->second(0)->format($this->storage_format);
			} elseif ($this->getParameter('use_time') == 'yes' and $time !== null) {
				return Carbon::createFromFormat('n-j-Y '.$this->timepicker_time_format, $month.'-'.$day.'-'.$year.' '.$time)->second(0)->format($this->storage_format);
			}
		}

		// Meh
		return null;
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
		return $this->format() == $this->zero_datetime ? null : $this->format();
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
		if ( ! $date_string and ! $this->value) return $this->zero_datetime;

		$date_string = $date_string ? $date_string : $this->value;

		if ($this->getParameter('use_time') == 'yes') {
			$default_format = $this->display_datetime_format;
		} else {
			$default_format = $this->display_date_format;
		}

		$format = $format ? $format : $this->getParameter('date_format', $default_format);
		
		return Carbon::createFromFormat($this->storage_format, $date_string)->format($format);
	}

	/**
	 * Return a timestamp as DateTime object.
	 *
	 * @param  mixed  $value
	 * @return \Carbon\Carbon
	 */
	public function getDateTime($date_string = null)
	{		
		if ($date_string === $this->zero_datetime or $date_string === null) return Carbon::createFromTime(0,0,0);

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
			return Carbon::createFromFormat($this->storage_date_format, $date_string);
		}
		
		return Carbon::instance($date_string);
	}

	protected function to24Hour($datetime, $hour = 0)
	{
		if ($this->getAmPmValue() == 'pm' and $hour <= $this->half_hours_per_day)
		{
			$datetime->addHours($this->half_hours_per_day);
		}

		return $datetime;
	}

	protected function to12Hour($hour = 0)
	{
		return ($hour <= $this->half_hours_per_day) ? $hour : (int) $hour - $this->half_hours_per_day;
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

	///////////////////////////////////////////////////////////////////////////
	// -------------------------	PLUGINS	  ------------------------------ //
	///////////////////////////////////////////////////////////////////////////

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
		return (string) strtotime($this->value);
	}

	/**
	 * Allow return of custom formatted date
	 * @param  string $format
	 * @return string
	 */
	public function pluginFormat($format = 'Y-m-d H:i:s', $datetime = null)
	{
		return $this->format($datetime, $format);
	}

	public function pluginDifference($delta_datetime = null, $datetime = null, $absolute = false)
	{
		// Get delta datetime object
		if ($delta_datetime and $delta_datetime != 'now')
			$delta_datetime = Carbon::createFromFormat('Y-m-d H:i:s', $delta_datetime);
		else
			$delta_datetime = Carbon::now()->addDays(7);

		// Get datetime object
		if ($datetime and $datetime != 'now' and ! empty($datetime))
			$datetime = Carbon::createFromFormat('Y-m-d H:i:s', $datetime);
		else
			$datetime = Carbon::now();

		// Return the differences
		return (array) $datetime->diff($delta_datetime, (bool) $absolute);
	}
}
