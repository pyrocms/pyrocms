<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Contact Plugin
 *
 * Build and send contact forms
 * 
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Contact\Plugins
 */
class Plugin_Contact extends Plugin 
{

	public $version = '1.0.0';
	public $name = array(
		'en' => 'Contact',
	);
	public $description = array(
		'en' => 'Displays a contact form for site visitors.',
	);

	/**
	 * Returns a PluginDoc array that PyroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * All options are listed here but refer 
	 * to the Blog plugin for a larger example
	 *
	 * @todo fill the  array with details about this plugin, then uncomment the return value.
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'your_method' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Displays some data from some module.'
				),
				'single' => true,// will it work as a single tag?
				'double' => false,// how about as a double tag?
				'variables' => '',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(
					'order-dir' => array(// this is the order-dir="asc" attribute
						'type' => 'flag',// Can be: slug, number, flag, text, array, any.
						'flags' => 'asc|desc|random',// flags are predefined values like this.
						'default' => 'asc',// attribute defaults to this if no value is given
						'required' => false,// is this attribute required?
					),
					'limit' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '20',
						'required' => false,
					),
				),
			),// end first method
		);
	
		//return $info;
		return array();
	}

	public function __construct()
	{
		$this->lang->load('contact');
	}

	/**
	 * Form
	 *
	 * Insert a form template
	 *
	 * Usage:
	 *
	 * {{ contact:form
	 *    name             = "text|required"
	 *    email            = "text|required|valid_email"
	 * 	  subject          = "dropdown|required|hello=Say Hello|support=Support Request|Something Else"
	 * 	  message          = "textarea|required"
	 * 	  attachment       = "file|jpg|png|zip
	 *    max-size         = "10000"
	 * 	  reply-to         = "visitor@somewhere.com" * Read note below *
	 * 	  button           = "send"
	 *    template         = "contact"
	 *    lang             = "en"
	 *    to               = "contact@site.com"
	 *    from             = "server@site.com"
	 *    sent             = "Your message has been sent. Thank you for contacting us"
	 *    error            = "Sorry. Your message could not be sent. Please call us at 123-456-7890"
	 *    auto-reply       = "contact-autoreply"
	 *    success-redirect = "home"
	 * 	  action           = "different/url" Default is current_url(). This can be used to place a contact form in
	 * 											the footer (for example) and have it send via the regular contact page. Errors will then
	 * 											be displayed on the regular contact page.
	 * 	}}
	 * 		{{ name }}
	 * 		{{ email }}
	 * 		{{ subject }}
	 * 		{{ message }}
	 * 		{{ attachment }}
	 * 	{{ /contact:form }}
	 *
	 * 	If form validation doesn't pass the error messages will be displayed next to the corresponding form element.
	 *
	 * @param	wildcard			The attribute name will be used as a form name. First value position denotes type of form. The rest denote validation rules.
	 * 								Example: email="text|required|valid_email" will create a text field named "email" that must be a valid email. In
	 * 								the case of a dropdown field the rest will denote dropdown key => values. Example: subject="dropdown|value=First Option|second-value=Second"
	 * 								Or if you prefer you can simply use the dropdown text and it will be used as the value also: subject="dropdown|First Option|Second"
	 * 								Dropdown fields will additionally accept "required" as a rule. While file fields will accept "required" plus file extensions.
	 * 								Valid form types are text, textarea, dropdown, and file.
	 * @param	max-size			If file upload fields are used the max-size attribute will limit the file size that can be uploaded.
	 * @param	reply-to			*If you have a field named "email" it will be used as a default. You should have one or the other if you plan to reply
	 * @param	button				The name of the submit button
	 * @param	template			The slug of the Email Template that you wish to use
	 * @param	lang				The language version of the Email template
	 * @param	to					Email address to send to
	 * @param	from				Server email that emails will show as the sender
	 * @param	sent				Allows you to set a different message for each contact form.
	 * @param	error				Set a unique error message for each form.
	 * @param	autoreply			Default is 0. When set to 1 autoreply is enabled and the end user will receive a confirmation email to their specified email address
	 * @param	success-redirect	Redirect the user to a different page if the message was sent successfully. 
	 * @return	string
	 */
	public function form()
	{
		$this->load->helper('form');
		
		$fieldList = $this->attributes();
		
		// If they try using the old form tag plugin give them an idea why it's failing.
		if ( ! $this->content() or count($fieldList) == 0) {
			return 'The new contact plugin requires field parameters and it must be used as a double tag.';
		}

		$button             = $this->attribute('button', 'send');
		$template           = $this->attribute('template', 'contact');
		$autoreplyTemplate 	= $this->attribute('auto-reply', false);
		$lang               = $this->attribute('lang', Settings::get('site_lang'));
		$to                 = $this->attribute('to', Settings::get('contact_email'));
		$from               = $this->attribute('from', Settings::get('server_email'));
		$replyTo           	= $this->attribute('reply-to');
		$maxSize           	= $this->attribute('max-size', 10000);
		$redirect           = $this->attribute('success-redirect', false);
		$action             = $this->attribute('action', current_url());
		$formMeta          	= array();
		$validation         = array();
		$output             = array();
		
		// Unset all attributes that are not field names
		unset(
			$fieldList['button'],
			$fieldList['template'],
			$fieldList['auto-reply'],
			$fieldList['lang'],
			$fieldList['to'],
			$fieldList['from'],
			$fieldList['reply-to'],
			$fieldList['max-size'],
			$fieldList['redirect'],
			$fieldList['action']
		);
		
		// Prepare the form meta data and validation rules
		foreach ($fieldList as $field => $rules) {
			
			$ruleArray = explode('|', $rules);
			
			// Take the simplified form names and turn them into the real deal
			switch ($ruleArray[0]) {
				
				case '':
				case 'text':
					
					$formMeta[$field]['type'] = 'input';
					break;
				
				case 'textarea':
					
					$formMeta[$field]['type'] = 'textarea';
					break;
			
				case 'dropdown':
					
					$formMeta[$field]['type'] = 'dropdown';
					
					// In this case $ruleArray holds the dropdown key=>values and possibly the "required" rule.
					$values = $ruleArray;
					
					// Get rid of the field type
					unset($values[0]);
					
					// Is a value required?
					if ($requiredKey = array_search('required', $values)) {
						
						$otherRules = 'required';
						unset($values[$requiredKey]);
					} else {
						// Just set something
						$otherRules = 'trim';
					}
					
					// We need to empty the array else we'll end up appending to the values of a previous field
					$dropdownOptions = array();
					
					// Build the array to pass to the form_dropdown() helper
					foreach ($values as $item) {
						
						$item = explode('=', $item);
						// If they didn't specify a key=>value (example: name=Your Name) then we'll use the value for the key also
						$dropdownOptions[$item[0]] = (count($item) > 1) ? $item[1] : $item[0];
					}
					
					$formMeta[$field]['dropdown'] = $dropdownOptions;
					
					break;
				
				case 'file':
					
					$formMeta[$field]['type'] = 'upload';
					
					$config = $ruleArray;
					// get rid of the field type
					unset($config[0]);
					
					// If this attachment is required add that to the rules and unset it from upload config
					if ($requiredKey = array_search('required', $config)) {
						
						if ( ! self::_requireUpload($field)) {
							// We'll set this so validation will fail and our message will be shown
							$otherRules = 'required';
						}
						unset($config[$requiredKey]);
					} else {
						$otherRules = 'trim';
					}
					
					// set configs for file uploading
					$formMeta[$field]['config']['allowed_types'] = implode('|', $config);
					$formMeta[$field]['config']['max_size'] = $maxSize;
					$formMeta[$field]['config']['upload_path'] = UPLOAD_PATH.'contact_attachments';
					
					break;	
				
				case 'hidden':
					
					$formMeta[$field]['type'] = 'hidden';
					$value = preg_split('/=/',$ruleArray[1]);
					$value = $value[1];
					$formMeta[$field]['value'] = $value;
					
					break;					
			}

			$validation[$field]['field'] = $field;
			$validation[$field]['label'] = ucfirst($field);
			$validation[$field]['rules'] = ($ruleArray[0] == 'file' or $ruleArray[0] == 'dropdown') ? $otherRules : implode('|', $ruleArray);
		}

		// We only need to run validation and input processing if the form has been submitted 
		if ($this->input->post('contact-submit')) {
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules($validation);
			
			// Process the input upon successful validation
			// Along the way we parse the e-mail template to store a complete e-mail in the db.
			// After that we trigger an email event to send out the e-mail, and optionally also an autoreply
			if ($this->form_validation->run()) {
				
				// Maybe it's a bot?
				if ($this->input->post('d0ntf1llth1s1n') !== ' ') {
					
					$this->session->set_flashdata('error', lang('contact_submit_error'));
					redirect(current_url());
				}
				
				// Load the models we'll need
				$this->load->model('contact/contact_m');
				$this->load->model('templates/email_templates_m');

				$data = $this->input->post();
	
				// Add in some extra details about the visitor
				$data['sender_agent'] = $this->agent->browser() . ' ' . $this->agent->version();
				$data['sender_ip']    = $this->input->ip_address();
				$data['sender_os']    = $this->agent->platform();
				$data['slug']         = $template;
				
				// They may have an email field in the form. If they do we'll use that for reply-to.
				$data['reply-to'] = (empty($replyTo) and isset($data['email'])) ? $data['email'] : $replyTo;
				$data['to']       = $to;
				$data['from']     = $from;
	
				// Yay they want to send attachments along
				if ($_FILES > '') {
					
					$this->load->library('upload');
					is_dir(UPLOAD_PATH.'contact_attachments') OR @mkdir(UPLOAD_PATH.'contact_attachments', 0777);
					
					foreach ($_FILES as $form => $file) {
						
						if ($file['name'] > '') {
							
							// Make sure the upload matches a field
							if ( ! array_key_exists($form, $formMeta)) {
								break;
							}
							$this->upload->initialize($formMeta[$form]['config']);
							$this->upload->do_upload($form);
							
							if ($this->upload->display_errors() > '') {
								
								$this->session->set_flashdata('error', $this->upload->display_errors());
								redirect(current_url());
							} else {
								
								$resultData = $this->upload->data();
								// pass the attachment info to the email event
								$data['attach'][$resultData['file_name']] = $resultData['full_path'];
							}
						}
					}
				}
				
				// Fetch the email template so we can parse the subject & body before we create a db entry 
				$templates = $this->email_templates_m->get_templates($template);
				
	            $subject = array_key_exists($lang, $templates) 
	            			? $templates[$lang]->subject 
							: $templates['en']->subject;
	            $subject = $this->parser->parse_string($subject, $data, true);
				
	            $body = array_key_exists($lang, $templates) 
	            			? $templates[$lang]->body 
							: $templates['en']->body;
	            $body = $this->parser->parse_string($body, $data, true);
				
				// Finally, we insert the same thing into the log as what we sent
				Contact_m::create(array(
					'email'			=> isset($data['email']) ? $data['email'] : '',
					'subject' 		=> substr($subject, 0, 255),
					'message' 		=> $body,
					'sender_agent' 	=> $data['sender_agent'],
					'sender_ip' 	=> $data['sender_ip'],
					'sender_os' 	=> $data['sender_os'],	
					'sent_at' 		=> time(),
					'attachments'	=> isset($data['attach']) ? implode('|', $data['attach']) : '',
				));
				
				// Try sending the e-mail. Redirect on failure
				if ( ! self::trySendingMail($data)) {
					redirect(current_url());
				}
				
				// If autoreply has been enabled then send the end user an autoreply response
				if ($autoreplyTemplate) {
					
					// Change the address and template slug
					$data['to']      = $data['email'];
					$data['slug']    = $autoreplyTemplate;
					
					// Try sending the e-mail. Redirect on failure
					if ( ! self::trySendingMail($data)) {
						redirect(current_url());
					}
				}
				
				// If we got this far we can add a success message
				$sessionMessage = $this->session->userdata('flash:new:success');
				$localMessage = $this->attribute('error', lang('contact_sent_text'));
				
				if (null !== $sessionMessage) {
					$localMessage = array($sessionMessage, $localMessage);
				} 
				
				$this->session->set_flashdata('success', $localMessage);
				redirect(($redirect ? $redirect : current_url()));
			}
		}

		// From here on out is form production
		$parseData = array();
		foreach ($formMeta as $field => $value) {
			$parseData[$field]  = form_error($field, '<div class="'.$field.'-error error">', '</div>');
			
			if ($value['type'] == 'dropdown') {
				$parseData[$field] .= call_user_func(
										'form_'.$value['type'],
										$field,
										$formMeta[$field]['dropdown'],
										set_value($field),
										'id="contact_'.$field.'" class="'.$field.'"');
										
			} elseif($value['type'] == 'hidden') {
				$parseData[$field] .= call_user_func(
										'form_'.$value['type'],
										$field,
										$value['value'],
										'class="'.$field.'"');
										
			} else {
				$parseData[$field] .= call_user_func(
										'form_'.$value['type'],
										$field,
										set_value($field),
										'id="contact_'.$field.'" class="'.$field.'"');
			}
		}
	
		$output	 = form_open_multipart($action, 'class="contact-form"').PHP_EOL;
		$output	.= form_input('d0ntf1llth1s1n', ' ', 'class="default-form" style="display:none"');
		$output	.= $this->parser->parse_string($this->content(), str_replace('{{', '{ {', $parseData), true).PHP_EOL;
		$output .= '<span class="contact-button">'.form_submit('contact-submit', ucfirst($button)).'</span>'.PHP_EOL;
		$output .= form_close();

		return $output;
	}
	
	public function _requireUpload($field)
	{
		return (isset($_FILES[$field]) and $_FILES[$field]['name'] > '') ? true : false;
	}
	
	/**
	 * Try to send an e-mail. Add an error message if sending the e-mail failed
	 * 
	 * @access	public
	 * @param	array 	$data	E-mail data
	 * @return	bool			True on success, false on failure
	 */
	public static function trySendingMail($data) 
	{
		if ( ! Events::trigger('email', $data, 'string')) {
			
			$localMessage = $this->attribute('error', lang('contact_error_message'));
			
			// Figure out whether we should add to a current error message 
			$sessionMessage = $this->session->userdata('flash:new:error');
			if (null !== $sessionMessage) {
				$localMessage = array($sessionMessage, $localMessage);
			} 
			
			$this->session->set_flashdata('error', $localMessage);
			
			return false;
		}
		
		return true;
	}
	
}