<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Cms controller for the redirects module
 * 
 * @author 		Phil Sturgeon - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Variables Module
 * @category	Modules
 */
class Admin extends Admin_Controller
{
	/**
	 * Constructor method
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		// Load the required classes
		$this->load->library('form_validation');
		$this->load->model('redirect_m');
		$this->lang->load('redirects');

		// Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'from',
				'label' => lang('redirects.from'),
				'rules' => 'trim|required|max_length[250]|callback__check_unique'
			),
			array(
				'field' => 'to',
				'label' => lang('redirects.to'),
				'rules' => 'trim|required|max_length[250]'
			)
		);

		$this->form_validation->set_rules($this->validation_rules);

		$this->template->set_partial('shortcuts', 'admin/partials/shortcuts');
	}
	
	/**
	 * List all redirects
	 * @access public
	 * @return void
	 */
	public function index()
	{
        // Create pagination links
		$total_rows = $this->redirect_m->count_all();
		$this->data->pagination = create_pagination('admin/redirects/index', $total_rows);
		
		// Using this data, get the relevant results
		$this->data->redirects = $this->redirect_m->order_by('`from`')->limit($this->data->pagination['limit'])->get_all();
		$this->template->build('admin/index', $this->data);
	}
	
	/**
	 * Create a new redirect
	 * @access public
	 * @return void
	 */
	public function add()
	{		
		// Got validation?
		if ($this->form_validation->run())
		{
			if ($this->redirect_m->insert($_POST))
			{
				$this->session->set_flashdata('success', lang('redirects.add_success'));

				// Redirect
				redirect('admin/redirects');
			}
			
			$this->data->messages['error'] = lang('redirects.add_error');
		}

		// Loop through each validation rule
		foreach($this->validation_rules as $rule)
		{
			$redirect->{$rule['field']} = set_value($rule['field']);
		}
		
		$this->data->redirect =& $redirect;
		$this->template->build('admin/form', $this->data);
	}
	
	/**
	 * Edit an existing redirect
	 * @access public
	 * @param int $id The ID of the redirect
	 * @return void
	 */
	public function edit($id = 0)
	{	
		// Got ID?
		$id or redirect('admin/redirects');
		
		// Get the redirect
		$redirect = $this->redirect_m->get($id);
		
		if ($this->form_validation->run())
		{		
			if ($this->redirect_m->update($id, $_POST))
			{
				$this->session->set_flashdata('success', $this->lang->line('redirects.edit_success'));

				redirect('admin/redirects');
			}
			
			$this->data->messages['error'] = lang('redirects.edit_error');
		}
	
		$this->data->redirect =& $redirect;
		$this->template->build('admin/form', $this->data);
	}	
	
	/**
	 * Delete an existing redirect
	 * @access public
	 * @param int $id The ID of the redirect
	 * @return void
	 */
	public function delete($id = 0)
	{	
		$id_array = ( ! empty($id)) ? array($id) : $this->input->post('action_to');
		
		// Delete multiple
		if( ! empty($id_array))
		{
			$deleted = 0;
			$to_delete = 0;
			foreach ($id_array as $id) 
			{
				if ($this->redirect_m->delete($id))
				{
					$deleted++;
				}
				else
				{
					$this->session->set_flashdata('error', sprintf($this->lang->line('redirects.mass_delete_error'), $id));
				}
				$to_delete++;
			}
			
			if ($deleted > 0)
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('redirects.mass_delete_success'), $deleted, $to_delete));
			}
		}		
		else
		{
			$this->session->set_flashdata('error', $this->lang->line('redirects.no_select_error'));
		}		
		
		// Redirect
		redirect('admin/redirects');
	}
	
	/**
	 * Callback method for validating the redirect's name
	 * @access public
	 * @param str $name The name of the redirect
	 * @param int $id the ID of the redirect
	 * @return bool
	 */
	public function _check_unique($from)
	{
		$id = $this->uri->segment(4);

		if ($this->redirect_m->check_from($from, $id))
		{
			$this->form_validation->set_message('_check_unique', sprintf(lang('redirects.request_conflict_error'), $from));
			return FALSE;
		}

		return TRUE;
	}
}