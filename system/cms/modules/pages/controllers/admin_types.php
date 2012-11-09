<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin controller for the Page Types of the Pages module.
 *
 * @author	PyroCMS Dev Team
 * @package	PyroCMS\Core\Modules\Pages\Controllers
 */
class Admin_types extends Admin_Controller
{
	/**
	 * The current active section
	 *
	 * @var string
	 */
	protected $section = 'types';

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
			'field' => 'stream_slug',
			'label' => 'lang:page_types:select_stream',
			'rules' => 'trim'
		),
		array(
			'field' => 'theme_layout',
			'label' => 'lang:page_types.theme_layout_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'body',
			'label' => 'lang:page_types.body_label',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'css',
			'label' => 'lang:page_types.css_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'js',
			'label' => 'lang:page.js_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'meta_title',
			'label' => 'lang:pages:meta_title_label',
			'rules' => 'trim|max_length[250]'
		),
		array(
			'field'	=> 'meta_keywords',
			'label' => 'lang:pages:meta_keywords_label',
			'rules' => 'trim|max_length[250]'
		),
		array(
			'field'	=> 'meta_description',
			'label'	=> 'lang:pages:meta_description_label',
			'rules'	=> 'trim'
		),
	);

	/**
	 * Constructor method
	 */
	public function __construct()
	{
		// Call the parent's constructor
		parent::__construct();

		$this->load->model('page_type_m');
		$this->lang->load('pages');
		$this->lang->load('page_types');

		// Load the validation library
		$this->load->library('form_validation');

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);
	}


	/**
	 * Index methods, lists all page types
	 */
	public function index()
	{
		// Get all page types
		$this->template->page_types = $this->page_type_m->get_all();

		// Render the view
		$this->template
			->title($this->module_details['name'], lang('pages:type_id_label'))
			->build('admin/types/index');
	}

	/**
	 * Create method, creates a new page type
	 */
	public function create()
	{
		$this->load->model('streams_core/streams_m');

		$data = new stdClass();
		$data->page_type = new stdClass();

		// Got validation?
		if ($this->form_validation->run())
		{
			$input = $this->input->post();

			// they're using an existing stream or we autocreate a slug
			$stream_slug = ($input['stream_slug'] ? $input['stream_slug'] : url_title($input['title'], '_', true));
			
			// check to see if they want us to make a table and then see if we can
			if ( ! $input['stream_slug'] and $this->db->table_exists($stream_slug))
			{
				$this->session->set_flashdata('notice', lang('page_types.already_exist_error'));

				redirect('admin/pages/types/create');
			}
			elseif ( ! $input['stream_slug'])
			{
				// nope, no table conflicts so let's create the stream
				$stream_id = $this->streams->streams->add_stream($input['title'], $stream_slug, 'pages');
			}
			else
			{
				// using an existing stream, get its info
				$stream_id = $this->streams_m->from('data_streams')
					->get_by('stream_slug', $stream_slug)
					->id;
			}

			// Insert the page type
			$id = $this->page_type_m->insert(array(
				'title' 			=> $input['title'],
				'stream_id' 		=> $stream_id,
				'stream_slug' 		=> $stream_slug,
				'meta_title' 		=> $input['meta_title'],
				'meta_keywords' 	=> isset($input['meta_keywords']) ? Keywords::process($input['meta_keywords']) : '',
				'meta_description' 	=> $input['meta_description'],
				'theme_layout' 		=> $input['theme_layout'],
				'body' 				=> ($input['body'] ? $input['body'] : false),
				'css' 				=> $input['css'],
				'js' 				=> $input['js']
			));

			// Success or fail?
			if ($id > 0)
			{
				$this->session->set_flashdata('success', lang('page_types.create_success'));
				
				Events::trigger('page_type_created', $id);
			}
			else {
				$this->session->set_flashdata('notice', lang('page_types.create_error'));
			}

			redirect('admin/pages/types');
		}

		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$data->page_type->{$rule['field']} = set_value($rule['field']);
		}

		$data->page_type->streams = $this->streams_m->from('data_streams')
			->where('stream_namespace !=', 'users')
			->dropdown('stream_slug', 'stream_name');

		$theme_layouts = $this->template->get_theme_layouts($this->settings->default_theme);
		$data->theme_layouts = array();
		foreach ($theme_layouts as $theme_layout)
		{
			$data->theme_layouts[$theme_layout] = basename($theme_layout, '.html');
		}

		// Load WYSIWYG editor
		$this->template
			->title($this->module_details['name'], lang('pages:type_id_label'), lang('page_types.create_title'))
			->build('admin/types/form', $data);
	}

	/**
	 * Edit method, edits an existing page type
	 *
	 * @param int $id The id of the page type.
	 */
	public function edit($id = 0)
	{
		$data = new stdClass();
		empty($id) AND redirect('admin/pages/types');

		// We use this controller property for a validation callback later on
		$this->page_type_id = $id;

		// Set data, if it exists
		if ( ! $data->page_type = $this->page_type_m->get($id))
		{
			$this->session->set_flashdata('error', lang('page_types.page_not_found_error'));
			redirect('admin/pages/types/create');
		}

		// Give validation a try, who knows, it just might work!
		if ($this->form_validation->run())
		{
			$input = $this->input->post();

			// Run the update code with the POST data
			$this->page_type_m->update($id, array(
				'title' 			=> $input['title'],
				'meta_title' 		=> $input['meta_title'],
				'meta_keywords' 	=> isset($input['meta_keywords']) ? Keywords::process($input['meta_keywords']) : '',
				'meta_description' 	=> $input['meta_description'],
				'theme_layout' 		=> $input['theme_layout'],
				'body' 				=> ($input['body'] ? $input['body'] : false),
				'css' 				=> $input['css'],
				'js' 				=> $input['js']
			));

			// Wipe cache for this model as the data has changed
			$this->pyrocache->delete_all('page_type_m');

			$this->session->set_flashdata('success', sprintf(lang('page_types.edit_success'), $this->input->post('title')));
			
			Events::trigger('page_type_updated', $id);

			$this->input->post('btnAction') == 'save_exit'
				? redirect('admin/pages/types')
				: redirect('admin/pages/types/edit/'.$id);
		}

		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			if ($this->input->post($rule['field']))
			{
				$data->page_type->{$rule['field']} = set_value($rule['field']);
			}
		}

		$theme_layouts = $this->template->get_theme_layouts(Settings::get('default_theme'));
		$data->theme_layouts = array();
		foreach ($theme_layouts as $theme_layout)
		{
			$data->theme_layouts[$theme_layout] = basename($theme_layout, '.html');
		}

		$this->template
			->title($this->module_details['name'], lang('pages:type_id_label'), sprintf(lang('page_types.edit_title'), $data->page_type->title))
			->build('admin/types/form', $data);
	}

	/**
	 * Delete a page type
	 *
	 * @param int $id The id of the page type to delete.
	 */
	public function delete($id = 0)
	{
		empty($id) AND redirect('admin/pages/types');

		$ids = ($id) ? array($id) : $this->input->post('action_to');

		// Go through the array of slugs to delete
		foreach ($ids as $id)
		{
			if ($id !== 1)
			{
				// we don't delete the stream because it may be in use elsewhere
				$deleted_ids = $this->page_type_m->delete($id);

				// Wipe cache for this model, the content has changd
				$this->pyrocache->delete_all('page_type_m');
			}

			else
			{
				$this->session->set_flashdata('error', lang('page_types.delete_home_error'));
			}
		}

		// Some pages have been deleted
		if ( ! empty($deleted_ids))
		{
			// Only deleting one page
			if (count($ids) == 1)
			{
				$this->session->set_flashdata('success', sprintf(lang('page_types.delete_success'), $ids[0]));
			}
			else // Deleting multiple pages
			{
				$this->session->set_flashdata('success', sprintf(lang('page_types.mass_delete_success'), count($ids)));
			}
			
			Events::trigger('page_type_deleted', $ids);
		}

		else // For some reason, none of them were deleted
		{
			$this->session->set_flashdata('notice', lang('page_types.delete_none_notice'));
		}

		redirect('admin/pages/types');
	}

}
