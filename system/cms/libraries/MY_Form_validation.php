<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

class MY_Form_validation extends CI_Form_validation
{
	function __construct($rules = array())
	{
		parent::__construct($rules);
		$this->CI->load->language('extra_validation');
	}

	// --------------------------------------------------------------------

	/**
	 * Alpha-numeric with underscores dots and dashes
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function alpha_dot_dash($str)
	{
		return ( ! preg_match("/^([-a-z0-9_\-\.])+$/i", $str)) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Formats an UTF-8 string and removes potential harmful characters
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 * @author	Jeroen v.d. Gulik
	 * @since	v1.0-beta1
	 * @todo	Find decent regex to check utf-8 strings for harmful characters
	 */
	function utf8($str)
	{
		// If they don't have mbstring enabled (suckers) then we'll have to do with what we got
		if ( ! function_exists('mb_convert_encoding'))
		{
			return $str;
		}

		$str = mb_convert_encoding($str, 'UTF-8', 'UTF-8');

		return htmlentities($str, ENT_QUOTES, 'UTF-8');
	}

	// --------------------------------------------------------------------

	/**
	 * Format an error in the set error delimiters
	 *
	 * @access 	public
	 * @param	string
	 * @return	void
	 */
	public function format_error($error)
	{
		return $this->_error_prefix.$error.$this->_error_suffix;
	}

	// --------------------------------------------------------------------

	/**
	 * Valid URL
	 *
	 * @access 	public
	 * @param	string
	 * @return	void
	 */
	public function valid_url($str)
	{
		if (filter_var($str, FILTER_VALIDATE_URL))
		{
			return true;
		}
		else
		{
			$this->set_message('valid_url', $this->CI->lang->line('valid_url'));
			return false;
		}
	}

	// --------------------------------------------------------------------
	
	// NOTE: This was done because HMVC is not happy with $this->CI being used as a callback, instead it wants to look at CI::APP->controller
	// -- Phil
	
