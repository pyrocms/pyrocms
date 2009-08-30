<?php
class Contact extends Public_Controller
{	
	var $subjects = array(
		'support'	=>	'Support',
		'sales'		=>	'Sales',
		'payments'	=>	'Payments',
		'business'	=>	'Business Development',
		'feedback'	=>	'Feedback/Suggestions',
		'other'		=>	'Other'				
	);
	
	// Fields must match this certain criteria
	var $rules = array(
		'contact_name'	=>	'required|trim|max_length[80]',
		'contact_email'	=>	'required|trim|valid_email|max_length[80]',
		'company_name'	=>	'trim|max_length[80]',
		'subject'		=>	'required|trim',
		'message'		=>	'required'
	);
	
	function __construct()
	{
		parent::Public_Controller();        
		$this->lang->load('contact');
	}
	
	function index()
	{
		$this->load->library('user_agent');
		$this->load->library('session');
		
		$this->load->helper('form');
		
		if($this->settings->item('captcha_enabled'))
		{
			$this->rules["captcha"] = "trim|required|callback__CheckCaptcha";
			
			// load captcha
			$this->load->plugin('captcha');
			$vals = array(
				'img_path'	 => $this->settings->item('captcha_folder'),
				'img_url'	 => base_url().$this->settings->item('captcha_folder')
			);			
			$this->data->captcha = create_captcha($vals);
			$this->session->set_flashdata('captcha_'.$this->data->captcha['time'], $this->data->captcha['word']);
		}
	
		// If the user has provided valid information and isnt a robot
		if(!empty($_POST) && $this->_validate())
		{		
			// The try to send the email
			if($this->_send_email())
			{
				// Store this session to limit useage
				$this->session->set_flashdata('sent_contact_form', TRUE);
				
				// Now redirec
				redirect('contact/sent');	
			}	
		}
		
		$this->data->subjects =& $this->subjects;
		
		// Set the values for the form inputs
		foreach(array_keys($this->rules) as $field_name)
		{
			$this->data->form_values->$field_name = isset($this->validation->$field_name) ? $this->validation->$field_name : '';
		}		
		$this->layout->create('index', $this->data);
	}
	
	
	function sent()
	{
		$this->layout->create('sent', $this->data);
	}
	
	
	function _validate()
	{
		$this->load->library('validation');		
		// Get the language keys for the field
		foreach(array_keys($this->rules) as $field_name)
		{
			$fields[$field_name] = $this->lang->line('contact_'.$field_name.'_label');
		}		
		$this->validation->set_fields($fields);
		$this->validation->set_rules($this->rules);		
		return ($this->validation->run());
	}
	
	
	function _send_email()
	{
		$this->load->library('email');
		$this->load->library('user_agent');		
		$this->email->from($this->input->post('contact_email'), $this->input->post('contact_name'));
		$this->email->to($this->settings->item('contact_email'));
		
		// If "other subject" exists then use it, if not then use the selected subject
		$subject = ($this->input->post('other_subject')) ? $this->input->post('other_subject') : $this->subjects[$this->input->post('subject')];
		$this->email->subject($this->settings->item('site_name') .' '.$subject);
		
		// Loop through cleaning data and inputting to $data
		foreach(array_keys($_POST) as $field_name)
		{
			$data[$field_name] = $this->input->post($field_name, TRUE);
		}
		
		// Add in some extra details		
		$data['sender_agent']	=	$this->agent->browser().' '.$this->agent->version();
		$data['sender_ip']		=	$this->input->ip_address();
		$data['sender_os']		=	$this->agent->platform();
		
		$this->email->message($this->load->view('email/contact_html', $data, TRUE));
		$this->email->set_alt_message($this->load->view('email/contact_plain', $data, TRUE));
		
		// If the email has sent with no known erros, show the message
		return ( $this->email->send() );
	}
	
	function _CheckCaptcha($title = '')
	{
		$captcha_id = $this->input->post('captcha_id');
		$captcha_word = $this->session->flashdata('captcha_'.$captcha_id);
		
		if ($captcha_word != $this->input->post('captcha'))
		{
			$this->validation->set_message('_CheckCaptcha', $this->lang->line('contact_capchar_error'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}	
}	
?>