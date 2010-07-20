<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Newsletter module
 *
 * @author Phil Sturgeon - PyroCMS Dev Team
 * @package PyroCMS
 * @subpackage Newsletter module
 * @category Modules
 */
class Admin extends Admin_Controller
{
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	private $validation_rules = array();
	
	/**
	 * Constructor method
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::Admin_Controller();        
		$this->load->model('newsletters_m');
		$this->lang->load('newsletter');        
		$this->newsletters_m->email_from = $this->settings->item('contact_email');
		
		// Load and set the validation rules
		$this->load->library('form_validation');
		$this->validation_rules = array(
			array(
				'field' => 'title',
				'label' => lang('letter.title_label'),
				'rules'	=> 'trim|required'
			),
			array(
				'field' => 'body',
				'label' => lang('letter.body_label'),
				'rules' => 'trim|required'
			)
		);
		$this->form_validation->set_rules($this->validation_rules);
		
		$this->template->set_partial('shortcuts', 'admin/partials/shortcuts');
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
		if ($this->form_validation->run())
		{
			if ($this->newsletters_m->newNewsletter($_POST))
			{
				$this->session->set_flashdata('success', sprintf(lang('letter_add_success'), $this->input->post('title'))); 
				redirect('admin/newsletters');
			}            
			else
			{
				$this->session->set_flashdata(array('error'=> lang('letter_add_error')));
			}
		}
		
		// Loop through each rule
		foreach($this->validation_rules as $rule)
		{
			$newsletter->{$rule['field']} = $this->input->post($rule['field']);
		}
		
		// Load WYSIWYG editor
		$this->data->newsletter =& $newsletter;
		$this->template->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) );		
		$this->template->build('admin/create', $this->data);
	}
	
	function send($id = 0)
	{
		// If the newsletter was sent ok
		if($this->newsletters_m->sendNewsletter($id))
		{
			$this->session->set_flashdata('success', lang('letter_sent_success'));
		} 		
		else
		{
			$this->session->set_flashdata('error', lang('letter_sent_error'));
		}		
		redirect('admin/newsletters');
	}
	
	// Admin: Export
	function export()
	{
		$this->load->helper('xml');
		to_xml($this->db->get('emails'), 'recipients');
	}
}
?>