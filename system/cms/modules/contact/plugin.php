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
	 * {{ contact:form 	fields	 = "name|email|phone|subject|body:textarea"
	 * 					required = "name|email|body"
	 * 					reply-to = "visitor@somewhere.com" * Read note below *
	 * 					button	 = "send"
	 * 					template = "contact"
	 * 					lang	 = "en"
	 * 					to		 = "contact@site.com"
	 * 					from	 = "server@site.com"
	 * 	}}
	 *		{{ open }} // Opening form tag.
	 * 				{{ name }}
	 * 				{{ email }}
	 * 				{{ phone }}
	 * 				{{ subject }}
	 * 				{{ body }}
	 * 		{{ close }} // Closing form tag + submit button.
	 * 	{{ /contact:form }}
	 *
	 * 	If form validation doesn't pass the error messages will be displayed next to the corresponding form element.
	 *
	 * @param	fields		Pipe separated string of form inputs to build. Defaults to :text but :textarea can also be used
	 * @param	required	Pipe separated string of fields that are required
	 * @param	reply-to	*If you have a field named "email" it will be used as a default. You should have one or the other if you plan to reply
	 * @param	button		The name of the submit button
	 * @param	template	The slug of the Email Template that you wish to use
	 * @param	lang		The language version of the Email template
	 * @param	to			Email address to send to
	 * @param	from		Server email that emails will show as the sender
	 * @return	array
	 */
	public function form()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');
		
		$rules = array('input' 		=> 'trim|max_length[255]',
					   'textarea' 	=> 'trim'
					   );
		
		$field_list = explode('|', $this->attribute('fields'));
		$required	= explode('|', $this->attribute('required'));
		$button 	= $this->attribute('button', 'send');
		$template	= $this->attribute('template', 'contact');
		$lang 		= $this->attribute('lang', Settings::get('site_lang'));
		$to			= $this->attribute('to', Settings::get('contact_email'));
		$from		= $this->attribute('from', Settings::get('server_email'));
		$reply_to	= $this->attribute('reply-to');
		$form_meta 	= array();
		$validation	= array();
		$output		= array();

		foreach ($field_list AS $i => &$field)
		{
			if (strpos($field, ':'))
			{
				$type = substr($field, (strpos($field, ':') +1));
				// we let the user use the word "text" because it makes or sense then "input"
				$type = ($type == 'text') ? 'input' : $type;
				$field = substr($field, 0, strpos($field, ':'));
			}
			else
			{
				$type = 'input';
			}

			$form_meta[$field]['type'] = $type;
			$validation[$i]['field'] = $field;
			$validation[$i]['label'] = ucfirst($field);
			$validation[$i]['rules'] = $rules[$type].(in_array($field, $required) ? '|required' : '');
		}

		$this->form_validation->set_rules($validation);

		if ($this->form_validation->run())
		{
			$data = $this->input->post();

			// Add in some extra details
			$data['sender_agent']	= $this->agent->browser() . ' ' . $this->agent->version();
			$data['sender_ip']		= $this->input->ip_address();
			$data['sender_os']		= $this->agent->platform();
			$data['slug'] 			= $template;
			// they may have an email field in the form. If they do we'll use that for reply-to.
			$data['reply-to']		= (empty($reply_to) AND isset($data['email'])) ? $data['email'] : $reply_to;
			$data['to']				= $to;
			$data['from']			= $from;
	
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
					$this->session->set_flashdata('error', lang('contact_error_message'));
					redirect(current_url());
				}
			}
			$this->session->set_flashdata('success', lang('contact_sent_text'));
			redirect(current_url());
		}

		$output['open'] 	= form_open(current_url());
		$output['close'] 	= form_submit($button, ucfirst($button));
		$output['close']   .= form_close();
		
		foreach ($form_meta AS $form => $params)
		{
			$output[$form]  = form_error($form);
			$output[$form] .= call_user_func('form_'.$params['type'], $form, set_value($form));
		}

		return $output;
	}
}