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
			'form' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Display a contact form anywhere on your site. Each wildcard attribute that you pass ("email" for example) is available as a variable in the email template and between the double tags to output the form field.'
				),
				'single' => false,// will it work as a single tag?
				'double' => true,// how about as a double tag?
				'variables' => 'name|email|subject|message|attachment-file|some-hidden-value',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(
					'name' => array(
						'type' => 'text',
						'flags' => 'text|required',
						'default' => '',
						'required' => false,
					),
					'email' => array(
						'type' => 'text',
						'flags' => 'text|required|valid_email',
						'default' => '',
						'required' => false,
					),
					'subject' => array(
						'type' => 'text',
						'flags' => 'dropdown|required|value=Name|another=Another Name',
						'default' => '',
						'required' => false,
					),
					'message' => array(
						'type' => 'text',
						'flags' => 'textarea|required|trim',
						'default' => '',
						'required' => false,
					),
					'some-hidden-value' => array(
						'type' => 'text',
						'flags' => 'hidden|=a hidden value',
						'default' => '',
						'required' => false,
					),
					'attachment-file' => array(
						'type' => 'text',
						'flags' => 'file|jpg|png|zip',
						'default' => '',
						'required' => false,
					),
					'max-size' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '10000',
						'required' => false,
					),
					'button' => array(
						'type' => 'text',
						'flags' => '',
						'default' => 'Send',
						'required' => false,
					),
					'template' => array(
						'type' => 'slug',
						'flags' => '',
						'default' => 'contact',
						'required' => false,
					),
					'lang' => array(
						'type' => 'text',
						'flags' => '',
						'default' => 'en',
						'required' => false,
					),
					'to' => array(
						'type' => 'text',
						'flags' => '',
						'default' => Settings::get('contact_email'),
						'required' => false,
					),
					'from' => array(
						'type' => 'text',
						'flags' => '',
						'default' => Settings::get('server_email'),
						'required' => false,
					),
					'sent' => array(
						'type' => 'text',
						'flags' => '',
						'default' => 'Your message has been sent. We will get back to you as soon as we can.',
						'required' => false,
					),
					'error' => array(
						'type' => 'text',
						'flags' => '',
						'default' => 'There was a problem sending this message. Please try again later.',
						'required' => false,
					),
					'auto-reply' => array(
						'type' => 'text',
						'flags' => 'autoreply-template',
						'default' => '',
						'required' => false,
					),
					'success-redirect' => array(
						'type' => 'text',
						'flags' => '',
						'default' => 'the current uri',
						'required' => false,
					),
					'action' => array(
						'type' => 'text',
						'flags' => '',
						'default' => 'the current uri string',
						'required' => false,
					),
				),
			),// end first method
		);
	
		return $info;
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
		$this->load->library('form_validation');
		$this->load->helper('form');
		
		$field_list = $this->attributes();
		
		// If they try using the old form tag plugin give them an idea why it's failing.
		if ( ! $this->content() or count($field_list) == 0)
		{
			return 'The new contact plugin requires field parameters and it must be used as a double tag.';
		}

		$button             = $this->attribute('button', 'send');
		$template           = $this->attribute('template', 'contact');
		$autoreply_template = $this->attribute('auto-reply', false);
		$lang               = $this->attribute('lang', Settings::get('site_lang'));
		$to                 = $this->attribute('to', Settings::get('contact_email'));
		$from               = $this->attribute('from', Settings::get('server_email'));
		$reply_to           = $this->attribute('reply-to');
		$max_size           = $this->attribute('max-size', 10000);
		$redirect           = $this->attribute('success-redirect', false);
		$action             = $this->attribute('action', current_url());
		$form_meta          = array();
		$validation         = array();
		$output             = array();
		$dropdown           = array();
		
		// unset all attributes that are not field names
		unset($field_list['button'],
			$field_list['template'],
			$field_list['auto-reply'],
			$field_list['lang'],
			$field_list['to'],
			$field_list['from'],
			$field_list['reply-to'],
			$field_list['max-size'],
			$field_list['redirect'],
			$field_list['action']
		);

		foreach ($field_list as $field => $rules)
		{
			$rule_array = explode('|', $rules);
			
			// Take the simplified form names and turn them into the real deal
			switch ($rule_array[0]) {
				case '':
					$form_meta[$field]['type'] = 'input';
				break;
				case 'text':
					$form_meta[$field]['type'] = 'input';
				break;
				
				case 'textarea':
					$form_meta[$field]['type'] = 'textarea';
				break;
			
				case 'dropdown':
					$form_meta[$field]['type'] = 'dropdown';
					
					// In this case $rule_array holds the dropdown key=>values and possibly the "required" rule.
					$values = $rule_array;
					// get rid of the field type
					unset($values[0]);
					
					// Is a value required?
					if ($required_key = array_search('required', $values))
					{
						$other_rules = 'required';
						unset($values[$required_key]);
					}
					else
					{
						// Just set something
						$other_rules = 'trim';
					}

					// Build the array to pass to the form_dropdown() helper
					foreach ($values as $item)
					{
						$item = explode('=', $item);
						// If they didn't specify a key=>value (example: name=Your Name) then we'll use the value for the key also
						$dropdown[$item[0]] = (count($item) > 1) ? $item[1] : $item[0];
					}
					
					$form_meta[$field]['dropdown'] = $dropdown;
					// we need to empty the array else we'll end up with all values appended
					$dropdown = array();
				break;
				
				case 'file':
					$form_meta[$field]['type'] = 'upload';
					
					$config = $rule_array;
					// get rid of the field type
					unset($config[0]);
					
					// If this attachment is required add that to the rules and unset it from upload config
					if ($required_key = array_search('required', $config))
					{
						if ( ! self::_require_upload($field))
						{
							// We'll set this so validation will fail and our message will be shown
							$other_rules = 'required';
						}
						unset($config[$required_key]);
					}
					else
					{
						$other_rules = 'trim';
					}
					
					// set configs for file uploading
					$form_meta[$field]['config']['allowed_types'] = implode('|', $config);
					$form_meta[$field]['config']['max_size'] = $max_size;
					$form_meta[$field]['config']['upload_path'] = UPLOAD_PATH.'contact_attachments';
				break;	
				
				case 'hidden':
					$form_meta[$field]['type'] = 'hidden';
					$value = preg_split('/=/',$rule_array[1]);
					$value = $value[1];
					$form_meta[$field]['value'] = $value;
					
				break;					
			}

			$validation[$field]['field'] = $field;
			$validation[$field]['label'] = humanize($field);
			$validation[$field]['rules'] = ($rule_array[0] == 'file' or $rule_array[0] == 'dropdown') ? $other_rules : implode('|', $rule_array);
		}


		if ($this->input->post('contact-submit')) { 
			
			$this->form_validation->set_rules($validation);
			
			if ($this->form_validation->run())
			{
				// maybe it's a bot?
				if ($this->input->post('d0ntf1llth1s1n') !== ' ')
				{
					$this->session->set_flashdata('error', lang('contact_submit_error'));
					redirect(current_url());
				}
	
				$data = $this->input->post();
	
				// Add in some extra details about the visitor
				$data['sender_agent'] = $this->agent->browser() . ' ' . $this->agent->version();
				$data['sender_ip']    = $this->input->ip_address();
				$data['sender_os']    = $this->agent->platform();
				$data['slug']         = $template;
				// they may have an email field in the form. If they do we'll use that for reply-to.
				$data['reply-to'] = (empty($reply_to) and isset($data['email'])) ? $data['email'] : $reply_to;
				$data['to']       = $to;
				$data['from']     = $from;
	
				// Yay they want to send attachments along
				if ($_FILES > '')
				{
					$this->load->library('upload');
					is_dir(UPLOAD_PATH.'contact_attachments') OR @mkdir(UPLOAD_PATH.'contact_attachments', 0777);
					
					foreach ($_FILES as $form => $file)
					{
						if ($file['name'] > '')
						{
							// Make sure the upload matches a field
							if ( ! array_key_exists($form, $form_meta)) break;
		
							$this->upload->initialize($form_meta[$form]['config']);
							$this->upload->do_upload($form);
							
							if ($this->upload->display_errors() > '')
							{
								$this->session->set_flashdata('error', $this->upload->display_errors());
								redirect(current_url());
							}
							else
							{
								$result_data = $this->upload->data();
								// pass the attachment info to the email event
								$data['attach'][$result_data['file_name']] = $result_data['full_path'];
							}
						}
					}
				}
	
				// Try to send the email
				$results = Events::trigger('email', $data, 'array');
	
				// If autoreply has been enabled then send the end user an autoreply response
				if ($autoreply_template)
				{
					$data_autoreply            = $data;
					$data_autoreply['to']      = $data['email'];
					$data_autoreply['from']    = $data['from'];
					$data_autoreply['slug']    = $autoreply_template;
					$data_autoreply['name']    = $data['name'];
					$data_autoreply['subject'] = $data['subject'];
				}
	
				// fetch the template so we can parse it to insert into the database log
				$this->load->model('templates/email_templates_m');
				$templates = $this->email_templates_m->get_templates($template);
				
	            $subject = array_key_exists($lang, $templates) ? $templates[$lang]->subject : $templates['en']->subject ;
	            $data['subject'] = $this->parser->parse_string($subject, $data, true);
	
	            $body = array_key_exists($lang, $templates) ? $templates[$lang]->body : $templates['en']->body ;
	            $data['body'] = $this->parser->parse_string($body, $data, true);
				
				$this->load->model('contact/contact_m');
	
				// Grab userdata - we'll need this later
				$userdata = $this->session->all_userdata();
				
				// Finally, we insert the same thing into the log as what we sent
				$this->contact_m->insert_log($data);
			
				foreach ($results as $result)
				{
					if ( ! $result)
					{
						if (isset($userdata['flash:new:error']))
						{
							$message = (array) $userdata['flash:new:error'];
	
							$message[] = $message = $this->attribute('error', lang('contact_error_message'));
						}
						else
						{
							$message = $this->attribute('error', lang('contact_error_message'));
						}
						
						$this->session->set_flashdata('error', $message);
						redirect(current_url());
					}
				}
	
				if($autoreply_template) {
					Events::trigger('email', $data_autoreply, 'array');
				}
	
	
				if (isset($userdata['flash:new:success']))
				{
					$message = (array) $userdata['flash:new:success'];
	
					$message[] = $this->attribute('sent', lang('contact_sent_text'));
				}
				else
				{
					$message = $this->attribute('sent', lang('contact_sent_text'));
				}
	
				$this->session->set_flashdata('success', $message);
				Events::trigger('contact_form_success', $_POST);
				redirect( ($redirect ? $redirect : current_url()) );
			}
		}

		// From here on out is form production
		$parse_data = array();
		foreach ($form_meta as $form => $value)
		{
			$parse_data[$form]  = form_error($form, '<div class="'.$form.'-error error">', '</div>');
			
			if ($value['type'] == 'dropdown')
			{
				$parse_data[$form] .= call_user_func('form_'.$value['type'],
														$form,
														$form_meta[$form]['dropdown'],
														set_value($form),
														'id="contact_'.$form.'" class="'.$form.'"'
													 );
			}
			elseif($value['type'] == 'hidden')
			{
				$parse_data[$form] .= call_user_func('form_'.$value['type'],
														$form,
														$value['value'],
														'class="'.$form.'"'
													 );
			}
			else
			{
				$parse_data[$form] .= call_user_func('form_'.$value['type'],
														$form,
														set_value($form),
														'id="contact_'.$form.'" class="'.$form.'"'
													 );
			}
		}
	
		$output	 = form_open_multipart($action, 'class="contact-form"').PHP_EOL;
		$output	.= form_input('d0ntf1llth1s1n', ' ', 'class="default-form" style="display:none"');
		$output	.= $this->parser->parse_string($this->content(), str_replace('{{', '{ {', $parse_data), true).PHP_EOL;
		$output .= '<span class="contact-button">'.form_submit('contact-submit', ucfirst($button)).'</span>'.PHP_EOL;
		$output .= form_close();

		return $output;
	}
	
	public function _require_upload($field)
	{
		if ( isset($_FILES[$field]) and $_FILES[$field]['name'] > '')
		{
			return true;
		}
		return false;
	}
}
