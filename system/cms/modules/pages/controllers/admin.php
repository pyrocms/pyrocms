<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Pages controller
 *
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Pages\Controllers
 */
class Admin extends Admin_Controller {

	/**
	 * The current active section
	 *
	 * @var string
	 */
	protected $section = 'pages';

	/**
	 * Array containing the validation rules
	 *
	 * @var array
	 */
	private $validation_rules = array(
		array(
			'field' => 'title',
			'label' => 'lang:pages.title_label',
			'rules' => 'trim|required|max_length[250]'
		),
		'slug' => array(
			'field' => 'slug',
			'label' => 'lang:pages.slug_label',
			'rules' => 'trim|required|alpha_dot_dash|max_length[250]|callback__check_slug'
		),
		array(
			'field' => 'chunk_body[]',
			'label' => 'lang:pages.body_label',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'layout_id',
			'label' => 'lang:pages.layout_id_label',
			'rules' => 'trim|numeric|required'
		),
		array(
			'field' => 'css',
			'label' => 'lang:pages.css_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'js',
			'label' => 'lang:pages.js_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'meta_title',
			'label' => 'lang:pages.meta_title_label',
			'rules' => 'trim|max_length[250]'
		),
		array(
			'field' => 'meta_keywords',
			'label' => 'lang:pages.meta_keywords_label',
			'rules' => 'trim|max_length[250]'
		),
		array(
			'field' => 'meta_description',
			'label' => 'lang:pages.meta_description_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'restricted_to[]',
			'label' => 'lang:pages.access_label',
			'rules' => 'trim|numeric|required'
		),
		array(
			'field' => 'rss_enabled',
			'label' => 'lang:pages.rss_enabled_label',
			'rules' => 'trim|numeric'
		),
		array(
			'field' => 'comments_enabled',
			'label' => 'lang:pages.comments_enabled_label',
			'rules' => 'trim|numeric'
		),
		array(
			'field' => 'strict_uri',
			'label' => 'lang:pages.strict_uri_label',
			'rules' => 'trim|numeric'
		),
		array(
			'field' => 'is_home',
			'label' => 'lang:pages.is_home_label',
			'rules' => 'trim|numeric'
		),
		array(
			'field' => 'status',
			'label' => 'lang:pages.status_label',
			'rules' => 'trim|alpha|required'
		),
		array(
			'field' => 'navigation_group_id',
			'label' => 'lang:pages.navigation_label',
			'rules' => 'numeric'
		)
	);

	/**
	 * Constructor method
	 *
	 * Loads the form_validation library, the pages, pages layout
	 * and navigation models along with the language for the pages
	 * module.
	 */
	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->library('form_validation');

