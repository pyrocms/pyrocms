<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 0.9.8
 * @filesource
 */

class Contact extends Public_Controller
{
	var $subjects = array();

	// Fields must match this certain criteria
	private $rules = array();

	function __construct()
	{
		parent::Public_Controller();
		$this->lang->load('contact');

		$this->subjects = array(
			'support'   => lang('subject_support'),
			'sales'     => lang('subject_sales'),
			'payments'  => lang('subject_payments'),
			'business'  => lang('subject_business'),
			'feedback'  => lang('subject_feedback'),
			'other'     => lang('subject_other')
		);

		$this->rules = array(
			array(
				'field'	=> 'contact_name',
				'label'	=> lang('contact_name_label'),
				'rules'	=> 'required|trim|max_length[80]'
			),
			array(
				'field'	=> 'contact_email',
				'label'	=> lang('contact_email_label'),
				'rules'	=> 'required|trim|valid_email|max_length[80]'
			),
			array(
				'field'	=> 'company_name',
				'label'	=> lang('contact_company_name_label'),
				'rules'	=> 'trim|max_length[80]'
			),
			array(
				'field'	=> 'subject',
				'label'	=> lang('contact_subject_label'),
				'rules'	=> 'required|trim'
			),
			array(
				'field'	=> 'message',
				'label'	=> lang('contact_message_label'),
				'rules'	=> 'required'
			)
		);

	}

	function index()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');
		
		$this->form_validation->set_rules($this->rules);

		// If the user has provided valid information
		if($this->form_validation->run())
		{
			// The try to send the email
			if($this->_send_email())
			{
				// Store this session to limit useage
				$this->session->set_flashdata('sent_contact_form', TRUE);

				// Now redirect
				redirect('contact/sent');
			}
		}

		$this->data->subjects =& $this->subjects;

		// Set the values for the form inputs
		foreach($this->rules as $rule)
		{
			$this->data->form_values->{$rule['field']} = set_value($rule['field']);
		}
		$this->template->build('index', $this->data);
	}


	function sent()
	{
		$this->template->build('sent', $this->data);
	}


	function _send_email()
	{
		$this->load->library('email');
		$this->load->library('user_agent');
		$this->email->from($this->input->post('contact_email'), $this->input->post('contact_name'));
		$this->email->to($this->settings->item('contact_email'));

		// If "other subject" exists then use it, if not then use the selected subject
		$subject = ($this->input->post('other_subject')) ? $this->input->post('other_subject') : $this->subjects[$this->input->post('subject')];
		$this->email->subject($this->settings->item('site_name') .' - '.$subject);

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

}

/* End of file contact.php */