<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	function __construct()
	{
		parent::Admin_Controller();        
		$this->load->model('newsletters_m');
		$this->lang->load('newsletter');        
		$this->newsletters_m->email_from = $this->settings->item('contact_email');
		
		$this->template->set_partial('sidebar', 'admin/sidebar');
	}
	
	// Admin: Show Newsletters
	function index()
	{	
		// Create pagination links
		$total_rows = $this->newsletters_m->countNewsletters();
		$this->data->pagination = create_pagination('admin/newsletters/index', $total_rows);
		
		// Using this data, get the relevant results
		$this->data->newsletters = $this->newsletters_m->getNewsletters(array('order'=>'created_on DESC', 'limit' => $this->data->pagination['limit']));		
		$this->template->build('admin/index', $this->data);
	}
	
	function view($id = 0)
	{
		$this->data->newsletter = $this->newsletters_m->getNewsletter($id);		
		if ($this->data->newsletter)
		{
			$this->template->build('admin/view', $this->data);
		}        
		else
		{
			redirect('admin/newsletters');
		}
	}
	
	// Admin: Create a new Newsletter
	function create()
	{
		$this->load->library('validation');
		
		$rules['title'] = 'trim|required';
		$rules['body'] = 'trim|required';
		$this->validation->set_rules($rules);
		$this->validation->set_fields();
		
		if ($this->validation->run())
		{
			if ($this->newsletters_m->newNewsletter($_POST))
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('letter_add_success'), $this->input->post('title'))); 
				redirect('admin/newsletters');
			}            
			else
			{
				$this->session->set_flashdata(array('error'=> $this->lang->line('letter_add_error')));
			}
		}
		
		// Load WYSIWYG editor
		$this->template->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) );		
		$this->template->build('admin/create', $this->data);
	}
	
	function send($id = 0)
	{
		// If the newsletter was sent ok
		if($this->newsletters_m->sendNewsletter($id))
		{
			$this->session->set_flashdata('success', $this->lang->line('letter_sent_success'));
		} 		
		else
		{
			$this->session->set_flashdata('error', $this->lang->line('letter_sent_error'));
		}		
		redirect('admin/newsletters');
	}
	
	// Admin: Export
	function export()
	{
		$this->load->plugin('to_xml');
		to_xml($this->db->get('emails'), 'recipients');
	}
}
?>