<?php namespace Pyro\Module\Streams_core\Core\Field;

use Pyro\Module\Streams_core\Core\Field\Type;
use Pyro\Module\Streams_core\Core\Model;

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
	/**
	 * The events that have run
	 * @var array
	 */
	public $field_type_events_run = array();

	/**
	 * The entry object
	 * @var object
	 */
	protected $entry;

	/**
	 * New or edit
	 * @var string
	 */
	protected $method = 'new';

	/**
	 * Defaults
	 * @var array
	 */
	protected $defaults = array();

	/**
	 * Recaptcha or not
	 * @var boolean
	 */
	protected $recaptcha = false;

	/**
	 * The values
	 * @var array
	 */
	protected $values = array();

	/**
	 * The form key
	 * @var string
	 */
	protected $form_key = null;

	/**
	 * Fields in the form
	 * @var array
	 */
	protected $fields = null;

	/**
	 * Key check
	 * @var boolean
	 */
	protected $key_check = null;

	/**
	 * The stream object
	 * @var object
	 */
	protected $stream = null;

	/**
	 * Skip processing
	 * @var array
	 */
	protected $skips = array();

	/**
	 * Success message
	 * @var string
	 */
	protected $success_message = null;

	/**
	 * Return validation rules
	 * @var boolean
	 */
	protected $return_validation_rules = false;

	/**
	 * Fields types available
	 * @var array
	 */
	protected $field_types = array();

	/**
	 * The result
	 * @var boolean
	 */
	protected $result = false;

	/**
	 * Return
	 * @var string
	 */
	protected $return = null;

	/**
	 * Enable post
	 * @var boolean
	 */
	protected $enable_post = true;

	/**
	 * Construct with the entry object optional
	 * @param object $entry
	 */
	public function __construct($entry = null)
    {
    	if ($entry)
    	{
			$this->entry = $entry;

			$this->stream = $entry->getStream();

			$this->fields = $entry->getFields();

			$this->method = $entry->getKey() ? 'edit' : 'new';    		
    	}

		ci()->load->helper('form');
	}

	/**
	 * Set fields
	 * @param array $fields
	 */
	public function setFields($fields = null)
	{
		$this->fields = $fields;

		return $this;
	}

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

		//$this->form_key = (isset($extra['form_key'])) ? $extra['form_key'] : null;

		// Form key check. If no data, we must assume it is true.
		if ($this->form_key and ci()->input->post('_streams_form_key'))
		{
			$this->key_check = ($this->form_key == ci()->input->post('_streams_form_key'));
		}
		else
		{
			$this->key_check = true;
		}

 		// -------------------------------------
		// Get Stream Fields
		// -------------------------------------
		
		//$stream_fields = ci()->streams_m->get_stream_fields($stream->id);
		
		// Can't do nothing if we don't have any fields		
		if ($this->fields->isEmpty())
		{
			return null;
		}

		// -------------------------------------
		// Set Validation Rules
		// -------------------------------------
		// We will only set the rules if the
		// data has been posted. This works hand
		// in hand with checking the $_POST array
		// as well as the data validation when
		// we decide what to do with the form.
		// -------------------------------------

		if ($_POST and $this->key_check)
		{
			ci()->form_validation->reset_validation();
			// $stream_fields, $this->method, $skips, false, $this->entry->id
			$this->setRules();
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
			
			ci()->form_validation->setRules('recaptcha_response_field', 'lang:recaptcha_field_name', 'required|check_recaptcha');
		}
		
		// -------------------------------------
		// Set Values
		// -------------------------------------

		//$stream_fields, $row, $this->method, $skips, $defaults, $this->key_check

		$this->setValues();

		// -------------------------------------
		// Run Type Events
		// -------------------------------------
		// No matter what, we'll need these 
		// events run for field type assets
		// and other processes.
		// -------------------------------------

		// $stream_fields, $skips, $values

		$fields = $this->buildFields();

		// -------------------------------------
		// Validation
		// -------------------------------------
		
		$result_id = '';

		if ($_POST and $this->enable_post)
		{
			// @todo - restore validation here
			// ci()->form_validation->run() === true
			if (true)
			{
				if ( ! $this->entry->getKey()) // new
				{
					// ci()->row_m->insert_entry($_POST, $stream_fields, $stream, $skips);
					if ( ! $this->entry->save())
					{
						ci()->session->set_flashdata('notice', lang_label($this->failure_message));
					}
					else
					{
						$this->result = $this->entry;

						// -------------------------------------
						// Send Emails
						// -------------------------------------
						
						if (isset($extra['email_notifications']) and $extra['email_notifications'])
						{
							foreach ($extra['email_notifications'] as $notify)
							{
								$this->sendEmail($notify, $result_id, $this->method = 'new', $stream);
							}
						}
		
						// -------------------------------------
					
						ci()->session->set_flashdata('success', lang_label($this->success_message));
					}
				}
				else // edit
				{
					$this->entry->exists = true;

					if ( ! $this->entry->save() and isset($this->failure_message))
					{
						ci()->session->set_flashdata('notice', lang_label($this->failure_message));	
					}
					else
					{
						$this->result = $this->entry;

						// -------------------------------------
						// Send Emails
						// -------------------------------------
						
						if (isset($extra['email_notifications']) and is_array($extra['email_notifications']))
						{
							foreach($extra['email_notifications'] as $notify)
							{
								$this->sendEmail($notify, $result_id, $this->method = 'update', $stream);
							}
						}
		
						// -------------------------------------
					
						ci()->session->set_flashdata('success', lang_label($this->success_message));
					}
				}
			}
		}

		// -------------------------------------
		// Set Fields & Return Them
		// -------------------------------------

		// $stream_fields, $values, $row, $this->method, $skips, $extra['required']
		return $fields;
	}

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
	public function runFieldEvents()
	{
		if ( ! $this->fields or ( ! is_array($this->fields) and ! is_object($this->fields))) return null;

		foreach ($this->fields as $field)
		{
			// We need the slug to go on.
			if ( ! $type = $field->getType())
			{
				continue;
			}

			// Set the value
			if ( isset($this->entry->{$field->field_slug}) ) $field->value = $this->entry->{$field->field_slug};

			if ( ! in_array($field->field_slug, $this->skips))
			{
				// If we haven't called it (for dupes),
				// then call it already.
				if ( ! in_array($field->field_type, $this->field_type_events_run))
				{
					if (method_exists($type, 'event'))
					{
						$type->event();
					}
					
					$this->field_type_events_run[] = $field->field_type;
				}		
			}
		}
	}

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
	// $stream_fields, $row, $mode, $skips = array(), $defaults = array(), $this->key_check = true
	public function setValues()
	{
		foreach ($this->fields as $field)
		{
			if ( ! in_array($field->field_slug, $this->skips))
			{
				if ($this->key_check and $type = $field->getType($this->entry))
				{
					// Post Data - we always show
					// post data above any other data that
					// might be sitting around.

					// There is the possibility that this could be an array
					// post value, so we check for that as well.
					if (isset($_POST[$type->getFormSlug()]))
					{
						$this->values[$field->field_slug] = $this->entry->{$field->field_slug} = ci()->input->post($type->getFormSlug());
					}
					elseif (isset($_POST[$type->getFormSlug().'[]']))
					{
						$this->values[$field->field_slug] = $this->entry->{$field->field_slug} = ci()->input->post($type->getFormSlug().'[]');
					}
					else
					{
						$this->values[$field->field_slug] = $this->entry->{$field->field_slug};
					}
				}
			}
		}
	}

	/**
	 * Get field types available
	 * @return array
	 */
	public function getFieldTypes()
	{
		if (empty($this->field_types))
		{
			foreach ($this->fields as $field)
			{
				if ($type = $this->entry->getFieldType($field->field_slug))
				{
					$this->field_types[$field->field_slug] = $type;	
				}
			}			
		}

		return $this->field_types;
	}

	/**
	 * Build Fields
	 *
	 * Builds fields (no validation)
	 *
	 */
	// $stream_fields, $values = array(), $row = null, $this->method = 'new', $skips = array(), $required = '<span>*</span>'
	public function buildFields()
	{
		$fields = array();
		
		// $stream_fields, $skips, $values
		$this->runFieldEvents();

		foreach($this->fields as $key => $field)
		{
			if ($type = $this->entry->getFieldType($field->field_slug))
			{	
				$type->setUnformattedValue($this->entry->getUnformattedValue($field->field_slug));
				$type->setDefaults($this->defaults);
				$type->setFormData($this->values);

				$type->setStream($this->entry->getStream());

				$fields[$field->field_slug]['input_title'] 	= $field->field_name;
				$fields[$field->field_slug]['input_slug']		= $type->getFormSlug();
				$fields[$field->field_slug]['instructions'] 	= $field->instructions;
				
				// Set the value. In the odd case it isn't set,
				// jst set it to null.

				// Return the raw value as well - can be useful
				$fields[$field->field_slug]['value']			= $this->entry->getUnformattedValue($field->field_slug);

				// Get the acutal form input
				$fields[$field->field_slug]['input'] 			= $type->getForm();	
				$fields[$field->field_slug]['input_parts'] 		= $type->setPlugin(true)->getForm();

				// Set the error if there is one
				$fields[$field->field_slug]['error_raw']		= ci()->form_validation->error($field->field_slug);

				// Format tht error
				if ($fields[$field->field_slug]['error_raw']) 
				{
					$fields[$field->field_slug]['error']		= $fields[$field->field_slug]['error_raw'];
				}
				else
				{
					$fields[$field->field_slug]['error']		= null;
				}

				// Set the required string
				$fields[$field->field_slug]['required']		= ($field->is_required == 'yes') ? $required : null;

				// Set even/odd
				$fields[$field->field_slug]['odd_even']		= (($field->field_slug+1)%2 == 0) ? 'even' : 'odd';
			}
		}

		return $fields;
	}

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
	public function setRules()
	{

		if ($this->fields->isEmpty()) return array();

		$validation_rules = array();

		// -------------------------------------
		// Loop through and set the rules
		// -------------------------------------

		foreach ($this->fields as $field)
		{
			if ( ! in_array($field->field_slug, $this->skips))
			{
				$rules = array();

				// If we don't have the type, then no need to go on.
				if ( ! $type = $field->getType())
				{
					continue;
				}

				// -------------------------------------
				// Pre Validation Event
				// -------------------------------------

				if (method_exists($type, 'pre_validation_compile'))
				{
					$type->pre_validation_compile($field);
				}

				// -------------------------------------
				// Set required if necessary
				// -------------------------------------
							
				if ($field->is_required == 'yes')
				{
					if (isset($type->input_is_file) && $type->input_is_file === true)
					{
						$rules[] = 'streams_file_required['.$field->field_slug.']';
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
					$rules[] = "streams_field_validation[{$field->getKey()}:{$this->method}]";
				}

				// -------------------------------------
				// Set unique if necessary
				// -------------------------------------
	
				if ($field->is_unique == 'yes')
				{
					$rules[] = 'streams_unique['.$field->field_slug.':'.$this->method.':'.$field->stream_id.':'.$row_id.']';
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
					'field'	=> $field->field_slug,
					'label' => lang_label($field->field_name),
					'rules'	=> implode('|', $rules)				
				);

				unset($rules);
			}
		}

		// -------------------------------------
		// Set the rules or return them
		// -------------------------------------

		if ($this->return_validation_rules)
		{
			return $validation_rules;
		}
		else
		{
			//ci()->form_validation->set_rules($validation_rules);
			return true;		
		}
	}

	/**
	 * Set defaults
	 * @param string $defaults 
	 */
	public function setDefaults($defaults = null)
	{
		$this->defaults = $defaults;

		return $this;
	}

	/**
	 * Redirect
	 * @param  string $return
	 * @return object
	 */
	public function redirect($return = null)
	{
		$this->return = $return;

		return $this;
	}

	/**
	 * Success messages
	 * @param  string $success_message
	 * @return object                  
	 */
	public function successMessage($success_message = null)
	{
		$this->success_message = $success_message;

		return $this;
	}

	/**
	 * Enable post
	 * @param  boolean $enable_post 
	 * @return object
	 */
	public function enablePost($enable_post = false)
	{
		$this->enable_post = $enable_post;

		return $this;
	}

	/**
	 * The result
	 * @return mixed
	 */
	public function result()
	{
		return $this->result;
	}

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
	public static function runFieldSetupEvents($current_field = null)
	{
		$types = Type::getLoader()->getAllTypes();

		foreach ($types as $type)
		{
			if (method_exists($type, 'field_setup_event'))
			{
				$type->field_setup_event($current_field);
			}
		}
	}

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
	public function sendEmail()
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
			$emails[$key] = $this->processEmailAddress($piece);
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
				$email_address 	= $this->processEmailAddress($email_pieces[0]);
				$name 			= (ci()->input->post($email_pieces[1])) ? 
										ci()->input->post($email_pieces[1]) : $email_pieces[1];

				ci()->email->from($email_address, $name);
			}
			else {
				ci()->email->from($this->processEmailAddress($email_pieces[0]));
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

	/**
	 * Process an email address - if it is not 
	 * an email address, pull it from post data.
	 *
	 * @access	private
	 * @param	email
	 * @return	string
	 */
	private function processEmailAddress($email)
	{	
		if (strpos($email, '@') === false and ci()->input->post($email))
		{
			return ci()->input->post($email);
		}

		return $email;
	}
}
