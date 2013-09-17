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

	// --------------------------------------------------------------------------

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
			'field' => 'slug',
			'label' => 'lang:global:slug',
			'rules' => 'trim|required|alpha_dot_dash|max_length[60]|callback__check_pt_slug'
		),
        array(
             'field' => 'description',
             'label' => 'lang:global:description',
             'rules' => 'trim'
        ),
		array(
			'field' => 'stream_id',
			'label' => 'lang:page_types:select_stream',
			'rules' => 'trim|required'
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
		array(
			'field'	=> 'content_label',
			'label' => 'lang:page_types:content_label',
			'rules' => 'trim|max_length[60]'
		),
		array(
			'field'	=> 'title_label',
			'label'	=> 'lang:page_types:title_label',
			'rules'	=> 'trim|max_length[100]'
		)
	);

	// --------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();

		$this->load->model('page_type_m');
		$this->lang->load('pages');
		$this->lang->load('page_types');

		$this->load->library('form_validation');

		$this->load->driver('Streams');

		// Get our chunks field type if this is an
		// upgraded site.
		if ($this->db->table_exists('page_chunks'))
		{
			$this->type->load_types_from_folder(APPPATH.'modules/pages/field_types/', 'pages_module');
		}
	}

	// --------------------------------------------------------------------------

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

	// --------------------------------------------------------------------------

	/**
	 * Create method, creates a new page type
	 */
	public function create()
	{
		role_or_die('pages', 'create_types');

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);

		// Set page_type_m so we can use the page_type_m
		// validation callbacks
		$this->form_validation->set_model('page_type_m');

		$data = new stdClass();
		$data->page_type = new stdClass();

		if ($this->form_validation->run())
		{
			$input = $this->input->post();

			// they're using an existing stream or we autocreate a slug
			if ($input['stream_id'] == 0)
			{
				$stream_slug = url_title($input['title'], '_', true);

				// check to see if they want us to make a table and then see if we can
				if ( ! $stream_slug and $this->db->table_exists($stream_slug))
				{
					$this->session->set_flashdata('notice', lang('page_types:already_exist_error'));
					redirect('admin/pages/types/create');
				}
				else
				{
					// nope, no table conflicts so let's create the stream
				}
			}

			// If they've indicated we create a new stream
			if ($input['stream_id'] == 'new')
			{
				// Since this an automatically generated stream, we're not going to
				// worry about auto-generating a slug as long as it doesn't conflict.
				// We'll just append incrementing numbers to it until we get closer.
				// Plus, we are using the pages_ prefix, so conflict probability is low.
				$stream_slug = ($input['slug'] ? $input['slug'] : url_title($input['title'], '_', true));
				$original_stream_slug = $stream_slug;
				$count = 2;
				while ($this->streams->streams->check_table_exists($stream_slug, 'pages_'))
				{
					$stream_slug = $original_stream_slug.'_'.$count;
					$count++;
				}

				$input['stream_id'] = $this->streams->streams->add_stream(lang('page_types:list_title_sing').' '.$input['title'], $stream_slug, 'pages', 'pages_');
			}

			// Insert the page type
			$id = $this->page_type_m->insert(array(
				'title' 			=> $input['title'],
				'slug'				=> $input['slug'],
				'description'       => $input['description'],
				'stream_id' 		=> $input['stream_id'],
				'meta_title' 		=> isset($input['meta_title']) ? $input['meta_title'] : null,
				//'meta_keywords' 	=> isset($input['meta_keywords']) ? $this->keywords->process($input['meta_keywords']) : '',
				'meta_description' 	=> isset($input['meta_description']) ? $input['meta_description'] : null,
				'theme_layout' 		=> $input['theme_layout'],
				'body' 				=> ($input['body'] ? $input['body'] : false),
				'css' 				=> $input['css'],
				'js' 				=> $input['js'],
				'content_label'		=> $this->input->post('content_label'),
				'title_label'		=> $this->input->post('title_label'),
				'save_as_files'		=> (isset($input['save_as_files']) and $input['save_as_files'] == 'y') ? 'y' : 'n'
			));


			// Success or fail?
			if ($id > 0)
			{
				// Should we create some files?
				if ($this->input->post('save_as_files') == 'y')
				{
					$this->page_type_m->place_page_layout_files($input);
				}

				$this->session->set_flashdata('success', lang('page_types:create_success'));

				// Empty the correct caches.
				$this->pyrocache->delete_all('page_m');
				$this->pyrocache->delete_all('page_type_m');
				$this->pyrocache->delete_all('streams_m');

				// Event: page_type_created
				Events::trigger('page_type_created', $id);

				if ($this->input->post('stream_id') == 'new')
				{
					$this->session->set_flashdata('success', lang('page_types:create_success_add_fields'));

					// send them off to create their first fields
					redirect('admin/pages/types/fields/' . $id);
				}
			}
			else
			{
				$this->session->set_flashdata('notice', lang('page_types:create_error'));
			}

			redirect('admin/pages/types');
		}

		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$data->page_type->{$rule['field']} = set_value($rule['field']);
		}

		// Extra one for the "save as files" checkbox.
		$data->page_type->save_as_files = ($this->input->post('save_as_files') == 'y') ? 'y' : false;

		// Streams dropdown data.
		$data->streams_dropdown = $this->get_stream_dropdown_list();

		// Theme layouts dropdown data.
		$theme_layouts = $this->template->get_theme_layouts($this->settings->default_theme);
		$data->theme_layouts = array();
		foreach ($theme_layouts as $theme_layout)
		{
			$data->theme_layouts[$theme_layout] = basename($theme_layout, '.html');
		}

		// Load WYSIWYG editor
		$this->template
			->title($this->module_details['name'], lang('pages:type_id_label'), lang('page_types:create_title'))
			->append_js('module::page_type_form.js')
			->build('admin/types/form', $data);
	}

	// --------------------------------------------------------------------------

	/**
	 * Create a dropdown array that can be used
	 * to choose an appropriate stream. These are
	 * separated by namespace.
	 *
	 * @access 	private
	 * @return 	array
	 */
	private function get_stream_dropdown_list()
	{
		$choices = array();

		// Now get our streams and add them
		// under their namespace
		$streams = $this->db
							->where('stream_namespace !=', 'users')
							->select('id, stream_name, stream_namespace')->get(STREAMS_TABLE)->result();

		foreach ($streams as $stream)
		{
			if ($stream->stream_namespace)
			{
				$choices[ucfirst($stream->stream_namespace)][$stream->id] = $stream->stream_name;
			}
		}

		return $choices;
	}

	// --------------------------------------------------------------------------

	/**
	 * Edit method, edits an existing page type
	 *
	 * @param int $id The id of the page type.
	 */
	public function edit($id = 0)
	{
		role_or_die('pages', 'edit_types');

		// Unset validation rules of required fields that are not included in the edit form
		unset($this->validation_rules[1]);
		unset($this->validation_rules[3]);

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);

		$data = new stdClass();
		empty($id) AND redirect('admin/pages/types');

		// We use this controller property for a validation callback later on
		$this->page_type_id = $id;

		// Set data, if it exists
		if ( ! $data->page_type = $this->page_type_m->get($id))
		{
			$this->session->set_flashdata('error', lang('page_types:page_not_found_error'));
			redirect('admin/pages/types/create');
		}

		// Give validation a try, who knows, it just might work!
		if ($this->form_validation->run())
		{
			$input = $this->input->post();

			// Run the update code with the POST data
			$this->page_type_m->update($id, array(
				'title' 			=> $input['title'],
				'description'       => $input['description'],
				'meta_title' 		=> isset($input['meta_title']) ? $input['meta_title'] : null,
				//'meta_keywords' 	=> isset($input['meta_keywords']) ? Keywords::process($input['meta_keywords']) : '',
				'meta_description' 	=> isset($input['meta_description']) ? $input['meta_description'] : null,
				'theme_layout' 		=> $input['theme_layout'],
				'body' 				=> ($input['body'] ? $input['body'] : false),
				'css' 				=> $input['css'],
				'js' 				=> $input['js'],
				'content_label'		=> $this->input->post('content_label'),
				'title_label'		=> $this->input->post('title_label'),
				'save_as_files'		=> (isset($input['save_as_files']) and $input['save_as_files'] == 'y') ? 'y' : 'n'
			));

			// Wipe cache for the correct models as the data has changed
			$this->pyrocache->delete_all('page_type_m');
			$this->pyrocache->delete_all('page_m');
			$this->pyrocache->delete_all('streams_m');

			$this->session->set_flashdata('success', sprintf(lang('page_types:edit_success'), $this->input->post('title')));

			$input['slug'] = $data->page_type->slug;
			if ($this->input->post('save_as_files') == 'y')
			{
				$this->page_type_m->place_page_layout_files($input);
			}
			else
			{
				$this->page_type_m->remove_page_layout_files($input['slug']);
			}

			$this->pyrocache->delete_all('page_m');

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

		// Save as files.
		$data->page_type->save_as_files = ($data->page_type->save_as_files == 'y' or $this->input->post('save_as_files') == 'y') ? 'y' : false;

		$theme_layouts = $this->template->get_theme_layouts(Settings::get('default_theme'));
		$data->theme_layouts = array();
		foreach ($theme_layouts as $theme_layout)
		{
			$data->theme_layouts[$theme_layout] = basename($theme_layout, '.html');
		}

		$this->template
			->title($this->module_details['name'], lang('pages:type_id_label'), sprintf(lang('page_types:edit_title'), $data->page_type->title))
			->append_js('module::page_type_form.js')
			->build('admin/types/form', $data);
	}

	// --------------------------------------------------------------------------

	/**
	 * Edit Fields for a certain page type.
	 *
	 * @access 	public
	 * @return 	void
	 */
	public function fields()
	{
		$page_type = $this->_check_page_type();

		// Get the stream that we are using for this page type.
		$stream = $this->db->limit(1)->where('id', $page_type->stream_id)->get('data_streams')->row();

		$this->load->driver('Streams');

		// If we are adding a field, show the field form.
		if ($this->uri->segment(6) == 'new_field')
		{
			return $this->_new_field($stream, $page_type);
		}
		elseif ($this->uri->segment(6) == 'edit_field')
		{
			return $this->_edit_field($stream, $page_type);
		}
		elseif ($this->uri->segment(6) == 'delete_field')
		{
			return $this->_delete_field($stream);
		}

		$extra = array(
			'add_uri'		=> 'admin/pages/types/fields/'.$page_type->id.'/new_field',
			'title'			=> $stream->stream_name.' '.lang('global:fields')
		);

		// Our buttons.
		$extra['buttons'] = array(
			array(
				'label'     => lang('global:edit'),
				'url'       => 'admin/pages/types/fields/'.$this->uri->segment(5).'/edit_field/-assign_id-'
			),
			array(
				'label'     => lang('global:delete'),
				'url'       => 'admin/pages/types/fields/'.$this->uri->segment(5).'/delete_field/-assign_id-',
				'confirm'   => true,
			)
		);


		// Show our fields list.
		$this->streams->cp->assignments_table($stream->stream_slug, $stream->stream_namespace, Settings::get('records_per_page'), 'admin/pages/types/fields/'.$page_type->id, true, $extra);
	}

	// --------------------------------------------------------------------------

	/**
	 * Sync page files for a certain page type.
	 *
	 * @access 	public
	 * @return 	void
	 */
	public function sync()
	{
		$page_type = $this->_check_page_type();

 		$folder = FCPATH.'assets/page_types/'.SITE_REF.'/'.$page_type->slug.'/'.$page_type->slug.'.';

 		$update_data = array();

 		$this->load->helper('file');

 		if (is_file($folder.'html')) $update_data['body'] = read_file($folder.'html');
  		if (is_file($folder.'js')) $update_data['js'] = read_file($folder.'js');
 		if (is_file($folder.'css')) $update_data['css'] = read_file($folder.'css');

 		if ($update_data)
 		{
 			$this->page_type_m->update_by('id', $page_type->id, $update_data);
 		}

 		if (count($update_data) < 3)
 		{
 			if (count($update_data) != 0)
 			{
				$this->session->set_flashdata('notice', sprintf(lang('page_types:sync_notice'), implode(', ', $update_data)));
 			}
 			else
 			{
				$this->session->set_flashdata('error', lang('page_types:sync_fail'));
 			}
 		}
 		else
 		{
			$this->session->set_flashdata('success', lang('page_types:sync_success'));
			$this->pyrocache->delete_all('page_m');
			Events::trigger('page_type_updated', $page_type->id);
 		}

 		redirect('admin/pages/types');
	}

	// --------------------------------------------------------------------------

	/**
	 * Check Page Type
	 *
	 * Used for any controller function that needs to make sure they
	 * have a valid page type in a segment.
	 *
	 * @access 	private
	 * @param 	int
	 * @return 	void or page type obj
	 */
	private function _check_page_type($segment = 5)
	{
		if ( ! $page_type_id = $this->uri->segment($segment)) show_404();

		// Get the page type.
		$page_type = $this->db->limit(1)->where('id', $page_type_id)->get('page_types')->row();

		if ( ! $page_type) show_404();

		return $page_type;
	}

	// --------------------------------------------------------------------------

	/**
	 * Edit Fields for a certain page type.
	 *
	 */
	private function _new_field($stream, $page_type)
	{
		$extra = array(
			'title'					 => $stream->stream_name.' : '.lang('streams:new_field'),
			'success_message' 		 => lang('page_types:success_add_tag'),
			'cancel_uri'			 => 'admin/pages/types/fields/'.$page_type->id,
			'allow_title_column_set' => true
		);

		$this->streams->cp->field_form($stream->stream_slug, $stream->stream_namespace, 'new', 'admin/pages/types/fields/'.$this->uri->segment(5), null, array(), true, $extra, array('chunks'));
	}

	// --------------------------------------------------------------------------

	/**
	 * Edit Fields for a certain page type.
	 *
	 */
	private function _edit_field($stream, $page_type)
	{
		$extra = array(
			'title'						=> $stream->stream_name.' : '.lang('streams:edit_field'),
			'success_message' 			=> lang('page_types:success_add_tag'),
			'cancel_uri'				=> 'admin/pages/types/fields/'.$page_type->id,
			'allow_title_column_set' 	=> true
		);

		$this->streams->cp->field_form($stream->stream_slug, $stream->stream_namespace, 'edit', 'admin/pages/types/fields/'.$this->uri->segment(5), $this->uri->segment(7), array(), true, $extra, array('chunks'));
	}

	// --------------------------------------------------------------------------

	/**
	 * Edit Fields for a certain page type.
	 *
	 */
	private function _delete_field($stream)
	{
		$this->streams->cp->teardown_assignment_field($this->uri->segment(7));

		redirect('admin/pages/types/fields/'.$this->uri->segment(5));
	}

	// --------------------------------------------------------------------------

	/**
	 * Delete a page type
	 *
	 * @param int $id The id of the page type to delete.
	 */
	public function delete($id = 0)
	{
		role_or_die('pages', 'delete_types');

		empty($id) and redirect('admin/pages/types');

		$page_type = $this->page_type_m->get($id);

		// if the page type doesn't exist or if they somehow bypassed 
		// our front-end checks and are deleting 'default' directly
		if ( ! $page_type or $page_type->slug === 'default') show_error('Invalid ID');

		// Will we be neededing to delete a stream as well?
		// We will only be deleting a stream if:
		// - It is in the pages namespace
		// - It is not being used by any other page types
		// Even then, we will have warned them.
		$delete_stream = false;

		$this->load->driver('Streams');
		$stream = $this->streams_m->get_stream($page_type->stream_id);

		if ($stream->stream_namespace == 'pages')
		{
			// Are any other page types using this?
			if ($this->page_type_m->count_by('stream_id', $page_type->stream_id) <= 1)
			{
				$delete_stream = true;
			}
		}

		if ($this->input->post('do_delete') == 'y')
		{

			// Delete page
			$this->page_type_m->delete($id, $delete_stream);

			// Guess what, we have to delete ALL the pages using this
			// page type. This is necessary since the data for that page
			// type in streams and elsewhere is essentially useless.
			$pages = $this->db->where('type_id', $id)->get('pages')->result();

			foreach ($pages as $page)
			{
				$this->page_m->delete($page->id);
			}

			// Wipe cache for this model, the content has changd
			$this->pyrocache->delete_all('page_type_m');

			$this->session->set_flashdata('success', sprintf(lang('page_types:delete_success'), $id));

			Events::trigger('page_type_deleted', $id);

			redirect('admin/pages/types');
		}

		// Count number of pages that will be deleted.
		$this->template->set('num_of_pages', $this->page_m->count_by('type_id', $page_type->id));

		$this->template
			->title($this->module_details['name'])
			->set('delete_stream', $delete_stream)
			->set('stream_name', $stream->stream_name)
			->build('admin/types/delete_form');
	}

}
