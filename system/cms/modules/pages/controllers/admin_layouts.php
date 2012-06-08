<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin controller for the Page Layouts of the Pages module.
 *
 * @author		 Phil Sturgeon
 * @author		 Yorick Peterse
 * @author		PyroCMS Dev Team
 * @package	 PyroCMS\Core\Modules\Pages\Controllers
 */
class Admin_layouts extends Admin_Controller
{
	/**
	 * The current active section
	 *
	 * @var string
	 */
	protected $section = 'layouts';

	/**
	 * Validation rules used by the form_validation library
	 *
	 * @var array
	 */
	private $validation_rules = array(
		array(
			'field' => 'title',
			'label' => 'lang:global:title',
			'rules' => 'trim|required|max_length[60]'
		),
		array(
			'field' => 'theme_layout',
			'label' => 'lang:page_layouts.theme_layout_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'body',
			'label' => 'lang:page_layouts.body_label',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'css',
			'label' => 'lang:page_layouts.css_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'js',
			'label' => 'lang:page.js_label',
			'rules' => 'trim'
		),
	);

	/**
	 * Constructor method
	 */
	public function __construct()
	{
		// Call the parent's constructor
		parent::__construct();

		$this->load->model('page_layouts_m');
		$this->lang->load('pages');
		$this->lang->load('page_layouts');

		// Load the validation library
		$this->load->library('form_validation');

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);
	}


	/**
	 * Index methods, lists all page layouts
	 */
	public function index()
	{
		// Get all page layouts
		$this->template->page_layouts = $this->page_layouts_m->get_all();

		// Render the view
		$this->template
			->title($this->module_details['name'], lang('pages:layout_id_label'))
			->build('admin/layouts/index');
	}

	/**
	 * Create method, creates a new page layout
	 */
	public function create()
	{
		$data = new stdClass();

		// Got validation?
		if ($this->form_validation->run())
		{
			// Insert the page
			$id = $this->page_layouts_m->insert(array(
				'title' => $this->input->post('title'),
				'theme_layout' => $this->input->post('theme_layout'),
				'body' => $this->input->post('body', FALSE),
				'css' => $this->input->post('css'),
				'js' => $this->input->post('js')
			));

			// Success or fail?
			$id > 0
				? $this->session->set_flashdata('success', lang('page_layouts.create_success'))
				: $this->session->set_flashdata('notice', lang('page_layouts.create_error'));

			redirect('admin/pages/layouts');
		}

		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$page_layout->{$rule['field']} = set_value($rule['field']);
		}

		$theme_layouts = $this->template->get_theme_layouts($this->settings->default_theme);
		foreach ($theme_layouts as $theme_layout)
		{
			$data->theme_layouts[$theme_layout] = basename($theme_layout, '.html');
		}

		// Assign data for display
		$this->load->vars(array(
			'page_layout' => &$page_layout
		));

		// Load WYSIWYG editor
		$this->template
			->title($this->module_details['name'], lang('pages:layout_id_label'), lang('page_layouts.create_title'))
			->build('admin/layouts/form', $data);
	}

	/**
	 * Edit method, edits an existing page layout
	 *
	 * @param int $id The id of the page layout.
	 */
	public function edit($id = 0)
	{
		empty($id) AND redirect('admin/pages/layouts');

		// We use this controller property for a validation callback later on
		$this->page_layout_id = $id;

		// Set data, if it exists
		if ( ! $page_layout = $this->page_layouts_m->get($id))
		{
			$this->session->set_flashdata('error', lang('page_layouts.page_not_found_error'));
			redirect('admin/pages/layouts/create');
		}

		// Give validation a try, who knows, it just might work!
		if ($this->form_validation->run())
		{
			// Run the update code with the POST data
			$this->page_layouts_m->update($id, array(
				'title' => $this->input->post('title'),
				'theme_layout' => $this->input->post('theme_layout'),
				'body' => $this->input->post('body', FALSE),
				'css' => $this->input->post('css'),
				'js' => $this->input->post('js')
			));

			// Wipe cache for this model as the data has changed
			$this->pyrocache->delete_all('page_layouts_m');

			$this->session->set_flashdata('success', sprintf(lang('page_layouts.edit_success'), $this->input->post('title')));

			redirect('admin/pages/layouts');
		}

		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			if ($this->input->post($rule['field']))
			{
				$page_layout->{$rule['field']} = set_value($rule['field']);
			}
		}

		$theme_layouts = $this->template->get_theme_layouts($this->settings->default_theme);
		$theme_layouts_options = array();
		foreach ($theme_layouts as $theme_layout)
		{
			$theme_layouts_options[$theme_layout] = basename($theme_layout, '.html');
		}

		$this->template
			->title($this->module_details['name'], lang('pages:layout_id_label'), sprintf(lang('page_layouts.edit_title'), $page_layout->title))
			->set('theme_layouts', $theme_layouts_options)
			->set('page_layout', $page_layout)
			->build('admin/layouts/form');
	}

	/**
	 * Delete a page layout
	 *
	 * @param int $id The id of the page layout to delete.
	 */
	public function delete($id = 0)
	{
		// @todo: Error of no selection not handeled yet.
		$ids = ($id) ? array($id) : $this->input->post('action_to');

		// Go through the array of slugs to delete
		foreach ($ids as $id)
		{
			if ($id !== 1)
			{
				$deleted_ids = $this->page_layouts_m->delete($id);

				// Wipe cache for this model, the content has changd
				$this->pyrocache->delete_all('page_layouts_m');
			}

			else
			{
				$this->session->set_flashdata('error', lang('page_layouts.delete_home_error'));
			}
		}

		// Some pages have been deleted
		if ( ! empty($deleted_ids))
		{
			// Only deleting one page
			if (count($deleted_ids) == 1)
			{
				$this->session->set_flashdata('success', sprintf(lang('page_layouts.delete_success'), $deleted_ids[0]));
			}
			else // Deleting multiple pages
			{
				$this->session->set_flashdata('success', sprintf(lang('page_layouts.mass_delete_success'), count($deleted_ids)));
			}
		}

		else // For some reason, none of them were deleted
		{
			$this->session->set_flashdata('notice', lang('page_layouts.delete_none_notice'));
		}

		redirect('admin/pages/layouts');
	}

}
