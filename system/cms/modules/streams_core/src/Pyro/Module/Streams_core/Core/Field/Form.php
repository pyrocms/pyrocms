<?php namespace Pyro\Module\Streams_core\Core\Field;

use Pyro\Module\Streams_core\Core\Field\Type;

// This will be similar to the Fields driver

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
class Form
{
	public $field_type_events_run = array();

	protected $entry;

	protected $method = 'new';

	protected $recaptcha = false;

	protected $values = array();

	protected $key_check = false;

	protected $skips = array();

	// --------------------------------------------------------------------------

    public function __construct($entry = null)
    {
    	$this->entry = $entry;

    	$this->fields = $entry->getStream()->getModel()->getRelation('assignments')->getFields();

    	$this->method = $entry->exists ? 'edit' : 'new';
    
		ci()->load->helper('form');
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
     * @param	array - default values: Only used during new method.
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
    // $stream, $this->method, $row = false, $plugin = false, $this->recaptcha = false, $skips = array(), $extra = array(), $defaults = array()
 	public function buildForm()
 	{
 		ci()->load->helper(array('form', 'url'));

 		// -------------------------------------
		// Set default extras
		// -------------------------------------
		
		$default_extras = array(
			'email_notifications'		=> null,
			'return'					=> current_url(),
			'error_start'				=> null,
			'error_end'					=> null,
			'required'					=> '<span>*</span>',
			'success_message'			=> 'lang:streams:'.$this->method.'_entry_success',
			'failure_message'			=> 'lang:streams:'.$this->method.'_entry_error'
		);

		ci()->load->language('streams_core/pyrostreams');
		
		// Go through our defaults and see if anything has been
		// passed in the $extra array to replace any values.		
		foreach ($default_extras as $key => $value)
		{
			// Note that we don't check to see if the variable has
			// a non-null value, since the $extra variables can
			// be set to null. 
			if ( ! isset($extra[$key])) $extra[$key] = $value;
		}

		// -------------------------------------
		// Form Key Check
		// -------------------------------------
		// Form keys help determine which
		// in a series of multiple forms on the same
		// page the fields library will handle.
		// -------------------------------------

		$form_key = (isset($extra['form_key'])) ? $extra['form_key'] : null;

		// Form key check. If no data, we must assume it is true.
		if ($form_key and ci()->input->post('_streams_form_key'))
		{
			$key_check = ($form_key == ci()->input->post('_streams_form_key'));
		}
		else
		{
			$key_check = true;
		}

 		// -------------------------------------
		// Get Stream Fields
		// -------------------------------------
		
		//$stream_fields = ci()->streams_m->get_stream_fields($stream->id);
		
		// Can't do nothing if we don't have any fields		
		if (empty($this->fields))
		{
			return null;
		}
		
		// -------------------------------------
		// Get row id, if applicable
		// -------------------------------------

		$row_id = ($this->method == 'edit') ? $entry->id : null;
			
		// -------------------------------------
		// Set Validation Rules
		// -------------------------------------
		// We will only set the rules if the
		// data has been posted. This works hand
		// in hand with checking the $_POST array
		// as well as the data validation when
		// we decide what to do with the form.
		// -------------------------------------

		if ($_POST and $key_check)
		{
			ci()->form_validation->reset_validation();
			$this->set_rules($stream_fields, $this->method, $skips, false, $row_id);
		}

		// -------------------------------------
		// Set Error Delimns
		// -------------------------------------

		ci()->form_validation->set_error_delimiters($extra['error_start'], $extra['error_end']);

		// -------------------------------------
		// Set reCAPTCHA
		// -------------------------------------
 
		if ($this->recaptcha and $_POST)
		{
			ci()->config->load('streams_core/recaptcha');
			ci()->load->library('streams_core/Recaptcha');
			
			ci()->form_validation->set_rules('recaptcha_response_field', 'lang:recaptcha_field_name', 'required|check_recaptcha');
		}
		
		// -------------------------------------
		// Set Values
		// -------------------------------------

		//$stream_fields, $row, $this->method, $skips, $defaults, $key_check

		$this->values = $this->set_values();

		// -------------------------------------
		// Run Type Events
		// -------------------------------------
		// No matter what, we'll need these 
		// events run for field type assets
		// and other processes.
		// -------------------------------------

		// $stream_fields, $skips, $values

		$this->run_field_events();

		// -------------------------------------
		// Validation
		// -------------------------------------
		
		$result_id = '';

		if ($_POST and $key_check)
		{
			if (ci()->form_validation->run() === true)
			{
				if ($this->method == 'new')
				{
					if ( ! $result_id = ci()->row_m->insert_entry($_POST, $stream_fields, $stream, $skips))
					{
						ci()->session->set_flashdata('notice', ci()->fields->translate_label($failure_message));
					}
					else
					{
						// -------------------------------------
						// Send Emails
						// -------------------------------------
						
						if (isset($extra['email_notifications']) and $extra['email_notifications'])
						{
							foreach ($extra['email_notifications'] as $notify)
							{
								$this->send_email($notify, $result_id, $this->method = 'new', $stream);
							}
						}
		
						// -------------------------------------
					
						ci()->session->set_flashdata('success', ci()->fields->translate_label($extra['success_message']));
					}
				}
				else
				{
					if ( ! $result_id = ci()->row_m->update_entry(
														$stream_fields,
														$stream,
														$row->id,
														ci()->input->post(),
														$skips
													))
					{
						ci()->session->set_flashdata('notice', ci()->fields->translate_label($extra['failure_message']));	
					}
					else
					{
						// -------------------------------------
						// Send Emails
						// -------------------------------------
						
						if (isset($extra['email_notifications']) and is_array($extra['email_notifications']))
						{
							foreach($extra['email_notifications'] as $notify)
							{
								$this->send_email($notify, $result_id, $this->method = 'update', $stream);
							}
						}
		
						// -------------------------------------
					
						ci()->session->set_flashdata('success', ci()->fields->translate_label($extra['success_message']));
					}
				}
			
				// If return url is set, redirect and replace -id- with the result ID
				// Otherwise return id
				if ($extra['return'] or $plugin === true)
				{
					redirect(str_replace('-id-', $result_id, $extra['return']));
				}
				else
				{
					return $result_id;
				}
			}
		}

		// -------------------------------------
		// Set Fields & Return Them
		// -------------------------------------

		// $stream_fields, $values, $row, $this->method, $skips, $extra['required']
		return $this->build_fields();
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
	 * @param 	[array - skips]
	 * @return 	array
	 */
	// $stream_fields, $skips = array(), $values = array()
	public function run_field_events()
	{
		if ( ! $this->fields or ( ! is_array($this->fields) and ! is_object($this->fields))) return null;

		foreach ($this->fields as $field)
		{
			// We need the slug to go on.
			if ( ! isset(ci()->type->types->{$field->field_type}))
			{
				continue;
			}

			// Set the value
			if ( isset($this->values[$field->field_slug]) ) $field->value = $this->values[$field->field_slug];

			if ( ! in_array($field->field_slug, $this->skips))
			{
				// If we haven't called it (for dupes),
				// then call it already.
				if ( ! in_array($field->field_type, $this->field_type_events_run))
				{
					if (method_exists(ci()->type->types->{$field->field_type}, 'event'))
					{
						ci()->type->types->{$field->field_type}->event($field);
					}
					
					$this->field_type_events_run[] = $field->field_type;
				}		
			}
		}
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
	 * @param 	array
	 * @return 	array
	 */
	// $stream_fields, $row, $mode, $skips = array(), $defaults = array(), $key_check = true
	public function set_values()
	{
		$values = array();

		// If we don't have any stream fields, 
		// we don't have anything to do.
		if ( empty($this->fields)) {
			return $values;
		}

		foreach ($this->fields as $field)
		{
			if ( ! in_array($field->field_slug, $this->skips))
			{
				if ( ! $this->key_check)
				{
					$values[$field->field_slug] = null;
				}
				elseif ( ! isset($_POST[$field->field_slug]) and ! isset($_POST[$field->field_slug.'[]']))
				{
					// If this is a new entry and there is no post data,
					// we see if:
					// a - there is data from the DB to show
					// b - 1. there is a defaults value sent to the form ($defaults)
					// b - 2. there is a default value to show from the assignment
					// Otherwise, it's just null
					if (isset($row->{$field->field_slug}))
					{
						$values[$field->field_slug] = $row->{$field->field_slug};
					}
					elseif ($mode == 'new')
					{
						$values[$field->field_slug] = (isset($defaults[$field->field_slug]) ? $defaults[$field->field_slug] : (isset($field->field_data['default_value']) ? $field->field_data['default_value'] : null));
					}
					elseif ($mode == 'edit')
					{
						// If there is no post data and no existing data and this is 
						// an edit page, then we don't want to show the default.
						// Edit pages should *always* reflect the current data,
						// and nothing more.
						$values[$field->field_slug] = null;
					}
				}
				else
				{
					// Post Data - we always show
					// post data above any other data that
					// might be sitting around.

					// There is the possibility that this could be an array
					// post value, so we check for that as well.
					if (isset($_POST[$field->field_slug]))
					{
						$values[$field->field_slug] = ci()->input->post($field->field_slug);
					}
					elseif (isset($_POST[$field->field_slug.'[]']))
					{
						$values[$field->field_slug] = ci()->input->post($field->field_slug.'[]');
					}
					else
					{
						// Last ditch.
						$values[$field->field_slug] = null;
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
	// $stream_fields, $values = array(), $row = null, $this->method = 'new', $skips = array(), $required = '<span>*</span>'
	public function build_fields()
	{
		$fields = array();

		$count = 0;
		
		// $stream_fields, $skips, $values
		$this->run_field_events();

		foreach($this->fields as $field)
		{
			if ( ! in_array($field->field_slug, $this->skips))
			{
				$fields[$count]['input_title'] 		= $field->field_name;
				$fields[$count]['input_slug'] 		= $field->field_slug;
				$fields[$count]['instructions'] 	= $field->instructions;
				
				// Set the value. In the odd case it isn't set,
				// jst set it to null.
				$value = (isset($this->values[$field->field_slug])) ? $this->values[$field->field_slug] : null;

				// Return the raw value as well - can be useful
				$fields[$count]['value'] 			= $value;

				$type = $this->entry->getFieldType($field->field_slug);

				// Get the acutal form input
				$fields[$count]['input'] 		= $type->getForm();	
				$fields[$count]['input_parts'] 	= $type->setPlugin(true)->getForm();
				
				/*if ($this->method == 'edit')
				{
					$fields[$count]['input'] 		= $type->getForm();
					$fields[$count]['input_parts'] 	= $type->setIsPlugin(false)->getForm();
				}
				else
				{
					$fields[$count]['input'] 		= $type->build_form_input($field, $value, null);			
					$fields[$count]['input_parts'] 	= $type->build_form_input($field, $value, null, true);
				}*/

				// Set the error if there is one
				$fields[$count]['error_raw']		= ci()->form_validation->error($field->field_slug);

				// Format tht error
				if ($fields[$count]['error_raw']) 
				{
					$fields[$count]['error']		= $fields[$count]['error_raw'];
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
	// $stream_fields, $method, $skips = array(), $return_array = false, $row_id = null
	public function set_rules()
	{
		if ( ! $stream_fields or ! is_object($stream_fields)) return array();

		$validation_rules = array();

		// -------------------------------------
		// Loop through and set the rules
		// -------------------------------------

		foreach ($stream_fields  as $stream_field)
		{
			if ( ! in_array($stream_field->field_slug, $skips))
			{
				$rules = array();

				// If we don't have the type, then no need to go on.
				if ( ! isset(ci()->type->types->{$stream_field->field_type}))
				{
					continue;
				}

				$type = ci()->type->types->{$stream_field->field_type};

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
					if (isset($type->input_is_file) && $type->input_is_file === true)
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
					$rules[] = "streams_field_validation[{$stream_field->field_id}:{$this->method}]";
				}

				// -------------------------------------
				// Set unique if necessary
				// -------------------------------------
	
				if ($stream_field->is_unique == 'yes')
				{
					$rules[] = 'streams_unique['.$stream_field->field_slug.':'.$this->method.':'.$stream_field->stream_id.':'.$row_id.']';
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
					'label' => lang_label($stream_field->field_name),
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
			ci()->form_validation->set_rules($validation_rules);
			return true;		
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Run Field Setup Event Functions
	 *
	 * This allows field types to add custom CSS/JS
	 * to the field setup (edit/delete screen).
	 *
	 * @access 	public
	 * @param 	[obj - stream]
	 * @param 	[string - method - new or edit]
	 * @param 	[obj or null (for new fields) - field]
	 * @return 	
	 */
	// $stream = null, $this->method = 'new', $field = null
	public function run_field_setup_events()
	{
		foreach (ci()->type->types as $ft)
		{
			if (method_exists($ft, 'field_setup_event'))
			{
				$ft->field_setup_event($stream, $this->method, $field);
			}
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

			if (($label = ci()->lang->line($line)) === false)
			{
				return $line;
			}
		}

		return $label;		
	}

	// --------------------------------------------------------------------------

	/**
	 * Send Email
	 *
	 * Sends emails for a single notify group.
	 *
	 * @access	public
	 * @param	string 	$notify 	a or b
	 * @param	int 	$entry_id 	the entry id
	 * @param	string 	$this->method 	edit or new
	 * @param	obj 	$stream 	the stream
	 * @return	void
	 */
	// $notify, $entry_id, $this->method, $stream
	public function send_email()
	{
		extract($notify);

		// We need a notify to and a template, or 
		// else we can't do anything. Everything else
		// can be substituted with a default value.
		if ( ! isset($notify) and ! $notify) return null;
		if ( ! isset($template) and ! $template) return null;
			
		// -------------------------------------
		// Get e-mails. Forget if there are none
		// -------------------------------------

		$emails = explode('|', $notify);

		if (empty($emails)) return null;

		// For each email, we can have an email value, or
		// we take it from the form's post values.
		foreach ($emails as $key => $piece)
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

		$layout = ci()->db
							->limit(1)
							->where('slug', $template)
							->get('email_templates')
							->row();
							
		if ( ! $layout) return null;
		
		// -------------------------------------
		// Get some basic sender data
		// -------------------------------------
		// These are for use in the email template.
		// -------------------------------------

		ci()->load->library('user_agent');
		
		$data = array(
			'sender_ip'			=> ci()->input->ip_address(),
			'sender_os'			=> ci()->agent->platform(),
			'sender_agent'		=> ci()->agent->agent_string()
		);
		
		// -------------------------------------
		// Get the entry to pass to the template.
		// -------------------------------------

		$params = array(
				'id'			=> $entry_id,
				'stream'		=> $stream->stream_slug);
		
		$rows = ci()->row_m->get_rows($params, ci()->streams_m->get_stream_fields($stream->id), $stream);
		
		$data['entry']			= $rows['rows'];
		
		// -------------------------------------
		// Parse the body and subject
		// -------------------------------------

		$layout->body = html_entity_decode(ci()->parser->parse_string(str_replace(array('&quot;', '&#39;'), array('"', "'"), $layout->body), $data, true));

		$layout->subject = html_entity_decode(ci()->parser->parse_string(str_replace(array('&quot;', '&#39;'), array('"', "'"), $layout->subject), $data, true));

		// -------------------------------------
		// Set From
		// -------------------------------------
		// We accept an email address from or 
		// a name/email separated by a pipe (|).
		// -------------------------------------

		ci()->load->library('Email');
		
		if (isset($from) and $from)
		{
			$email_pieces = explode('|', $from);

			// For two segments we process it as email_address|name
			if (count($email_pieces) == 2) {
				$email_address 	= $this->_process_email_address($email_pieces[0]);
				$name 			= (ci()->input->post($email_pieces[1])) ? 
										ci()->input->post($email_pieces[1]) : $email_pieces[1];

				ci()->email->from($email_address, $name);
			}
			else {
				ci()->email->from($this->_process_email_address($email_pieces[0]));
			}
		}
		else
		{
			// Hmm. No from address. We'll just use the site setting.
			ci()->email->from(Settings::get('server_email'), Settings::get('site_name'));
		}

		// -------------------------------------
		// Set Email Data
		// -------------------------------------

		ci()->email->to($emails); 
		ci()->email->subject($layout->subject);
		ci()->email->message($layout->body);

		// -------------------------------------
		// Send, Log & Clear
		// -------------------------------------

		$return = ci()->email->send();

		ci()->email->clear();			
	
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
		if (strpos($email, '@') === false and ci()->input->post($email))
		{
			return ci()->input->post($email);
		}

		return $email;
	}

}