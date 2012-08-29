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

	// We can add to this in the event
	public $extra_validation 		= array('streams_date_format');

	public $version					= '2.0';

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
		if ( ! defined('ADMIN_THEME'))
		{
			$this->CI->type->add_js('datetime', 'jquery.datepicker.js');
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Special event called before
	 * validation rules are compiled
	 */
	public function pre_validation_compile($field)
	{
		// Add the restrict range validation if it is needed.
		if (is_array($restrict = $this->parse_restrict($field->field_data)))
		{
			$this->extra_validation[] = 'streams_date_range['.$restrict['start_stamp'].'|'.$restrict['end_stamp'].']';
		}
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
			$replace 	= array('years', 'months', 'weeks', 'days');

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
	public function form_output($data)
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
			$date_input .= form_dropdown($data['form_slug'].'_month', $months, $date['month']);

			// Days
	    	$days 	= array_combine($days 	= range(1, 31), $days);
			$date_input .= form_dropdown($data['form_slug'].'_day', $days, $date['day']);

			// Years. The defauly is 120 years
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
	    	$years 	= array_combine($years = range($start_year, $end_year), $years);
	    	arsort($years, SORT_NUMERIC);
			$date_input .= form_dropdown($data['form_slug'].'_year', $years, $date['year']);
		}
					
		// -------------------------------------
		// Time
		// -------------------------------------
		
		if ($data['custom']['use_time'] == 'yes')
		{
			// Hour	
			$hour_count = 1;
			
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

			$date_input .= form_dropdown($data['form_slug'].'_hour', $hours, $date['hour']);
			
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

			$date_input .= form_dropdown($data['form_slug'].'_minute', $minutes, $date['minute']);
		
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
			
			$date_input .= form_dropdown($data['form_slug'].'_am_pm', $am_pm, $am_pm_current, 'style="small_select"');
		
		}

		// Add hidden value for drop downs
		if ($input_type == 'dropdown')
		{
			$date_input .= form_hidden($data['form_slug'], $data['value']);
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
		
		// We need more room for checkboxes
		if ($field->field_data['use_time'] == 'no')
		{
			$this->db_col_type = 'date';
		}
		
		return true;
	}

	// --------------------------------------------------------------------------

	/**
	 * Update field
	 *
	 * We just need to change the date or datetime if it changed
	 */
	function update_field($field, $assignments)
	{
		// Check to see if this WAS date/datetime and is now UNIX
		if ($field->field_data['storage'] == 'unix' and $this->CI->input->post('storage') == 'datetime')
		{
			// @todo: Go through all the fields and update them to 
		}
		
		// Check to see if they are the same.
		// What happens below doesn't matter if they are.
		if( ($this->CI->input->post('use_time') == $field->field_data['use_time']) and 
			($this->CI->input->post('storage') == $field->field_data['storage']) )
		{
			return null;
		}
	
		// We need more room for checkboxes
		$switch_to = ($this->CI->input->post('use_time') == 'yes') ? 'datetime' : 'date';
		
		$this->CI->load->dbforge();
		
		// Run through assignments to change the col type
		foreach ($assignments as $assign)
		{
			$this->CI->db->query("ALTER TABLE ".$this->CI->db->dbprefix(STR_PRE.$assign->stream_slug)." CHANGE {$this->CI->input->post('field_slug')} {$this->CI->input->post('field_slug')} $switch_to");
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
	public function pre_save($input, $field)
	{
		// -------------------------------------
		// Date
		// -------------------------------------

		$input_type = ( ! isset($field->field_data['input_type'])) ? 'datepicker' : $field->field_data['input_type'];

		if ($input_type == 'datepicker')
		{
			// No collecting data necessary
			$date = $this->CI->input->post($field->field_slug);
		}
		else
		{
			// Get from post data
			$date = $this->CI->input->post($field->field_slug.'_year').
				'-'.$this->two_digit_number($this->CI->input->post($field->field_slug.'_month')).
				'-'.$this->two_digit_number($this->CI->input->post($field->field_slug.'_day'));
		}

		// -------------------------------------
		// Time
		// -------------------------------------

		if ($field->field_data['use_time'] == 'yes')
		{
			// Hour
			if ($this->CI->input->post($field->field_slug.'_hour'))
			{
				$hour = $this->CI->input->post($field->field_slug.'_hour');
	
				if ($this->CI->input->post($field->field_slug.'_am_pm') == 'pm' and $hour < 12)
				{
					$hour = $hour+12;
				}
			}	
			else
			{
				$hour = '00';
			}
			
			// Minute
			if ($this->CI->input->post($field->field_slug.'_minute'))
			{
				$minute = $this->CI->input->post($field->field_slug.'_minute');
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
		
		if ($date == 'dummy')
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
			'instructions'	=> $this->CI->lang->line('streams.datetime.rest_instructions')
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
			'instructions'	=> $this->CI->lang->line('streams.datetime.rest_instructions')
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
			
		return form_dropdown('storage', $options, $value);
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
			return(date($this->CI->settings->get('date_format'), $input));
		}	
		else
		{
			return(date($this->CI->settings->get('date_format').' g:i a', $input));
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

		if (is_numeric($input))
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
	private function format_date($format, $unix_date, $standard = FALSE)
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