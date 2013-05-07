<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Email Templates Admin Controller
 *
 * @author  Stephen Cozart - PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Templates\Controllers
 */
class Admin extends Admin_Controller
{
	/** @var array */
	private $_validation_rules = array();

	/** @var array */
	private $_edit_default_rules = array();

	/** @var array */
	private $_clone_rules = array();

	/**
	 * Constructor method
	 *
	 * @return Admin
	 */
	function __construct()
	{
		parent::__construct();

		$this->lang->load('templates');
		$this->load->model('email_templates_m');

		foreach ($this->config->item('supported_languages') as $key => $lang)
		{
			$lang_options[$key] = $lang['name'];
		}

		$this->template->set('lang_options', $lang_options);

		$base_rules = 'required|trim';

		$this->_validation_rules = array(
			array(
				'field' => 'name',
				'label' => 'lang:global:name',
				'rules' => $base_rules
			),
			array(
				'field' => 'slug',
				'label' => 'lang:templates.slug_label',
				'rules' => $base_rules.'|alpha_dash'
			),
			array(
				'field' => 'description',
				'label' => 'lang:global:description',
				'rules' => $base_rules
			),
			array(
				'field' => 'subject',
				'label' => 'lang:templates.subject_label',
				'rules' => $base_rules
			),
			array(
				'field' => 'body',
				'label' => 'lang:templates.body_label',
				'rules' => $base_rules
			),
			array(
				'field' => 'lang',
				'label' => 'lang:templates.language_label',
				'rules' => 'trim|xss_clean|max_length[2]'
			)
		);

		$this->_edit_default_rules = array(
			array(
				'field' => 'subject',
				'label' => 'lang:templates.subject_label',
				'rules' => $base_rules
			),
			array(
				'field' => 'body',
				'label' => 'lang:templates.body_label',
				'rules' => $base_rules
			)
		);

		$this->_clone_rules = array(
			array(
				'field' => 'lang',
				'label' => 'lang:templates.language_label',
				'rules' => 'trim|xss_clean|max_length[2]'
			)
		);
	}

	/**
	 * index method
	 *
	 *
	 * @return void
	 */
	public function index()
	{
		$templates = $this->email_templates_m->get_all();

		$this->template
			->title($this->module_details['name'])
			->set('templates', $templates)
			->build('admin/index');
	}

