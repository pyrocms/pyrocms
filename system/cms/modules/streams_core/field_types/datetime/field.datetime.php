<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Date/Time Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_datetime
{	
	public $field_type_slug			= 'datetime';
	
	public $db_col_type				= 'datetime';

	public $custom_parameters		= array('use_time', 'start_date', 'end_date', 'storage', 'input_type');

	public $version					= '2.0.0';

	public $author					= array('name'=>'Parse19', 'url'=>'http://parse19.com');

	// --------------------------------------------------------------------------
	
	/** 
	 * These are the pre-formatted
	 * date formats
	 */
	public $date_formats = array(
							'DATE_ATOM',
							'DATE_COOKIE',
							'DATE_ISO8601',
							'DATE_RFC822',
							'DATE_RFC850', 
							'DATE_RFC1036',
							'DATE_RFC1123',
							'DATE_RFC2822',
							'DATE_RSS',
							'DATE_W3C'
						);
		
	// --------------------------------------------------------------------------

	/**
	 * Event
	 *
	 * @access 	public
	 * @param 	obj
	 * @return 	void
	 */
	public function event($field)
	{
		// We need the JS file for the front-end. 
		if ( ! defined('ADMIN_THEME') and isset($field->field_data['input_type']) and $field->field_data['input_type'] == 'datepicker')
		{
			$this->CI->type->add_js('datetime', 'jquery.datepicker.js');
			$this->CI->type->add_css('datetime', 'datepicker.css');
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Validate input
	 *
	 * @access	public
	 * @param	string
	 * @param	string - mode: edit or new
	 * @param	object
	 * @return	mixed - true or error string
	 */
	public function validate($value, $mode, $field)
	{
		// Up front, let's determine if this 
		// a required field.
		$field_data = $this->CI->form_validation->field_data($field->field_slug);
	
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

		if ( ! isset($field->field_data['input_type']))
		{
			$field->field_data['input_type'] = 'dropdown';
		}

		if ($field->field_data['input_type'] == 'dropdown' and $required)
		{
			// Are all three fields available?
			if ( ! $_POST[$field->field_slug.'_month'] or ! $_POST[$field->field_slug.'_day'] or ! $_POST[$field->field_slug.'_year'])
			{
				return lang('required');
			}
		}

		// -------------------------------
		// Date Range Validation
		// -------------------------------

		if (is_array($restrict = $this->parse_restrict($field->field_data)))
		{
			// Man we gotta convert this now if it's the dropdown format
			if ($field->field_data['input_type'] == 'dropdown')
			{
				if (( ! $_POST[$field->field_slug.'_month'] or ! $_POST[$field->field_slug.'_day'] or ! $_POST[$field->field_slug.'_year']) and $required)
				{
					return lang('streams:invalid_input_for_date_range_check');
				}

				$value = $this->CI->input->post($field->field_slug.'_year').'-'.$this->CI->input->post($field->field_slug.'_month').'-'.$this->CI->input->post($field->field_slug.'_day');
			}


			$this->CI->load->helper('date');

			// Make sure input is in unix time
			if ( ! is_numeric($value))
			{
				$value = mysql_to_unix($value);
			}

			// Is either one blank? If so, we handle these
			// special.
			if ( ! $restrict['start_stamp'] and $restrict['end_stamp'])
			{
				// Is now after the future point
				if ($value > $restrict['end_stamp'])
				{
					return lang('streams:date_out_or_range');
				}
			}
			elseif ( ! $restrict['end_stamp'] and $restrict['start_stamp'])
			{
				// Is now before the past point
				if ($value < $restrict['start_stamp'])
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
				if ($value < $restrict['start_stamp'] or $value > $restrict['end_stamp'])
				{ 
					return lang('streams:date_out_or_range');
				}
			}
		}

		return true;
	}

	// --------------------------------------------------------------------------

	/**
	 * Check out the start and ending restrictions
	 *
	 * @param 	array
	 * @return 	array or false
	 */
	private function parse_restrict($field_data)
	{
		if (
			(isset($field_data['start_date']) and is_null($field_data['start_date'])) and 
			(isset($field_data['end_date']) and is_null($field_data['end_date']))
		)
		{
			return false;
		}

		if ( ! isset($field_data['start_date'])) $field_data['start_date'] = null;
		if ( ! isset($field_data['end_date'])) $field_data['end_date'] = null;

		$start_restrict = $this->parse_single_restrict($field_data['start_date'], 'start');
		$end_restrict 	= $this->parse_single_restrict($field_data['end_date'], 'end');

		return array_merge($start_restrict, $end_restrict);
	}

	// --------------------------------------------------------------------------

	/**
	 * Check out and parse a single
	 * date string restriction.
	 *
	 * @param 	string - the start/end string
	 * @param 	string - 'start' or 'end'
	 * @return 	array or false
	 */
	private function parse_single_restrict($string, $start_or_end, $prefix_vars = true)
	{
		// No matter what we need to return an array
		if ( ! trim($string))
		{
			if ($prefix_vars)
			{
				return array(
					$start_or_end.'_stamp' 		=> null,
					$start_or_end.'_jquery' 	=> null,
					$start_or_end.'_strtotime' 	=> null
				);
			}
			else
			{
				return array(
					'stamp' 					=> null,
					'jquery' 					=> null,
					'strtotime' 				=> null
				);
			}
		}

		$strtotime = null;

		if (is_numeric($string))
		{
			$strtotime = $string.' days';
		}
		else
		{
			$find 		= array('Y', 'M', 'W', 'D');
			$replace 	= array(' years', ' months', ' weeks', ' days');

			$strtotime = str_replace($find, $replace, $string);
		}

		if ($prefix_vars)
		{
			return array(
						$start_or_end.'_stamp' 		=> strtotime($strtotime),
						$start_or_end.'_jquery' 	=> $string,
						$start_or_end.'_strtotime' 	=> $strtotime
					);
		}
		else
		{
			return array(
						'stamp' 		=> strtotime($strtotime),
						'jquery' 		=> $string,
						'strtotime' 	=> $strtotime
					);
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
	public function form_output($data, $entry_id, $field)
	{
		// -------------------------------------
		// Parse Date Range
		// -------------------------------------
		// Using the start_date and end_date
		// functions, figure out the unix values
		// of the date range.
		// -------------------------------------

		if ( ! isset($data['custom']['start_date'])) $data['custom']['start_date'] = null;
		if ( ! isset($data['custom']['end_date'])) $data['custom']['end_date'] = null;

		$start_restrict 	= $this->parse_single_restrict($data['custom']['start_date'], 'start', false);
		$end_restrict 		= $this->parse_single_restrict($data['custom']['end_date'], 'end', false);

		// -------------------------------------
		// Get/Parse Current Date
		// -------------------------------------

		// Update the value to datetime format if it is UNIX.
		// The rest of the function expects datetime.
		if (isset($data['custom']['storage']) and $data['custom']['storage'] == 'unix')
		{
			if (is_numeric($data['value']))
			{
				$data['value'] = date('Y-m-d H:i:s', $data['value']);
			}
		}
		
		$date = $this->get_date(trim($data['value']), $data['form_slug'], $data['custom']['use_time']);

		// Form input type. Defaults to datepicker
		$input_type = ( ! isset($data['custom']['input_type'])) ? 'datepicker' : $data['custom']['input_type'];

		// This is our form output type
		$date_input = null;

		// -------------------------------------
		// Date
		// -------------------------------------
		// We can either choose the date via
		// the jQuery datepicker or a series
		// of drop down menus.
		// -------------------------------------
		
		$current_month = (isset($_POST[$data['form_slug'].'_month'])) ? $_POST[$data['form_slug'].'_month'] : $date['month'];
		$current_day = (isset($_POST[$data['form_slug'].'_day'])) ? $_POST[$data['form_slug'].'_day'] : $date['day'];
		$current_year = (isset($_POST[$data['form_slug'].'_year'])) ? $_POST[$data['form_slug'].'_year'] : $date['year'];
	
		if ($input_type == 'datepicker')
		{
			// -------------------------------------
			// jQuery Datepicker
			// -------------------------------------

			$dp_mods = array('dateFormat: "yy-mm-dd"');
		
			$current_year = date('Y');
			
			// Start Date
			if ($start_restrict['jquery'])
			{
				$dp_mods[] = 'minDate: "'.$start_restrict['jquery'].'"';
			}
			
			// End Date
			if ($end_restrict['jquery'])
			{
				$dp_mods[] = 'maxDate: "'.$end_restrict['jquery'].'"';	
			}	
				
			$date_input = '<script>$(function() {$("#datepicker_'.$data['form_slug'].'" ).datepicker({ '.implode(', ', $dp_mods).'});});</script>';

			$options['name'] 	= $data['form_slug'];
			$options['id']		= 'datepicker_'.$data['form_slug'];
			
			if ($date['year'] and $date['month'] and $date['day'])
			{
				$options['value']	= $date['year'].'-'.$date['month'].'-'.$date['day'];
			}	
				
			$date_input .= form_input($options)."&nbsp;&nbsp;";
		}
		else
		{
			// -------------------------------------
			// Drop down menu
			// -------------------------------------

			// Months
			$this->CI->lang->load('calendar');

			$month_names = array(
				lang('cal_january'),
				lang('cal_february'),
				lang('cal_march'),
				lang('cal_april'),
				lang('cal_mayl'),
				lang('cal_june'),
				lang('cal_july'),
				lang('cal_august'),
				lang('cal_september'),
				lang('cal_october'),
				lang('cal_november'),
				lang('cal_december'),
			);

			$months = array_combine($months = range(1, 12), $month_names);

			if ($field->is_required == 'no')
			{
				$months = array('' => '---')+$months;
			}

			$date_input .= form_dropdown($data['form_slug'].'_month', $months, $current_month);

			// Days
			$days = array_combine($days = range(1, 31), $days);

			if ($field->is_required == 'no')
			{
				$days = array('' => '---')+$days;
			}

			$date_input .= form_dropdown($data['form_slug'].'_day', $days, $current_day);

			// Years. The defauly is 100 years
			// ago to now.
			$start_year = date('Y')-100;
			$end_year	= date('Y');

			// Do we have a start or end restrict? If it it does have just months
			// or days (no years) those still might spill over into
			// the previous or next year.
			if ($start_restrict['strtotime'])
			{
				$start_year = date('Y', strtotime($start_restrict['strtotime']));
			}

			if ($end_restrict['strtotime'])
			{
				$end_year = date('Y', strtotime($end_restrict['strtotime']));
			}

			// Find the end year
			$years = array_combine($years = range($start_year, $end_year), $years);
	    	arsort($years, SORT_NUMERIC);

			if ($field->is_required == 'no')
			{
				$years = array('' => '---')+$years;
			}

			$date_input .= form_dropdown($data['form_slug'].'_year', $years, $current_year);
		}
					
		// -------------------------------------
		// Time
		// -------------------------------------
		
		if ($data['custom']['use_time'] == 'yes')
		{
			// Hour	
			$hour_count = 0;
			
			$hours = array();
			
			while ($hour_count <= 12 )
			{
				$hour_key = $hour_count;
			
				if (strlen($hour_key) == 1)
				{
					$hour_key = '0'.$hour_key;
				}
			
				$hours[$hour_key] = $hour_count;
	
				$hour_count++;
			}

			$date_input .= lang('global:at').'&nbsp;&nbsp;'.form_dropdown($data['form_slug'].'_hour', $hours, $date['hour'], 'style="min-width: 100px; width:100px;"');
			
			// Minute
			$minute_count = 0;
			
			$minutes = array();
			
			while ($minute_count <= 59)
			{
				$minute_key = $minute_count;
				
				if (strlen($minute_key) == 1)
				{
					$minute_key = '0'.$minute_key;
				}
			
				$minutes[$minute_key] = $minute_key;
			
				$minute_count++;
			}

			$date_input .= form_dropdown($data['form_slug'].'_minute', $minutes, $date['minute'], 'style="min-width: 100px; width:100px;"');
		
			// AM/PM
			$am_pm = array('am' => 'am', 'pm' => 'pm');
			
			// Is this AM or PM?
			if ($this->CI->input->post($data['form_slug'].'_am_pm'))
			{
				$am_pm_current = $this->CI->input->post($data['form_slug'].'_am_pm');
			}
			else
			{
				$am_pm_current = 'am';
			
				if (isset($date['pre_hour']))
				{
					if ($date['pre_hour'] >= 12)
					{
						$am_pm_current = 'pm';
					}
				}
			}
			
			$date_input .= form_dropdown($data['form_slug'].'_am_pm', $am_pm, $am_pm_current, 'style="min-width: 100px; width:100px;"');
		
		}

		// Add hidden value for drop downs
		if ($input_type == 'dropdown')
		{
			// We always set this to 1 because we are performing
			// the required check in the validate function.
			$date_input .= form_hidden($data['form_slug'], '1');
		}

		return $date_input;
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
		// Is this in UNIX time?
		if (isset($field->field_data['storage']) and $field->field_data['storage'] == 'unix')
		{	
			$this->db_col_type = 'int';
			return true;
		}
		else
		{
			// If not unix, let's see if we can need the
			// time part in our MySQL date/time
			if ($field->field_data['use_time'] == 'no')
			{
				$this->db_col_type = 'date';
			}
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Since we are not converting datetime/unix values right now,
	 * this just ensures that we do not change the type.
	 *
	 * @access 	public
	 * @param 	obj - field
	 * @param 	obj - stream
	 * @param 	obj - assignment
	 * @return 	void
	 */
	public function alt_rename_column($field, $stream, $assignment)
	{
		// What do we need to switch to?
		if ($this->CI->input->post('storage') == 'unix')
		{
			$type = 'int';
		}
		else
		{
			$type = ($this->CI->input->post('use_time') == 'yes') ? 'datetime' : 'date';
		}

		$col_data = $this->CI->fields_m->field_data_to_col_data($this->CI->type->types->{$field->field_type}, $this->CI->input->post(), 'edit');

		$col_data['type'] = strtoupper($type);

		$this->CI->dbforge->modify_column($assignment->stream_prefix.$assignment->stream_slug, array($field->field_slug => $col_data));
	}

	// --------------------------------------------------------------------------

	public function form_data($key, $form_data)
	{
		if (isset($form_data[$key]))
		{
			return $form_data[$key];
		}
		else
		{
			return null;
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Process before saving to database
	 *
	 * @access	public
	 * @param	array
	 * @param	obj
	 * @return	string
	 */
	public function pre_save($input, $field, $stream, $row_id, $form_data)
	{
		// -------------------------------------
		// Date
		// -------------------------------------

		$input_type = ( ! isset($field->field_data['input_type'])) ? 'datepicker' : $field->field_data['input_type'];

		if ($input_type == 'datepicker')
		{
			// No collecting data necessary
			$date = $this->form_data($field->field_slug, $form_data);
		}
		else
		{
			// Get from post data
			$date = $this->form_data($field->field_slug.'_year', $form_data).
				'-'.$this->two_digit_number($this->form_data($field->field_slug.'_month', $form_data)).
				'-'.$this->two_digit_number($this->form_data($field->field_slug.'_day', $form_data));
		}

		// -------------------------------------
		// Null value check
		// -------------------------------------
		// We need some special logic to recognize
		// a completely null value 
		// -------------------------------------

		if ( ! $input or $date == '-00-00' or $date == '0000-00-00')
		{
			if (isset($field->field_data['storage']) and $field->field_data['storage'] == 'unix')
			{
				return '0';
			}
			elseif (isset($field->field_data['storage']) and $field->field_data['storage'] == 'date')
			{
				return '0000-00-00';
			}
			else
			{
				return '0000-00-00 00:00:00';
			}
		}

		// -------------------------------------
		// Time
		// -------------------------------------

		if ($field->field_data['use_time'] == 'yes')
		{
			// Hour
			if ($this->form_data($field->field_slug.'_hour', $form_data))
			{
				$hour = $this->form_data($field->field_slug.'_hour', $form_data);
	
				if ($this->form_data($field->field_slug.'_am_pm', $form_data) == 'pm' and $hour < 12)
				{
					$hour = $hour+12;
				}
			}	
			else
			{
				$hour = '00';
			}
			
			// Minute
			if ($this->form_data($field->field_slug.'_minute', $form_data))
			{
				$minute = $this->form_data($field->field_slug.'_minute', $form_data);
			}				
			else
			{
				$minute = '00';
			}
		}
		
		if ($field->field_data['use_time'] == 'yes')
		{
			$date .= ' '.$hour.':'.$minute.':00';
		}

		// -------------------------------------
		// Return based on storage format
		// -------------------------------------

		if (isset($field->field_data['storage']) and $field->field_data['storage'] == 'unix')
		{	
			$this->CI->load->helper('date');
			return mysql_to_unix($date);
		}
		
		return $date;
	}

	// --------------------------------------------------------------------------

	/**
	 * Turns a single digit number into a
	 * two digit number
	 *
	 * @access 	public
	 * @param 	string
	 * @return 	string
	 */
	public function two_digit_number($num)
	{
		$num = trim($num);

		if ($num == '')
		{
			return '00';
		}

		if (strlen($num) == 1)
		{
			return '0'.$num;
		}
		else
		{
			return $num;
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Process Year Input
	 *
	 * Make sense of user input field. It accepts:
	 *
	 * - An actual year
	 * - 'current' for the current year
	 * - +num or -num for an offset of the current year
	 *
	 * @access	private
	 * @param	string
	 * @return	string
	 */
	private function process_year_input($years_data)
	{
		// Blank value or current year.
		if (trim($years_data) == '' or $years_data == 'current' )
		{
			return date('Y');
		}
	
		// Is this numeric? If so then cool.
		if ($years_data[0] != '-' && $years_data[0] != '+' && is_numeric($years_data))
		{
			return $years_data;
		}
		
		// Else, we have + or - from the current time		
		if ($years_data[0] == '+')
		{
			$num = str_replace('+', '', $years_data);
			
			if (is_numeric($num))
			{
				return date('Y')+$num;
			}
		}
		elseif ($years_data[0] == '-')
		{
			$num = str_replace('-', '', $years_data);
			
			if (is_numeric($num))
			{
				return date('Y')-$num;
			}
		}
		
		// Default just return the current year		
		return date('Y');
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Break Date
	 *
	 * Breaks up the date into pieces for use in the form
	 *
	 * @access	private
	 * @param	string
	 * @return	array
	 */
	private function get_date($date, $slug, $use_time)
	{
		$out['year'] 	= '';
		$out['month']	= '';
		$out['day']		= '';
		$out['hour']	= '';
		$out['minute']	= '';

		if ($date == '')
		{
			return $out;
		}
		
		if ($date == 'dummy' or $date == '1')
		{
			$date = $_POST[$slug.'_year'].'-'.$_POST[$slug.'_month'].'-'.$_POST[$slug.'_day'];
			
			if ($use_time == 'yes')
			{
				$date .= ' '.$_POST[$slug.'_hour'].':'.$_POST[$slug.'_minute'].':00';
			}
			else
			{
				$date .= ' 00:00:00';
			}
		}
		
		$raw_time = explode(' ', $date);
		
		$dates = explode('-', $raw_time[0]);
		
		if ($use_time == 'yes')
		{
			$times = explode(':', $raw_time[1]);
		}
		
		$out = array();
		
		$out['year'] 	= $dates[0];
		$out['month']	= $dates[1];
		$out['day']		= $dates[2];
		
		if ($use_time == 'yes')
		{
			$out['hour']		= $this->two_digit_number($times[0]);
			$out['minute']		= $this->two_digit_number($times[1]);
			$out['pre_hour']	= $this->two_digit_number($out['hour']);
			
			// Format hour for our drop down since we are using am/pm
			if( $out['hour'] > 12 ) $out['hour'] = $out['hour']-12;
		}

		return $out;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Start Date
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	public function param_start_date($value = null)
	{
		$options['name'] 	= 'start_date';
		$options['id']		= 'start_date';
		$options['value']	= $value;
		
		return array(
			'input' 		=> form_input($options),
			'instructions'	=> $this->CI->lang->line('streams:datetime.rest_instructions')
		);
	}

	// --------------------------------------------------------------------------

	/**
	 * End Date
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	public function param_end_date($value = '')
	{
		$options['name'] 	= 'end_date';
		$options['id']		= 'end_date';
		$options['value']	= $value;
		
		return array(
			'input' 		=> form_input($options),
			'instructions'	=> $this->CI->lang->line('streams:datetime.rest_instructions')
		);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Should we use time? Extra parameter
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	public function param_use_time($value = '')
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

	// --------------------------------------------------------------------------
	
	/**
	 * How should we store this in the DB?
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	public function param_storage($value = null)
	{
		$options = array(
					'datetime'	=> 'MySQL Datetime',
					'unix'		=> 'Unix Time'			
		);

		if ($value)
		{
			return form_hidden('storage', $value).'<p>'.$options[$value].'</p>';
		}
		else
		{
			return form_dropdown('storage', $options, $value);
		}
	}

	// --------------------------------------------------------------------------
	
	/**
	 * How should we store this in the DB?
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	public function param_input_type($value = null)
	{
		$options = array(
					'datepicker'	=> 'Datepicker',
					'dropdown'		=> 'Dropdown'
		);
			
		return form_dropdown('input_type', $options, $value);
	}

	// --------------------------------------------------------------------------

	/**
	 * Process before outputting
	 *
	 * @access	public
	 * @param	array
	 * @return	string
	 */
	public function pre_output($input, $params)
	{
		// Don't show Dec 31st if empty silly
		if ( $input == null ) return null;
		
		// If this is a date-time stored value,
		// we need this to be converted to UNIX.
		if ( ! isset($params['storage']) or $params['storage'] == 'datetime')
		{
			$this->CI->load->helper('date');
			$input = mysql_to_unix($input);
		}
		
		// Format for admin
		if ($params['use_time'] == 'no')
		{
			return(date(Settings::get('date_format'), $input));
		}	
		else
		{
			return(date(Settings::get('date_format').' g:i a', $input));
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Pre Ouput Plugin
	 *
	 * Ouput the UNIX time.
	 * 
	 * @access	public
	 * @param	array
	 * @return	string
	 */
	public function pre_output_plugin($input, $params, $row_slug)
	{
		if ( ! $input) return null;

		if ( ! is_numeric($input))
		{
			$this->CI->load->helper('date');
			return mysql_to_unix($input);
		}
		else
		{
			return $input;
		}
	}
	
	// --------------------------------------------------------------------------

	/**
	 * Formats the date so things don't get screwed up
	 * by blank entries in the database
	 *
	 * @access	private
	 * @param	string
	 * @param	string
	 * @param	[bool]
	 * @return	string
	 */	
	private function format_date($format, $unix_date, $standard = false)
	{
		if ( ! $unix_date)
		{
			return null;
		}
		
		if ( ! $standard)
		{
			return date($format, $unix_date);
		}
		else
		{
			return standard_date($format, $unix_date);
		}
	}

}
