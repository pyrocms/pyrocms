<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Contact Plugin
 *
 * Build and send contact forms
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2011, PyroCMS
 *
 */
class Plugin_Contact extends Plugin {

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
	 * {{ contact:form 	name	 			= "text|required"
	 * 					email	 			= "text|required|valid_email"
	 * 					subject				= "dropdown|required|hello=Say Hello|support=Support Request|Something Else"
	 * 					message	 			= "textarea|required"
	 * 					attachment			= "file|jpg|png|zip
	 * 					max-size 			= "10000"
	 * 					reply-to 			= "visitor@somewhere.com" * Read note below *
	 * 					button	 			= "send"
	 * 					template 			= "contact"
	 * 					lang	 			= "en"
	 * 					to		 			= "contact@site.com"
	 * 					from	 			= "server@site.com"
	 * 					sent				= "Your message has been sent. Thank you for contacting us"
	 * 					error				= "Sorry. Your message could not be sent. Please call us at 123-456-7890"
	 * 					success-redirect	= "home"
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
	 * @param	success-redirect	Redirect the user to a different page if the message was sent successfully. 
	 * @return	string
	 */
	public function form()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');
		
		$field_list = $this->attributes();
		
		// If they try using the old form tag plugin give them an idea why it's failing.
		if ( ! $this->content() OR count($field_list) == 0)
		{
			return 'The new contact plugin requires field parameters and it must be used as a double tag.';
		}
		
		$button 	= $this->attribute('button', 'send');
		$template	= $this->attribute('template', 'contact');
		$lang 		= $this->attribute('lang', Settings::get('site_lang'));
		$to			= $this->attribute('to', Settings::get('contact_email'));
		$from		= $this->attribute('from', Settings::get('server_email'));
		$reply_to	= $this->attribute('reply-to');
		$max_size	= $this->attribute('max-size', 10000);
		$redirect	= $this->attribute('success-redirect', FALSE);
		$form_meta 	= array();
		$validation	= array();
		$output		= array();
		$dropdown	= array();
		
		// unset all attributes that are not field names
		unset($field_list['button'],
			  $field_list['template'],
			  $field_list['lang'],
			  $field_list['to'],
			  $field_list['from'],
			  $field_list['reply-to'],
			  $field_list['max-size']
			  );

		foreach ($field_list AS $field => $rules)
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
					foreach ($values AS $item)
					{
						$item = explode('=', $item);
						// If they didn't specify a key=>value (example: name=Your Name) then we'll use the value for the key also
						$dropdown[$item[0]] = (count($item) > 1) ? $item[1] : $item[0];
					}
					
					$form_meta[$field]['dropdown'] = $dropdown;
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
			}

			$validation[$field]['field'] = $field;
			$validation[$field]['label'] = ucfirst($field);
			$validation[$field]['rules'] = ($rule_array[0] == 'file' OR $rule_array[0] == 'dropdown') ? $other_rules : implode('|', $rule_array);
		}

		$this->form_validation->set_rules($validation);

		if ($this->form_validation->run())
		{
			$data = $this->input->post();

			// Add in some extra details about the visitor
			$data['sender_agent']	= $this->agent->browser() . ' ' . $this->agent->version();
			$data['sender_ip']		= $this->input->ip_address();
			$data['sender_os']		= $this->agent->platform();
			$data['slug'] 			= $template;
			// they may have an email field in the form. If they do we'll use that for reply-to.
			$data['reply-to']		= (empty($reply_to) AND isset($data['email'])) ? $data['email'] : $reply_to;
			$data['to']				= $to;
			$data['from']			= $from;

			// Yay they want to send attachments along
			if ($_FILES > '')
			{
				$this->load->library('upload');
				is_dir(UPLOAD_PATH.'contact_attachments') OR @mkdir(UPLOAD_PATH.'contact_attachments', 0777);
				
				foreach ($_FILES AS $form => $file)
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

			// fetch the template so we can parse it to insert into the database log
			$this->load->model('templates/email_templates_m');
			$templates = $this->email_templates_m->get_templates($template);
			
            $subject = array_key_exists($lang, $templates) ? $templates[$lang]->subject : $templates['en']->subject ;
            $data['subject'] = $this->parser->parse_string($subject, $data, TRUE);

            $body = array_key_exists($lang, $templates) ? $templates[$lang]->body : $templates['en']->body ;
            $data['body'] = $this->parser->parse_string($body, $data, TRUE);
			
			$this->load->model('contact/contact_m');
			
			// Finally, we insert the same thing into the log as what we sent
			$this->contact_m->insert_log($data);
		
			foreach ($results as $result)
			{
				if ( ! $result)
				{
					$message = $this->attribute('error', lang('contact_error_message'));
					
					$this->session->set_flashdata('error', $message);
					redirect(current_url());
				}
			}
			
			$message = $this->attribute('sent', lang('contact_sent_text'));
			
			$this->session->set_flashdata('success', $message);
			redirect( ($redirect ? $redirect : current_url()) );
		}

		// From here on out is form production
		$parse_data = array();
		foreach ($form_meta AS $form => $value)
		{
			$parse_data[$form]  = form_error($form);
			
			if ($value['type'] == 'dropdown')
			{
				$parse_data[$form] .= call_user_func('form_'.$value['type'],
														$form,
														$form_meta[$form]['dropdown'],
														set_value($form),
														'class="'.$form.'"'
													 );
			}
			else
			{
				$parse_data[$form] .= call_user_func('form_'.$value['type'],
														$form,
														set_value($form),
														'class="'.$form.'"'
													 );				
			}
		}
	
		$output	 = form_open_multipart(current_url()).PHP_EOL;
		$output	.= $this->parser->parse_string($this->content(), str_replace('{{', '{ {', $parse_data), TRUE).PHP_EOL;
		$output .= '<p class="contact-button">'.form_submit($button, ucfirst($button)).'</p>'.PHP_EOL;
		$output .= form_close();

		return $output;
	}
	
	public function _require_upload($field)
	{
		if ( isset($_FILES[$field]) AND $_FILES[$field]['name'] > '')
		{
			return TRUE;
		}
		return FALSE;
	}
}