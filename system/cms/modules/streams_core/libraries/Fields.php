<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Core Fields Library
 *
 * Handles forms and other field form logic.
 *
 * @package		PyroStreams Core
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
	public function build_form_input($field, $value = FALSE, $row_id = NULL)
	{
		$tmp = $field->field_type;
		
		$type = $this->CI->type->types->$tmp;
		
		$form_data['form_slug']		= $field->field_slug;
		
		if ( ! isset($field->field_data['default_value']))
		{
			$field->field_data['default_value'] = '';
		}
		
		// Set the value
		$value ? $form_data['value'] = $value : $form_data['value'] = $field->field_data['default_value'];
		
		$form_data['custom'] = $field->field_data;
		
		// Set the max_length
		if (isset($field->field_data['max_length']))
		{
			$form_data['max_length'] = $field->field_data['max_length'];
		}

		// Get form output
		return $type->form_output($form_data, $row_id, $field);
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
     * @param	bool
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
     * @return	mixed
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
		if ($stream_fields === FALSE) return FALSE;
			
		// -------------------------------------
		// Run Type Events
		// -------------------------------------

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
				
		// -------------------------------------
		// Set Validation Rules
		// -------------------------------------

		$this->set_rules($stream_fields, $method, $skips);
		
		// -------------------------------------
		// Set reCAPTCHA
		// -------------------------------------
 
		if ($recaptcha)
		{
			$this->CI->config->load('streams_core/recaptcha');
			$this->CI->load->library('streams_core/Recaptcha');
			
			$this->CI->streams_validation->set_rules('recaptcha_response_field', 'lang:recaptcha_field_name', 'required|check_captcha');
		}
		
		// -------------------------------------
		// Set Values
		// -------------------------------------

		$values = array();
		
		foreach ($stream_fields as $stream_field)
		{
			if( ! in_array($stream_field->field_slug, $skips))
			{
				if ($method == "new")
				{
					$values[$stream_field->field_slug] = $this->CI->input->post($stream_field->field_slug);
				}
				else
				{
					$node = $stream_field->field_slug;
					
					if (isset($row->$node))
					{
						$values[$stream_field->field_slug] = $row->$node;
					}
					else
					{
						$values[$stream_field->field_slug] = NULL;
					}
					
					$node = NULL;
				}
			}
		}

		// -------------------------------------
		// Validation
		// -------------------------------------
		
		$result_id = '';

		if ($this->CI->streams_validation->run() === TRUE)
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
					
					if ($plugin and $email_notifications)
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
			
			// Redirect based on if this is a plugin call or not
			if ($plugin)
			{
				redirect(str_replace('-id-', $result_id, $extra['return']));
			}
			else
			{
				redirect('admin/streams/entries/index/'.$stream->id);
			}
		}
		
		// -------------------------------------
		// Set Fields & Return Them
		// -------------------------------------

		$fields = array();

		$count = 0;

		foreach($stream_fields as $slug => $field)
		{
			if ( ! in_array($field->field_slug, $skips))
			{
				$fields[$count]['input_title'] 		= $field->field_name;
				$fields[$count]['input_slug'] 		= $field->field_slug;
				$fields[$count]['instructions'] 	= $field->instructions;

				// Get the acutal form input
				if ($method == 'edit')
				{
					$fields[$count]['input'] 		= $this->build_form_input($field, $values[$field->field_slug], $row->id);
				}
				else
				{
					$fields[$count]['input'] 		= $this->build_form_input($field, $values[$field->field_slug]);			
				}

				// Set the error if there is one
				$fields[$count]['error']			= $this->CI->streams_validation->error($field->field_slug, $extra['error_start'], $extra['error_end']);

				// Format tht error
				if ($fields[$count]['error']) 
				{
					$fields[$count]['error']		= $extra['error_start'].$fields[$count]['error'].$extra['error_end'];
				}

				// Set the required string
				$fields[$count]['required'] = ($field->is_required == 'yes') ? $extra['required'] : NULL;

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
	 */	
	public function set_rules($stream_fields, $method, $skips)
	{
		// -------------------------------------
		// Loop through and set the rules
		// -------------------------------------
	
		foreach ($stream_fields  as $stream_field)
		{
			if ( ! in_array($stream_field->field_slug, $skips))
			{
				// Get the type object
				$type_call = $stream_field->field_type;	
				$type = $this->CI->type->types->$type_call;	
			
				$rules = array(
					'field'	=> $stream_field->field_slug,
					'label' => $stream_field->field_name,
					'rules'	=> ''				
				);
				
				// -------------------------------------
				// Set required if necessary
				// -------------------------------------
							
				if ($stream_field->is_required == 'yes')
				{
					if (isset($type->input_is_file) && $type->input_is_file === TRUE)
					{
						$rules['rules'] .= '|file_required['.$stream_field->field_slug.']';
					}
					else
					{
						$rules['rules'] .= '|required';
					}
				}
				
				// -------------------------------------
				// Set unique if necessary
				// -------------------------------------
	
				if ($stream_field->is_unique == 'yes')
				{
					$rules['rules'] .= '|unique['.$stream_field->field_slug.':'.$method.':'.$stream_field->stream_id.']';
				}
				
				// -------------------------------------
				// Set extra validation
				// -------------------------------------
				
				if (isset($type->extra_validation))
				{
					$rules['rules'] .= '|'.$type->extra_validation;
				}
	
				// -------------------------------------
				// Set them rules
				// -------------------------------------
	
				$this->CI->streams_validation->set_rules($rules['field'], $rules['label'], $rules['rules']);
				
				// Reset this baby!
				$rules = array();
			}
		}
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