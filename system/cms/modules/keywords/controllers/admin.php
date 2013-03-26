<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Maintain a central list of keywords to label and organize your content.
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Keywords\Controllers
 *
 */
class Admin extends Admin_Controller
{
	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->library('form_validation');

		$this->load->model('keyword_m');

		$this->lang->load('keywords');

		// Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'name',
				'label' => lang('keywords:name'),
				'rules' => 'trim|required|max_length[50]|strtolower|is_unique[keywords.name]'
			),
		);
	}

	/**
	 * Create a new keyword
	 */
	public function index()
	{
		$keywords = $this->keyword_m->order_by('name')->get_all();

		$this->template
			->title($this->module_details['name'])
			->set('keywords', $keywords)
			->build('admin/index');
	}

	/**
	 * Create a new keyword
	 *
	 * 
	 * @return void
	 */
	public function add()
	{
		$keyword = new stdClass();

		if ($_POST)
		{
			$this->form_validation->set_rules($this->validation_rules);

			$name = $this->input->post('name');

			if ($this->form_validation->run())
			{
				if ($id = $this->keyword_m->insert(array('name' => $name)))
				{
					// Fire an event. A new keyword has been added.
					Events::trigger('keyword_created', $id);

					$this->session->set_flashdata('success', sprintf(lang('keywords:add_success'), $name));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('keywords:add_error'), $name));
				}

				redirect('admin/keywords');
			}
		}

		$keyword = new stdClass();

		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$keyword->{$rule['field']} = set_value($rule['field']);
		}

		$this->template
			->title($this->module_details['name'], lang('keywords:add_title'))
			->set('keyword', $keyword)
			->build('admin/form');
	}


	/**
	 * Edit a keyword
	 *
	 * 
	 *
	 * @param int $id The ID of the keyword to edit
	 *
	 * @return void
	 */
	public function edit($id = 0)
	{
		$keyword = $this->keyword_m->get($id);

		// Make sure we found something
		$keyword or redirect('admin/keywords');

		if ($_POST)
		{
			$this->form_validation->set_rules($this->validation_rules);

			$name = $this->input->post('name');

			if ($this->form_validation->run())
			{
				if ($success = $this->keyword_m->update($id, array('name' => $name)))
				{
					// Fire an event. A keyword has been updated.
					Events::trigger('keyword_updated', $id);
					$this->session->set_flashdata('success', sprintf(lang('keywords:edit_success'), $name));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('keywords:edit_error'), $name));
				}

				redirect('admin/keywords');
			}
		}

		$this->template
			->title($this->module_details['name'], sprintf(lang('keywords:edit_title'), $keyword->name))
			->set('keyword', $keyword)
			->build('admin/form');
	}

	/**
	 * Delete keyword role(s)
	 *
	 * 
	 *
	 * @param int $id The ID of the keyword to delete
	 *
	 * @return void
	 */
	public function delete($id = 0)
	{
		if ($success = $this->keyword_m->delete($id))
		{
			// Fire an event. A keyword has been deleted.
			Events::trigger('keyword_deleted', $id);
			$this->session->set_flashdata('success', lang('keywords:delete_success'));
		}
		else
		{
			$this->session->set_flashdata('error', lang('keywords:delete_error'));
		}

		redirect('admin/keywords');
	}

	public function autocomplete()
	{
		echo json_encode(
			$this->keyword_m->select('name value')
				->like('name', $this->input->get('term'))
				->order_by('name')
				->get_all()
		);
	}
}