		$this->load->model('page_m');
		$this->load->model('page_layouts_m');
		$this->load->model('navigation/navigation_m');
		$this->lang->load('pages');
	}

	/**
	 * Index methods, lists all pages
	 */
	public function index()
	{

		$this->template

			->title($this->module_details['name'])

			->append_js('jquery/jquery.ui.nestedSortable.js')
			->append_js('jquery/jquery.cooki.js')
			->append_js('jquery/jquery.stickyscroll.js')
			->append_js('module::index.js')

			->append_css('module::index.css')

			->set('pages', $this->page_m->get_page_tree())
			->build('admin/index');
	}

	/**
	 * Order the pages and record their children
	 *
	 * Grabs `order` and `data` from the POST data.
	 */
	public function order()
	{
		$order	= $this->input->post('order');
		$data	= $this->input->post('data');
		$root_pages	= (isset($data['root_pages'])) ? $data['root_pages'] : array();

		if (is_array($order))
		{
			//reset all parent > child relations
			$this->page_m->update_all(array('parent_id' => 0));

			foreach ($order as $i => $page)
			{
				//set the order of the root pages
				$this->page_m->update_by('id', str_replace('page_', '', $page['id']), array('order' => $i));

				//iterate through children and set their order and parent
				$this->page_m->_set_children($page);
			}

			// rebuild page URIs
			$this->page_m->update_lookup($root_pages);

			$this->pyrocache->delete_all('navigation_m');
			$this->pyrocache->delete_all('page_m');

			Events::trigger('post_page_order', array($order, $root_pages));
		}
	}

	/**
	 * Get the details of a page.
	 *
	 * @param int $id The id of the page.
	 */
	public function ajax_page_details($id)
	{
		$page = $this->page_m->get($id);

		$this->load->view('admin/ajax/page_details', array('page' => $page));
	}

	/**
	 * Show a page preview
	 *
	 * @param int $id The id of the page.
	 */
	public function preview($id = 0)
	{
		$this->template
			->set_layout('modal', 'admin')
			->build('admin/preview', array('page' => $this->page_m->get($id)));
	}

	/**
	 * Duplicate a page
	 *
	 * @param int $id The ID of the page
	 * @param null $parent_id The ID of the parent page, if this is a recursive nested duplication
	 */
	public function duplicate($id, $parent_id = null)
	{
		$page  = $this->page_m->get($id);

		// Steal their children
		$children = $this->page_m->get_many_by('parent_id', $id);

		$new_slug = $page['slug'];

		// No parent around? Do what you like
		if (is_null($parent_id))
		{
			do
			{
				// Turn "Foo" into "Foo 2"
				$page['title'] = increment_string($page['title'], ' ', 2);

				// Turn "foo" into "foo-2"
				$page['slug'] = increment_string($page['slug'], '-', 2);

				// Find if this already exists in this level
				$dupes = $this->page_m->count_by(array(
					'slug' => $page['slug'],
					'parent_id' => $page['parent_id'],
				));
			}
			while ($dupes > 0);
		}

		// Oop, a parent turned up, work with that
		else
		{
			$page['parent_id'] = $parent_id;
		}

		$chunks = $this->db->get_where('page_chunks', array('page_id' => $page['id']))->result();

		$new_page_id = $this->page_m->insert($page, $chunks);

		foreach ($children as $child)
		{
			$this->duplicate($child->id, $new_page_id);
		}

		if ($parent_id === NULL)
		{
			redirect('admin/pages/edit/'.$new_page_id);
		}
	}

	/**
	 * Create a new page
	 *
	 * @param int $parent_id The id of the parent page.
	 */
	public function create($parent_id = 0)
	{

		$page['chunks'] = array(array(
			'id' => 'NEW',
			'slug' => 'default',
			'body' => '',
			'type' => 'wysiwyg-advanced',
		));

		if ($_POST)
		{
			$page['chunks'] = array();

			$chunk_slugs = ($this->input->post('chunk_slug')) ? array_values($this->input->post('chunk_slug')) : array();
			$chunk_bodies = ($this->input->post('chunk_body')) ? array_values($this->input->post('chunk_body')) : array();
			$chunk_types = ($this->input->post('chunk_type')) ? array_values($this->input->post('chunk_type')) : array();

			$chunk_bodies_count = count($this->input->post('chunk_body'));

			for ($i = 0; $i < $chunk_bodies_count; $i++)
			{
				$page['chunks'][] = array(
					'id' => $i,
					'slug' => ( ! empty($chunk_slugs[$i])) ? $chunk_slugs[$i] : '',
					'type' => ( ! empty($chunk_types[$i])) ? $chunk_types[$i] : '',
					'body' => ( ! empty($chunk_bodies[$i])) ? $chunk_bodies[$i] : '',
				);
			}

			$this->form_validation->set_rules($this->validation_rules);

			// Validate the page
			if ($this->form_validation->run())
			{
				$input = $this->input->post();

				if ($input['status'] == 'live')
				{
					role_or_die('pages', 'put_live');
				}

				// First create the page
				$nav_group_id = $input['navigation_group_id'];
				unset($input['navigation_group_id']);

				if ($id = $this->page_m->insert($input, $page['chunks']))
				{
					$input['restricted_to'] = isset($input['restricted_to']) ? implode(',', $input['restricted_to']) : '0';

					// Add a Navigation Link
					if ($nav_group_id)
					{
						$this->load->model('navigation/navigation_m');
						$this->navigation_m->insert_link(array(
							'title' => $input['title'],
							'link_type' => 'page',
							'page_id' => $id,
							'navigation_group_id' => (int)$nav_group_id
						));
					}

					if ($this->page_m->update($id, $input))
					{
						Events::trigger('post_page_create', $input);

						$this->session->set_flashdata('success', lang('pages_create_success'));

						// Redirect back to the form or main page
						$this->input->post('btnAction') == 'save_exit'
							? redirect('admin/pages')
							: redirect('admin/pages/edit/'.$id);
					}
				}

				// Fail
				else
				{
					$this->session->set_flashdata('notice', lang('pages_create_error'));
				}
			}
		}

		// Loop through each rule
		foreach ($this->validation_rules as $rule)
		{
			if ($rule['field'] === 'restricted_to[]')
			{
				$page['restricted_to'] = set_value($rule['field'], array('0'));

				continue;
			}

			$page[$rule['field']] = set_value($rule['field']);
		}

		$parent_page = array();
		// If a parent id was passed, fetch the parent details
		if ($parent_id > 0)
		{
			$page['parent_id'] = $parent_id;
			$parent_page = $this->page_m->get($parent_id);
		}

		// Set some data that both create and edit forms will need
		$this->_form_data();

		// Load WYSIWYG editor
		$this->template

			->title($this->module_details['name'], lang('pages.create_title'))

			->append_metadata($this->load->view('fragments/wysiwyg', array(), true))

			// Assign data for display
			->set('page', $page)
			->set('parent_page', $parent_page)

			->build('admin/form');
	}

	/**
	 * Edit an existing page
	 *
	 * @param int $id The id of the page.
	 */
	public function edit($id = 0)
	{
		// We are lost without an id. Redirect to the pages index.
		$id OR redirect('admin/pages');

		// The user needs to be able to edit pages.
		role_or_die('pages', 'edit_live');

		// Retrieve the page data along with its chunk data as an array.
		$page = $this->page_m->get($id);

		// Got page?
		if ( ! $page OR empty($page))
		{
			// Maybe you would like to create one?
			$this->session->set_flashdata('error', lang('pages_page_not_found_error'));
			redirect('admin/pages/create');
		}

		// Set the page ID and get the current page
		$this->page_id = $page['id'];

		// It's stored as a CSV list
		$page['restricted_to'] = explode(',', $page['restricted_to']);

		// If the page has been edited.
		if ($_POST)
		{
			// The page chunks are going to be replaced by the new input data.
			$page['chunks'] = array();

			$chunk_slugs = ($this->input->post('chunk_slug')) ? array_values($this->input->post('chunk_slug')) : array();
			$chunk_bodies = ($this->input->post('chunk_body')) ? array_values($this->input->post('chunk_body')) : array();
			$chunk_types = ($this->input->post('chunk_type')) ? array_values($this->input->post('chunk_type')) : array();

			// Just so that we do not count() for every iteration.
			$chunk_slugs_count = count($chunk_slugs);

			// For each of the chunks passed.
			for ($i = 0; $i < $chunk_slugs_count; $i++)
			{
				// Nothing in here?
				if (empty($chunk_slugs[$i]) and ! strip_tags($chunk_bodies[$i]))
				{
					continue;
				}

				// Strip PHP from chunk body
				$chunk_bodies[$i] = str_replace(array('<?', '?>'), array('&lt;?', '?&gt;'), $chunk_bodies[$i]);

				// Store the data for this chunk.
				$page['chunks'][] = array(
					'id' => $i,
					'slug' => ( ! empty($chunk_slugs[$i])) ? $chunk_slugs[$i] : '',
					'type' => ( ! empty($chunk_types[$i])) ? $chunk_types[$i] : '',
					'body' => ( ! empty($chunk_bodies[$i])) ? $chunk_bodies[$i] : '',
				);
			}

			// Set a rule for the slug field.
			$this->form_validation->set_rules(array_merge($this->validation_rules, array(
				'slug' => array(
					'field' => 'slug',
					'label'	=> 'lang:pages.slug_label',
					'rules'	=> 'trim|required|alpha_dot_dash|max_length[250]|callback__check_slug['.$id.']'
				)
			)));

			// if the validation is succesful.
			if ($this->form_validation->run())
			{
				// Get all the POST data.
				$input = $this->input->post();

				// If the page is set to live, the user must have the ability to do that.
				if ($page['status'] != 'live' and $input['status'] == 'live')
				{
					// No? too bad.
					role_or_die('pages', 'put_live');
				}

				// The restricted_to column stores comma separated values.
				$input['restricted_to'] = (isset($input['restricted_to'])) ? implode(',', $input['restricted_to']) : '0';

				// Run the update code with the POST data
				$this->page_m->update($id, $input, $page['chunks']);

				// The slug has changed
				if ($this->input->post('slug') != $this->input->post('old_slug'))
				{
					$this->page_m->reindex_descendants($id);
				}

				// The page has been edited. Tell everybody.
				Events::trigger('post_page_edit', $input);

				// Set the flashdata message and redirect the user
				$link = anchor('admin/pages/preview/'.$id, $this->input->post('title'), 'class="modal-large"');
				$this->session->set_flashdata('success', sprintf(lang('pages_edit_success'), $link));

				// Redirect back to the form or main page
				$this->input->post('btnAction') == 'save_exit'
					? redirect('admin/pages')
					: redirect('admin/pages/edit/'.$id);
			}
		}

		// Now lets go ahead and populate the form
		// by looping through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			// Nothing to do for these two fields.
			if (in_array($rule['field'], array('navigation_group_id', 'chunk_body[]')))
			{
				continue;
			}

			// Translate the data of restricted_to to something we can use in the form.
			if ($rule['field'] === 'restricted_to[]')
			{
				$page['restricted_to'] = set_value($rule['field'], $page['restricted_to']);
				$page['restricted_to'][0] = ($page['restricted_to'][0] == '') ? '0' : $page['restricted_to'][0];
				continue;
			}

			// Pour in everything else.
			$page[$rule['field']] = set_value($rule['field'], $page[$rule['field']]);
		}

		// If this page has a parent.
		if ($page['parent_id'] > 0)
		{
			// Get only the details for the parent, no chunks.
			$parent_page = $this->page_m->get($page['parent_id'], false);
		}
		else
		{
			$parent_page = false;
		}

		$this->_form_data();

		$this->template

			->title($this->module_details['name'], sprintf(lang('pages.edit_title'), $page['title']))

			// Load WYSIWYG Editor
			->append_metadata( $this->load->view('fragments/wysiwyg', array() , true) )
			->append_css('module::page-edit.css')

			->set('page', $page)
			->set('parent_page', $parent_page)

			->build('admin/form');
	}

	/**
	 * Sets up common form inputs.
	 *
	 * This is used in both the creation and editing forms.
	 */
	private function _form_data()
	{
		$page_layouts = $this->page_layouts_m->get_all();
		$this->template->page_layouts = array_for_select($page_layouts, 'id', 'title');

		// Load navigation list
		$this->load->model('navigation/navigation_m');
		$navigation_groups = $this->navigation_m->get_groups();
		$this->template->navigation_groups = array_for_select($navigation_groups, 'id', 'title');

		$this->load->model('groups/group_m');
		$groups = $this->group_m->get_all();
		foreach ($groups as $group)
		{
			$group->name !== 'admin' && $group_options[$group->id] = $group->name;
		}
		$this->template->group_options = $group_options;

		$this->template
			->append_js('jquery/jquery.tagsinput.js')
			->append_js('jquery/jquery.cooki.js')
			->append_js('module::form.js')
			->append_css('jquery/jquery.tagsinput.css');
	}

	/**
	 * Delete a page.
	 *
	 * @param int $id The id of the page to delete.
	 */
	public function delete($id = 0)
	{
		$this->load->model('comments/comments_m');

		// The user needs to be able to delete pages.
		role_or_die('pages', 'delete_live');

		// @todo Error of no selection not handled yet.
		$ids = ($id) ? array($id) : $this->input->post('action_to');

		// Go through the array of slugs to delete
		if ( ! empty($ids))
		{
			foreach ($ids as $id)
			{
				if ($id !== 1)
				{
					$deleted_ids = $this->page_m->delete($id);

					$this->comments_m->where('module', 'pages')->delete_by('module_id', $id);

					// Wipe cache for this model, the content has changd
					$this->pyrocache->delete_all('page_m');
					$this->pyrocache->delete_all('navigation_m');
				}
				else
				{
					$this->session->set_flashdata('error', lang('pages_delete_home_error'));
				}
			}

			// Some pages have been deleted
			if ( ! empty($deleted_ids))
			{
				Events::trigger('post_page_delete', $deleted_ids);

				// Only deleting one page
				if ( count($deleted_ids) == 1 )
				{
					$this->session->set_flashdata('success', sprintf(lang('pages_delete_success'), $deleted_ids[0]));
				}
				// Deleting multiple pages
				else
				{
					$this->session->set_flashdata('success', sprintf(lang('pages_mass_delete_success'), count($deleted_ids)));
				}
			}
			// For some reason, none of them were deleted
			else
			{
				$this->session->set_flashdata('notice', lang('pages_delete_none_notice'));
			}
		}

		redirect('admin/pages');
	}

	/**
	 * Callback to check uniqueness of slug + parent
	 *
	 * @param string $slug The slug to check
	 * @param null|int $page_id The page id to check for.
	 * @return bool
	 */
	 public function _check_slug($slug, $page_id = null)
	 {
		if ($this->page_m->check_slug($slug, $this->input->post('parent_id'), (int) $page_id))
		{
			if ($this->input->post('parent_id') == 0)
			{
				$parent_folder = lang('pages_root_folder');
				$url = '/'.$slug;
			}
			else
			{
				$page_obj = $this->page_m->get($page_id);
				$url = '/'.trim(dirname($page_obj->uri),'.').$slug;
				$page_obj = $this->page_m->get($this->input->post('parent_id'));
				$parent_folder = $page_obj->title;
			}

			$this->form_validation->set_message('_check_slug',sprintf(lang('pages_page_already_exist_error'),$url, $parent_folder));
			return false;
		}

		// We check the page chunk slug length here too
		if (is_array($this->input->post('chunk_slug')))
		{
			foreach ($this->input->post('chunk_slug') AS $chunk)
			{
				if (strlen($chunk) > 30)
				{
					$this->form_validation->set_message('_check_slug', lang('pages_chunk_slug_length'));
					return false;
				}
			}
			return true;
		}
	}
}