	/**
	 * Used to create an entirely new template from scratch.
	 * Usually will be used for future expansion or third party modules
	 */
	public function create()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->_validation_rules);

		$email_template = new stdClass();

		$email_template->is_default = 0;

		// Go through all the known fields and get the post values
		foreach ($this->_validation_rules as $key => $field)
		{
			$email_template->$field['field'] = $this->input->post($field['field']);
		}

		if ($this->form_validation->run())
		{
			foreach ($_POST as $key => $value)
			{
				$data[$key] = $this->input->post($key);
			}
			unset($data['btnAction']);
			if ($id = $this->email_templates_m->insert($data))
			{
				// Fire an event. A new email template has been created.
				Events::trigger('email_template_created', $id);

				$this->session->set_flashdata('success', sprintf(lang('templates:tmpl_create_success'), $data['name']));
			}
			else
			{
				$this->session->set_flashdata('error', sprintf(lang('templates:tmpl_create_error'), $data['name']));
			}
			redirect('admin/templates');
		}

		$this->template
			->set('email_template', $email_template)
			->title(lang('templates:create_title'))
			->append_metadata($this->load->view('fragments/wysiwyg', array(), true))
			->append_js('module::form.js')
			->build('admin/form');
	}

	public function edit($id = false)
	{
		$email_template = $this->email_templates_m->get($id);

		$this->load->library('form_validation');

		$rules = ($email_template->is_default) ? $this->_edit_default_rules : $this->_validation_rules;

		// Go through all the known fields and get the post values
		foreach (array_keys($rules) as $field)
		{
			if (isset($_POST[$field])) {
				$email_template->$field = $this->form_validation->$field;
			}
		}

		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run())
		{
			if ($email_template->is_default)
			{
				$data = array(
					'subject' => $this->input->post('subject'),
					'body' => $this->input->post('body')
				);
			}
			else
			{
				$data = array(
					'slug' => $this->input->post('slug'),
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'subject' => $this->input->post('subject'),
					'body' => $this->input->post('body'),
					'lang' => $this->input->post('lang')
				);
			}

			if ($this->email_templates_m->update($id, $data))
			{
				// Fire an event. An email template has been updated.
				Events::trigger('email_template_updated', $id);

				$this->session->set_flashdata('success', sprintf(lang('templates:tmpl_edit_success'), $email_template->name));
			}
			else
			{
				$this->session->set_flashdata('error', sprintf(lang('templates:tmpl_edit_error'), $email_template->name));
			}
			redirect('admin/templates');
		}


		$this->template
			->set('email_template', $email_template)
			->title(sprintf(lang('templates:edit_title'), $email_template->name))
			->append_metadata($this->load->view('fragments/wysiwyg', array(), true))
			->append_js('module::form.js')
			->build('admin/form');
	}

	/**
	 * Delete, but we will not allow deletion of default templates
	 *
	 * @param   int $id
	 *
	 * @return  void
	 */
	public function delete($id = 0)
	{
		$ids = $id ? array($id) : $this->input->post('action_to');

		// Delete multiple
		if ($ids)
		{
			$deleted = 0;
			$to_delete = 0;

			foreach ($ids as $id)
			{
				if ($this->email_templates_m->delete($id))
				{
					$deleted++;
				}
				elseif ($this->email_templates_m->is_default($id))
				{
					$this->session->set_flashdata('error', sprintf(lang('templates:default_delete_error'), $id));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('templates:mass_delete_error'), $id));
				}
				$to_delete++;
			}

			if ($deleted > 0)
			{
				if (sizeof($ids) > 1)
				{
					// Fire an event. An email template has been deleted.
					Events::trigger('email_template_deleted', $id);

					$this->session->set_flashdata('success', sprintf(lang('templates:mass_delete_success'), $deleted, $to_delete));
				}
				else
				{
					$this->session->set_flashdata('success', sprintf(lang('templates:single_delete_success')));
				}
			}
		}
		else
		{
			$this->session->set_flashdata('error', $this->lang->line('templates:no_select_error'));
		}

		redirect('admin/templates');
	}

	/**
	 * Preview how your templates may be rendered
	 *
	 * @param bool|int $id
	 *
	 * @return  void
	 */
	public function preview($id = false)
	{
		$email_template = $this->email_templates_m->get($id);

		$this->template
			->set_layout('modal')
			->build('admin/preview', $email_template);
	}

	/**
	 * Takes an existing template as a template.  Usefull for creating a template
	 * for another language
	 *
	 * @param bool|int $id
	 *
	 * @return  void
	 */
	public function create_copy($id = false)
	{
		$id = (int)$id;

		//we will need this later after the form submission
		$copy = $this->email_templates_m->get($id);

		//unset the id and is_default from $copy we don't need or want them anymore
		unset($copy->id);
		unset($copy->is_default);

		//lets get all variations of this template so we can remove the lang options
		$existing = $this->email_templates_m->get_many_by('slug', $copy->slug);

		$lang_options = $this->template->lang_options;

		if ( ! empty($existing))
		{
			foreach ($existing as $tpl)
			{
				unset($lang_options[$tpl->lang]);
			}
		}

		$this->load->library('form_validation');

		$this->form_validation->set_rules($this->_clone_rules);

		if ($this->form_validation->run())
		{
			// insert stuff to db
			$copy->lang = $this->input->post('lang');

			if ($new_id = $this->email_templates_m->insert($copy))
			{
				// Fire the "created" event here also.
				Events::trigger('email_template_created');

				$this->session->set_flashdata('success', sprintf(lang('templates:tmpl_clone_success'), $copy->name));
				redirect('admin/templates/edit/'.$new_id);
			}
			else
			{
				$this->session->set_flashdata('error', sprintf(lang('templates:tmpl_clone_error'), $copy->name));
			}

			redirect('admin/templates');
		}

		$this->template
			->set('lang_options', $lang_options)
			->set('template_name', $copy->name)
			->build('admin/copy');
	}

}
