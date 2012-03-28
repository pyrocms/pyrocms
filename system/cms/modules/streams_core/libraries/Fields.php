<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Core Fields Library
 *
 * Handles forms and other field form logic.
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Libraries
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Fields
{
    function __construct()
    {
    	$this->CI = get_instance();
    
		$this->CI->load->helper('form');
	}

	// --------------------------------------------------------------------------

	/**
	 * Build form input
	 *
	 * Builds an individual form input from the
	 * type object
	 *
	 * @access	public
	 * @param	obj
	 * @param	bool
	 * @return	string
	 */
	public function build_form_input($field, $value = null, $row_id = null, $plugin = false)
	{
		$form_data['form_slug']		= $field->field_slug;
		$form_data['custom'] 		= $field->field_data;
		$form_data['value']			= $value;
		$form_data['max_length']	= (isset($field->field_data['max_length'])) ? $field->field_data['max_length'] : null;

		// If this is for a plugin, this relies on a function that
		// many field types will not have
		if ($plugin)
		{
			if (method_exists($this->CI->type->types->{$field->field_type}, 'form_output_plugin'))
			{
				return $this->CI->type->types->{$field->field_type}->form_output_plugin($form_data, $row_id, $field);
			}
			else
			{
				return false;
			}
		}
		else
		{
			return $this->CI->type->types->{$field->field_type}->form_output($form_data, $row_id, $field);
		}
	}

	// --------------------------------------------------------------------------
	
    /**
     * Build the form validation rules and the actual output.
     *
     * Based on the type of application we need it for, it will
     * either return a full form or an array of elements.
     * 
     * @access	public
     * @param	obj
     * @param	string
     * @param	mixed - false or row object
     * @param	bool - is this a plugin call?
     * @param	bool - are we using reCAPTCHA?
     * @param	array - all the skips
     * @param	array - extra data:
     *
     * - email_notifications
     * - return
     * - success_message
     * - failure_message
     * - error_start
     * - error_end
     * - required
     *
     * @return	array - fields
     */
 	public function build_form($stream, $method, $row = false, $plugin = false, $recaptcha = false, $skips = array(), $extra = array())
 	{
 		$this->CI->load->helper(array('form', 'url'));
 	
 		// -------------------------------------
		// Set default extras
		// -------------------------------------
		
		$default_extras = array(
			'email_notifications'		=> NULL,
			'return'					=> current_url(),
			'error_start'				=> NULL,
			'error_end'					=> NULL,
			'required'					=> '<span>*</span>'
		);
		
		if ($method == 'new')
		{
			$default_extras['success_message']	 = 'streams.new_entry_success';
			$default_extras['success_message']	 = 'streams.new_entry_error';
		}
		else
		{
			$default_extras['success_message']	 = 'streams.edit_entry_success';
			$default_extras['success_message']	 = 'streams.edit_entry_error';
		}
		
		foreach($default_extras as $key => $value)
		{
			if( ! isset($extra[$key])) $extra[$key] = $value;
		}

 		// -------------------------------------
		// Get Stream Fields
		// -------------------------------------
		
		$stream_fields = $this->CI->streams_m->get_stream_fields($stream->id);
		
		// Can't do nothing if we don't have any fields		
		if ($stream_fields === false) return false;
			
		// -------------------------------------
		// Run Type Events
		// -------------------------------------

		$events_called = $this->run_field_events($stream_fields, $skips);
				
		// -------------------------------------
		// Set Validation Rules
		// -------------------------------------

		$this->set_rules($stream_fields, $method, $skips);

		// -------------------------------------
		// Set Error Delimns
		// -------------------------------------

		$this->CI->form_validation->set_error_delimiters($extra['error_start'], $extra['error_end']);

		// -------------------------------------
		// Set reCAPTCHA
		// -------------------------------------
 
		if ($recaptcha)
		{
			$this->CI->config->load('streams_core/recaptcha');
			$this->CI->load->library('streams_core/Recaptcha');
			
			$this->CI->validation->set_rules('recaptcha_response_field', 'lang:recaptcha_field_name', 'required|check_captcha');
		}
		
		// -------------------------------------
		// Set Values
		// -------------------------------------

		$values = $this->set_values($stream_fields, $row, $method, $skips);

		// -------------------------------------
		// Validation
		// -------------------------------------
		
		$result_id = '';

		if ($this->CI->form_validation->run() === TRUE)
		{
			if($method == 'new')
			{
				if ( ! $result_id = $this->CI->row_m->insert_entry($_POST, $stream_fields, $stream, $skips))
				{
					$this->CI->session->set_flashdata('notice', $failure_message);	
				}
				else
				{
					// -------------------------------------
					// Send Emails
					// -------------------------------------
					
					if ($plugin and (isset($email_notifications) and $email_notifications))
					{
						foreach ($data->email_notifications as $notify)
						{
							$this->_send_email($notify, $result_id, $method = 'new', $stream);
						}
					}
	
					// -------------------------------------
				
					$this->CI->session->set_flashdata('success', $extra['success_message']);	
				}
			}
			else
			{
				if ( ! $result_id = $this->CI->row_m->update_entry(
													$stream_fields,
													$stream,
													$row->id,
													$this->CI->input->post(),
													$skips
												))
				{
					$this->CI->session->set_flashdata('notice', $extra['failure_message']);	
				}
				else
				{
					// -------------------------------------
					// Send Emails
					// -------------------------------------
					
					if ($plugin AND (isset($extra['email_notifications']) AND is_array($extra['email_notifications'])))
					{
						foreach($data->email_notifications as $notify)
						{
							$this->_send_email($notify, $result_id, $method = 'update', $stream);
						}
					}
	
					// -------------------------------------
				
					$this->CI->session->set_flashdata('success', $extra['success_message']);	
				}
			}
			
			// Redirect and replace -id- with the result ID
			redirect(str_replace('-id-', $result_id, $extra['return']));
		}
		
		// -------------------------------------
		// Set Fields & Return Them
		// -------------------------------------

		return $this->build_fields($stream_fields, $values, $row, $method, $skips, $extra['required']);
	}

	// --------------------------------------------------------------------------

	/**
	 * Run Field Events
	 *
	 * Runs all the event() functions for some
	 * stream fields. The event() functions usually
	 * have field asset loads.
	 *
	 * @access 	public
	 * @param 	obj - stream fields
	 * @param 	array - skips
	 * @return 	array
	 */
	public function run_field_events($stream_fields, $skips)
	{
		$events_called = array();
		
		foreach ($stream_fields as $field)
		{
			if ( ! in_array($field->field_slug, $skips))
			{
				// If we haven't called it (for dupes),
				// then call it already.
				if ( ! in_array($field->field_type, $events_called))
				{
					if(method_exists($this->CI->type->types->{$field->field_type}, 'event'))
					{
						$this->CI->type->types->{$field->field_type}->event($field);
					}
					
					$events_called[] = $field->field_type;
				}		
			}
		}

		return $events_called;
	}

	// --------------------------------------------------------------------------

	/**
	 * Gather values into an array
	 * for a form
	 *
	 * @access 	public
	 * @param 	object - stream_fields
	 * @param 	object - row
	 * @param 	string - edit or new
	 * @param 	array
	 * @return 	array
	 */
	public function set_values($stream_fields, $row, $mode, $skips)
	{
		$values = array();
		
		foreach ($stream_fields as $stream_field)
		{
			if ( ! in_array($stream_field->field_slug, $skips))
			{
				if ($mode == "new")
				{
					$values[$stream_field->field_slug] = $this->CI->input->post($stream_field->field_slug);
				}
				else
				{
					if (isset($row->{$stream_field->field_slug}))
					{
						$values[$stream_field->field_slug] = $row->{$stream_field->field_slug};
					}
					else
					{
						$values[$stream_field->field_slug] = null;
					}
				}
			}
		}

		return $values;		
	}

	// --------------------------------------------------------------------------

	/**
	 * Build Fields
	 *
	 * Builds fields (no validation)
	 *
	 */
	public function build_fields($stream_fields, $values = array(), $row = null, $method = 'new', $skips = array(), $required = '<span>*</span>')
	{
		$fields = array();

		$count = 0;

		foreach($stream_fields as $slug => $field)
		{
			if ( ! in_array($field->field_slug, $skips))
			{
				$fields[$count]['input_title'] 		= $field->field_name;
				$fields[$count]['input_slug'] 		= $field->field_slug;
				$fields[$count]['instructions'] 	= $field->instructions;

				// The default default value is null.
				if ( ! isset($field->field_data['default_value']))
				{
					$field->field_data['default_value'] = null;
				}
						
				// Set the value. The passed value or
				// the default value?
				$value = (isset($values[$field->field_slug])) ? $values[$field->field_slug] : $field->field_data['default_value'];

				// Return the raw value as well - can be useful
				$fields[$count]['value'] 			= $value;

				// Get the acutal form input
				if ($method == 'edit')
				{
					$fields[$count]['input'] 		= $this->build_form_input($field, $value, $row->id);
					$fields[$count]['input_parts'] 	= $this->build_form_input($field, $value, $row->id, true);
				}
				else
				{
					$fields[$count]['input'] 		= $this->build_form_input($field, $value, null);			
					$fields[$count]['input_parts'] 	= $this->build_form_input($field, $value, null, true);
				}

				// Set the error if there is one
				$fields[$count]['error_raw']		= $this->CI->form_validation->error($field->field_slug);

				// Format tht error
				if ($fields[$count]['error_raw']) 
				{
					$fields[$count]['error']		= $this->CI->form_validation->format_error($fields[$count]['error_raw']);
				}
				else
				{
					$fields[$count]['error']		= null;
				}

				// Set the required string
				$fields[$count]['required'] = ($field->is_required == 'yes') ? $required : null;

				// Set even/odd
				$fields[$count]['odd_even'] = (($count+1)%2 == 0) ? 'even' : 'odd';

				$count++;
			}
		}
		
		return $fields;
	}

	// --------------------------------------------------------------------------

	/**
	 * Set Rules
	 *
	 * Set the rules from the stream fields
	 *
	 * @access 	public
	 * @param 	obj - fields to set rules for
	 * @param 	string - method - edit or new
	 * @param 	array - fields to skip
	 * @param 	bool - return the array or set the validation
	 * @param 	mixed - array or true
	 */	
	public function set_rules($stream_fields, $method, $skips = array(), $return_array = false)
	{
		$validation_rules = array();

		// -------------------------------------
		// Loop through and set the rules
		// -------------------------------------

		foreach ($stream_fields  as $stream_field)
		{
			if ( ! in_array($stream_field->field_slug, $skips))
			{
				$rules = array();

				$type = $this->CI->type->types->{$stream_field->field_type};

				// -------------------------------------
				// Pre Validation Event
				// -------------------------------------

				if (method_exists($type, 'pre_validation_compile'))
				{
					$type->pre_validation_compile($stream_field);
				}

				// -------------------------------------
				// Set required if necessary
				// -------------------------------------
							
				if ($stream_field->is_required == 'yes')
				{
					if (isset($type->input_is_file) && $type->input_is_file === TRUE)
					{
						$rules[] = 'streams_file_required['.$stream_field->field_slug.']';
					}
					else
					{
						$rules[] = 'required';
					}
				}

				// -------------------------------------
				// Validation Function
				// -------------------------------------
				// We are using a generic streams validation
				// function to use a validate() function
				// in the field type itself.
				// -------------------------------------

				if (method_exists($type, 'validate'))
				{
					$rules[] = "streams_field_validation[{$stream_field->field_id}:{$method}]";
				}

				// -------------------------------------
				// Set unique if necessary
				// -------------------------------------
	
				if ($stream_field->is_unique == 'yes')
				{
					$rules[] = 'streams_unique['.$stream_field->field_slug.':'.$method.':'.$stream_field->stream_id.']';
				}

				// -------------------------------------
				// Set extra validation
				// -------------------------------------
				
				if (isset($type->extra_validation))
				{
					if (is_string($type->extra_validation))
					{
						$extra_rules = explode('|', $type->extra_validation);
						$rules = array_merge($rules, $extra_rules);
						unset($extra_rules);
					}
					elseif (is_array($type->extra_validation))
					{
						$rules = array_merge($rules, $type->extra_validation);
					}
				}

				// -------------------------------------
				// Remove duplicate rule values
				// -------------------------------------
	
				$rules = array_unique($rules);

				// -------------------------------------
				// Add to validation rules array
				// and unset $rules
				// -------------------------------------

				$validation_rules[] = array(
					'field'	=> $stream_field->field_slug,
					'label' => $stream_field->field_name,
					'rules'	=> implode('|', $rules)				
				);

				unset($rules);
			}
		}

		// -------------------------------------
		// Set the rules or return them
		// -------------------------------------

		if ($return_array)
		{
			return $validation_rules;
		}
		else
		{
			$this->CI->form_validation->set_rules($validation_rules);
			return true;		
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Translate a label.
	 *
	 * If it has the label: before it, then we can
	 * look for a language line.
	 *
	 * This is partially from the CodeIgniter Form Validation
	 * library but it protected so we need to replicate the
	 * functionality here.
	 *
	 * @access 	public
	 * @param 	string - the field label
	 * @return 	string - translated or original label
	 */
	public function translate_label($label)
	{
		// Look for lang
		if (substr($label, 0, 5) === 'lang:')
		{
			$line = substr($label, 5);

			if (($label = $this->CI->lang->line($line)) === false)
			{
				return $line;
			}
		}

		return $label;		
	}

	// --------------------------------------------------------------------------

	/**
	 * Send Emails
	 *
	 * Sends emails for a notify group
	 *
	 * @access	private
	 * @param	string - a or b
	 * @param	int - the entry id
	 * @param	string - method - update or new
	 * @param	obj - the stream
	 * @return	void
	 */
	private function _send_email($notify, $entry_id, $method, $stream)
	{
		extract($notify);

		// We accept a null to/from, as these can be
		// created automatically.
		if ( ! isset($notify) AND ! $notify) return NULL;
		if ( ! isset($template) AND ! $template) return NULL;
			
		// -------------------------------------
		// Get e-mails. Forget if there are none
		// -------------------------------------

		$emails = explode("|", $notify);

		if (empty($emails)) return NULL;

		foreach($emails as $key => $piece)
		{
			$emails[$key] = $this->_process_email_address($piece);
		}
		
		// -------------------------------------
		// Parse Email Template
		// -------------------------------------
		// Get the email template from
		// the database and create some
		// special vars to pass off.
		// -------------------------------------

		$layout = $this->CI->db
							->limit(1)
							->where('slug', $template)
							->get('email_templates')
							->row();
							
		if ( ! $layout) return NULL;
		
		// -------------------------------------
		// Get some basic sender data
		// -------------------------------------

		$this->CI->load->library('user_agent');
		
		$data = array(
			'sender_ip'			=> $this->CI->input->ip_address(),
			'sender_os'			=> $this->CI->agent->platform(),
			'sender_agent'		=> $this->CI->agent->agent_string()
		);
		
		// -------------------------------------
		// Get the entry to pass to the template.
		// -------------------------------------

		$params = array(
				'id'			=> $entry_id,
				'stream'		=> $stream->stream_slug);
		
		$rows = $this->CI->row_m->get_rows($params, $this->CI->streams_m->get_stream_fields($stream->id), $stream);
		
		$data['entry']			= $rows['rows'];
		
		// -------------------------------------
		// Parse the body and subject
		// -------------------------------------

		$layout->body = html_entity_decode($this->CI->parser->parse_string(str_replace(array('&quot;', '&#39;'), array('"', "'"), $layout->body), $data, true));

		$layout->subject = html_entity_decode($this->CI->parser->parse_string(str_replace(array('&quot;', '&#39;'), array('"', "'"), $layout->subject), $data, true));

		// -------------------------------------
		// Set From
		// -------------------------------------
		// We accept an email address from or 
		// a name/email separated by a pipe (|).
		// -------------------------------------

		$this->CI->load->library('Email');
		
		if (isset($from) AND $from)
		{
			$email_pieces = explode("|", $from);
		
			if (count($email_pieces) == 2)
			{
				$this->CI->email->from($this->_process_email_address($email_pieces[0]), $email_pieces[1]);
			}
			else
			{
				$this->CI->email->from($email_pieces[0]);
			}
		}
		else
		{
			// Hmm. No from address. We'll just use the site setting.
			$this->CI->email->from($this->CI->settings->item('server_email'), $this->CI->settings->item('site_name'));
		}

		// -------------------------------------
		// Set Email Data
		// -------------------------------------

		$this->CI->email->to($emails); 
		$this->CI->email->subject($layout->subject);
		$this->CI->email->message($layout->body);

		// -------------------------------------
		// Send, Log & Clear
		// -------------------------------------

		$return = $this->CI->email->send();

		$this->CI->email->clear();			
	
		return $return;
	}

	// --------------------------------------------------------------------------

	/**
	 * Process an email address - if it is not 
	 * an email address, pull it from post data.
	 *
	 * @access	private
	 * @param	email
	 * @return	string
	 */
	private function _process_email_address($email)
	{	
		if (strpos($email, '@') === FALSE AND $this->CI->input->post($email))
		{
			return $this->CI->input->post($email);
		}

		return $email;
	}

}