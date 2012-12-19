<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Cms controller for the redirects module
 *
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Redirects\Controllers
 */
class Admin extends Admin_Controller
{
	/**
	 * Array containing the validation rules.
	 *
	 * @var array
	 */
	protected $validation_rules = array(
		array(
			'field' => 'type',
			'label' => 'lang:redirects.type',
			'rules' => 'trim|required|integer'
		),
		array(
			'field' => 'from',
			'label' => 'lang:redirects.from',
			'rules' => 'trim|required|max_length[250]|callback__check_unique'
		),
		array(
			'field' => 'to',
			'label' => 'lang:redirects.to',
			'rules' => 'trim|required|max_length[250]'
		)
	);

	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->library('form_validation');
		$this->load->model('redirect_m');
		$this->lang->load('redirects');

		$this->form_validation->set_rules($this->validation_rules);
	}

	/**
	 * List all redirects
	 */
	public function index()
	{
        // Create pagination links
		$total_rows = $this->redirect_m->count_all();
		$this->template->pagination = create_pagination('admin/redirects/index', $total_rows);

		// Using this data, get the relevant results
		$this->template->redirects = $this->redirect_m->order_by('`from`')->limit($this->template->pagination['limit'])->get_all();
		$this->template->build('admin/index');
	}

	/**
	 * Create a new redirect
	 */
	public function add()
	{
		$messages = array();
		// Got validation?
		if ($this->form_validation->run())
		{
			if ($this->redirect_m->insert($_POST))
			{
				$this->session->set_flashdata('success', lang('redirects:add_success'));
				
				Events::trigger('redirect_created');

				redirect('admin/redirects');
			}

			$messages['error'] = lang('redirects:add_error');
		}

		// Loop through each validation rule
		$redirect = array();
		foreach($this->validation_rules as $rule)
		{
			$redirect[$rule['field']] = set_value($rule['field']);
		}

		$this->template
			->set('redirect', $redirect)
			->set('messages', $messages)
			->build('admin/form');
	}

	/**
	 * Edit an existing redirect
	 *
	 * @param int $id The ID of the redirect
	 *
	 * @return void
	 */
	public function edit($id = 0)
	{
		$messages = array();
		// Got ID?
		$id or redirect('admin/redirects');

		// Get the redirect
		$redirect = $this->redirect_m->get($id);

		if ($this->form_validation->run())
		{
			if ($this->redirect_m->update($id, $_POST))
			{
				$this->session->set_flashdata('success', $this->lang->line('redirects:edit_success'));
				
				Events::trigger('redirect_updated', $id);

				redirect('admin/redirects');
			}

			$messages['error'] = lang('redirects:edit_error');
		}

		$this->template
			->set('redirect', $redirect)
			->set('messages', $messages)
			->build('admin/form');
	}

	/**
	 * Delete an existing redirect
	 *
	 * @param int $id The ID of the redirect
	 *
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
					$this->session->set_flashdata('error', sprintf($this->lang->line('redirects:mass_delete_error'), $id));
				}
				$to_delete++;
			}

			if ($deleted > 0)
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('redirects:mass_delete_success'), $deleted, $to_delete));
			}
			
			Events::trigger('redirect_deleted', $id_array);
		}
		else
		{
			$this->session->set_flashdata('error', $this->lang->line('redirects:no_select_error'));
		}		
		
		redirect('admin/redirects');
	}

	/**
	 * Callback method for validating the redirect's name
	 *
	 * @param string $from

	 * @return bool
	 */
	public function _check_unique($from)
	{
		$id = $this->uri->segment(4);

		if ($this->redirect_m->check_from($from, $id))
		{
			$this->form_validation->set_message('_check_unique', sprintf(lang('redirects:request_conflict_error'), $from));
			return false;
		}

		return true;
	}
}