	/**
	 * Executes the Validation routines
	 *
	 * @access	private
	 * @param	array
	 * @param	array
	 * @param	mixed
	 * @param	integer
	 * @return	mixed
	 */
	protected function _execute($row, $rules, $postdata = NULL, $cycles = 0)
	{
		// If the $_POST data is an array we will run a recursive call
		if (is_array($postdata))
		{
			foreach ($postdata as $key => $val)
			{
				$this->_execute($row, $rules, $val, $cycles);
				$cycles++;
			}

			return;
		}

		// --------------------------------------------------------------------

		// If the field is blank, but NOT required, no further tests are necessary
		$callback = FALSE;
		if ( ! in_array('required', $rules) AND is_null($postdata))
		{
			// Before we bail out, does the rule contain a callback?
			if (preg_match("/(callback_\w+(\[.*?\])?)/", implode(' ', $rules), $match))
			{
				$callback = TRUE;
				$rules = (array('1' => $match[1]));
			}
			else
			{
				return;
			}
		}

		// --------------------------------------------------------------------

		// Isset Test. Typically this rule will only apply to checkboxes.
		if (is_null($postdata) AND $callback == FALSE)
		{
			if (in_array('isset', $rules, TRUE) OR in_array('required', $rules))
			{
				// Set the message type
				$type = (in_array('required', $rules)) ? 'required' : 'isset';

				if ( ! isset($this->_error_messages[$type]))
				{
					if (FALSE === ($line = $this->CI->lang->line($type)))
					{
						$line = 'The field was not set';
					}
				}
				else
				{
					$line = $this->_error_messages[$type];
				}

				// Build the error message
				$message = sprintf($line, $this->_translate_fieldname($row['label']));

				// Save the error message
				$this->_field_data[$row['field']]['error'] = $message;

				if ( ! isset($this->_error_array[$row['field']]))
				{
					$this->_error_array[$row['field']] = $message;
				}
			}

			return;
		}

		// --------------------------------------------------------------------

		// Cycle through each rule and run it
		foreach ($rules As $rule)
		{
			$_in_array = FALSE;

			// We set the $postdata variable with the current data in our master array so that
			// each cycle of the loop is dealing with the processed data from the last cycle
			if ($row['is_array'] == TRUE AND is_array($this->_field_data[$row['field']]['postdata']))
			{
				// We shouldn't need this safety, but just in case there isn't an array index
				// associated with this cycle we'll bail out
				if ( ! isset($this->_field_data[$row['field']]['postdata'][$cycles]))
				{
					continue;
				}

				$postdata = $this->_field_data[$row['field']]['postdata'][$cycles];
				$_in_array = TRUE;
			}
			else
			{
				$postdata = $this->_field_data[$row['field']]['postdata'];
			}

			// --------------------------------------------------------------------

			// Is the rule a callback?
			$callback = FALSE;
			if (substr($rule, 0, 9) == 'callback_')
			{
				$rule = substr($rule, 9);
				$callback = TRUE;
			}

			// Strip the parameter (if exists) from the rule
			// Rules can contain a parameter: max_length[5]
			$param = FALSE;
			if (preg_match("/(.*?)\[(.*)\]/", $rule, $match))
			{
				$rule	= $match[1];
				$param	= $match[2];
			}

			// Call the function that corresponds to the rule
			if ($callback === TRUE)
			{
				if ( ! method_exists(CI::$APP->controller, $rule))
				{
					throw new Exception('Undefined callback "'.$rule.'" in '.CI::$APP->controller);
				}

				// Run the function and grab the result
				$result = call_user_func(array(new CI::$APP->controller, $rule), $postdata, $param);

				// Re-assign the result to the master data array
				if ($_in_array == TRUE)
				{
					$this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
				}
				else
				{
					$this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
				}

				// If the field isn't required and we just processed a callback we'll move on...
				if ( ! in_array('required', $rules, TRUE) AND $result !== FALSE)
				{
					continue;
				}
			}
			else
			{
				if ( ! method_exists($this, $rule))
				{
					// If our own wrapper function doesn't exist we see if a native PHP function does.
					// Users can use any native PHP function call that has one param.
					if (function_exists($rule))
					{
						$result = $rule($postdata);

						if ($_in_array == TRUE)
						{
							$this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
						}
						else
						{
							$this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
						}
					}
					else
					{
						log_message('debug', "Unable to find validation rule: ".$rule);
					}

					continue;
				}

				$result = $this->$rule($postdata, $param);

				if ($_in_array == TRUE)
				{
					$this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
				}
				else
				{
					$this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
				}
			}

			// Did the rule test negatively?  If so, grab the error.
			if ($result === FALSE)
			{
				if ( ! isset($this->_error_messages[$rule]))
				{
					if (FALSE === ($line = $this->CI->lang->line($rule)))
					{
						$line = 'Unable to access an error message corresponding to your field name.'.$rule;
					}
				}
				else
				{
					$line = $this->_error_messages[$rule];
				}

				// Is the parameter we are inserting into the error message the name
				// of another field?  If so we need to grab its "field label"
				if (isset($this->_field_data[$param]) AND isset($this->_field_data[$param]['label']))
				{
					$param = $this->_translate_fieldname($this->_field_data[$param]['label']);
				}

				// Build the error message
				$message = sprintf($line, $this->_translate_fieldname($row['label']), $param);

				// Save the error message
				$this->_field_data[$row['field']]['error'] = $message;

				if ( ! isset($this->_error_array[$row['field']]))
				{
					$this->_error_array[$row['field']] = $message;
				}

				return;
			}
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Check Recaptcha callback
	 *
	 * Used for streams but can be used in other
	 * recaptcha situations.
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function check_recaptcha($val)
	{
		if ($this->CI->recaptcha->check_answer(
						$this->CI->input->ip_address(),
						$this->CI->input->post('recaptcha_challenge_field'),
						$val))
		{
	    	return true;
		}
		else
		{
			$this->set_message(
						'check_captcha',
						$this->CI->lang->line('recaptcha_incorrect_response'));
			
			return false;
	    }
	}

	// --------------------------------------------------------------------------

	/**
	 * Is unique
	 *
	 * Used by streams_core.
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	obj
	 * @return	bool
	 */
	public function streams_unique($string, $data)
	{
		// Split the data
		$items = explode(":", $data);
		
		$column 	= trim($items[0]);

		if ( ! isset($items[0]) or ! isset($items[1]))
		{
			return true;
		}

		$mode 		= $items[1];
		$stream_id	= $items[2];

		// Get the stream
		$stream = $this->CI->streams_m->get_stream($stream_id);
			
		$this->CI->db->where(trim($column), trim($string));
		
		$obj = $this->CI->db->get($stream->stream_prefix.$stream->stream_slug);
		
		if ($mode == 'new')
		{
			if ($obj->num_rows() == 0)
			{
				return true;
			}
		}
		elseif ($mode == 'edit')
		{
			// We need to see if the new value is different.
			$existing = $this->CI->db
				->select($column)
				->limit(1)
				->where( 'id', $this->CI->input->post('row_edit_id'))
				->get($stream->stream_prefix.$stream->stream_slug)
				->row();
			
			if ($existing->$column == $string)
			{
				// No change
				if ($obj->num_rows() >= 1) return true;
			}
			else
			{
				// There was a change. We treat it as new now.
				if($obj->num_rows() == 0) return true;
			}
		}

		$this->set_message('streams_unique', lang('streams.field_unique'));
	
		return FALSE;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Streams Field Type Validation Callback
	 *
	 * Used by streams as conduit to call custom
	 * callback functions.
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	public function streams_field_validation($value, $data)
	{
		// Data is in the form of field_id|mode
		// Mode is edit or new.
		$pieces = explode(':', $data);

		if (count($pieces) != 2) return false;

		$field_id 	= $pieces[0];
		$mode 		= $pieces[1];

		// Lets get the field
		$field = $this->CI->fields_m->get_field($field_id);

		// Check for the type
		if ( ! isset($this->CI->type->types->{$field->field_type}) or 
			 ! method_exists($this->CI->type->types->{$field->field_type}, 'validate'))
		{
			return false;
		}

		// Call the type. It will either return a string or true
		if (($result = $this->CI->type->types->{$field->field_type}->validate($value, $mode, $field)) === true)
		{
			return true;
		}
		else
		{
			$this->set_message('streams_field_validation', $result);
			return false;
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * File is Required
	 *
	 * Checks various inputs needed for files
	 * to see if one is indeed added.
	 *
	 * Used by Streams.
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	public function streams_file_required($string, $field)
	{
		// Do we already have something? If we are editing the row,
		// the file may already be there. We know that if the ID has a
		// numerical value, since it is hooked up with the PyroCMS
		// file system.
		if (is_numeric($this->CI->input->post($field)))
		{
			return true;
		}
		
		// OK. Now we really need to make sure there is a file here.
		// The method of choice here is checking for a file name		
		if (isset($_FILES[$field.'_file']['name']) and $_FILES[$field.'_file']['name'] != '')
		{
			// Don't do shit.
		}			
		else
		{
			$this->set_message('file_required', lang('streams.field_is_required'));
			return false;
		}

		return null;
	}

	// --------------------------------------------------------------------------

	/**
	 * Unique field slug
	 *
	 * Checks to see if the slug is unique based on the 
	 * circumstances
	 *
	 * Used by Streams.
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	void
	 */
	public function streams_unique_field_slug($field_slug, $mode)
	{
		$db_obj = $this->CI->db
						->select('id')
						->where('field_slug', trim($field_slug))
						->get(FIELDS_TABLE);
		
		if ($mode == 'new')
		{
			if( $db_obj->num_rows() > 0)
			{
				$this->set_message('unique_field_slug', lang('streams.field_slug_not_unique'));
				return false;
			}	
		}
		else
		{
			// Mode should be the existing slug
			if ($field_slug != $mode)
			{
				// We're changing the slug?
				// Better make sure it doesn't exist.
				if ($db_obj->num_rows() != 0)
				{
					$this->set_message('unique_field_slug', lang('streams.field_slug_not_unique'));
					return false;
				}			
			}
		}

		return true;		
	}

	// --------------------------------------------------------------------------

	/**
	 * Unique Stream Slug
	 *
	 * Checks to see if the stream is unique based on the 
	 * stream_slug
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	public function stream_unique($stream_slug, $mode)
	{
		$this->CI->db->select('id')->where('stream_slug', trim($stream_slug));
		$db_obj = $this->CI->db->get(STREAMS_TABLE);
		
		if ($mode == 'new')
		{
			if ($db_obj->num_rows() > 0)
			{
				$this->set_message('stream_unique', lang('streams.stream_slug_not_unique'));
				return false;	
			}
		}	
		else
		{
			// Mode should be the existing slug
			// We check the two to see if the slug is changing.
			// If it is changing we of course need to make sure
			// it is unique.
			if ($stream_slug != $mode)
			{
				if ($db_obj->num_rows() != 0)
				{
					$this->set_message('stream_unique', lang('streams.stream_slug_not_unique'));
					return false;
				}
			}
		}

		return true;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Slug Safe
	 *
	 * Sees if a word is safe for the DB. Used for
	 * stream_fields, etc.
	 *
	 * Used by Streams.
	 *
	 * @access 	public
	 * @param 	string
	 * @return 	bool
	 */
	public function stream_slug_safe($string)
	{	
		// See if word is MySQL Reserved Word
		if (in_array(strtoupper($string), $this->CI->config->item('streams:reserved')))
		{
			$this->set_message('slug_safe', lang('streams.not_mysql_safe_word'));
			return false;
		}
				
		// See if there are no-no characters
		if ( ! preg_match("/^([-a-z0-9_-])+$/i", $string))
		{
			$this->set_message('slug_safe', lang('streams.not_mysql_safe_characters'));
			return false;
		}
		
		return true;
	}

	// --------------------------------------------------------------------------

	/**
	 * Make sure a type is valid
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */	
	public function streams_type_valid($string)
	{
		if ($string == '-')
		{
			$this->set_message('type_valid', lang('streams.type_not_valid'));
			return false;
		}	
		
		return true;
	}

}

/* End of file MY_Form_validation.php */