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
		$this->load->model('page_m');
		$this->load->model('page_chunk_m');
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
		$root_pages	= isset($data['root_pages']) ? $data['root_pages'] : array();

		if (is_array($order))
		{
			//reset all parent > child relations
			$this->page_m->update_all(array('parent_id' => 0));

			foreach ($order as $i => $page)
			{
				$id = str_replace('page_', '', $page['id']);
				
				//set the order of the root pages
				$this->page_m->update($id, array('order' => $i), true);

				//iterate through children and set their order and parent
				$this->page_m->_set_children($page);
			}

			// rebuild page URIs
			$this->page_m->update_lookup($root_pages);

			$this->pyrocache->delete_all('navigation_m');
			$this->pyrocache->delete_all('page_m');

			Events::trigger('page_ordered', array($order, $root_pages));
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
		$page  = (array)$this->page_m->get($id);

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

        	$page['restricted_to'] = null;
        	$page['navigation_group_id'] = 0;
        
        	foreach($page['chunks'] as $chunk)
        	{
            		$page['chunk_slug'][] = $chunk['slug'];
            		$page['chunk_class'][] = $chunk['class'];
            		$page['chunk_type'][] = $chunk['type'];
            		$page['chunk_body'][] = $chunk['body'];
        	}

		$new_page = $this->page_m->create($page);

		foreach ($children as $child)
		{
			$this->duplicate($child->id, $new_page);
		}

		redirect('admin/pages');
	}

	/**
	 * Create a new page
	 *
	 * @param int $parent_id The id of the parent page.
	 */
	public function create($parent_id = 0)
	{
		$page = new stdClass;

		// did they even submit?
		if ($input = $this->input->post())
		{
			// do they have permission to proceed?
			if ($input['status'] == 'live')
			{
				role_or_die('pages', 'put_live');
			}

			// validate and insert
			if ($id = $this->page_m->create($input))
			{
				Events::trigger('page_created', $id);

				$this->session->set_flashdata('success', lang('pages_create_success'));

				// Redirect back to the form or main page
				$input['btnAction'] == 'save_exit'
					? redirect('admin/pages')
					: redirect('admin/pages/edit/'.$id);
			}
			else
			{
				// validation failed, we must repopulate the chunks form
				$chunk_slugs 	= $this->input->post('chunk_slug') ? array_values($this->input->post('chunk_slug')) : array();
				$chunk_classes 	= $this->input->post('chunk_class') ? array_values($this->input->post('chunk_class')) : array();
				$chunk_bodies 	= $this->input->post('chunk_body') ? array_values($this->input->post('chunk_body')) : array();
				$chunk_types 	= $this->input->post('chunk_type') ? array_values($this->input->post('chunk_type')) : array();

				$chunk_bodies_count = count($input['chunk_body']);
				for ($i = 0; $i < $chunk_bodies_count; $i++)
				{
					$page->chunks[] = array(
						'id' 	=> $i,
						'slug' 	=> ! empty($chunk_slugs[$i]) 	? $chunk_slugs[$i] 	: '',
						'class' => ! empty($chunk_classes[$i]) 	? $chunk_classes[$i] 	: '',
						'type' 	=> ! empty($chunk_types[$i]) 	? $chunk_types[$i] 	: '',
						'body' 	=> ! empty($chunk_bodies[$i]) 	? $chunk_bodies[$i] : '',
					);
				}
			}
		}
		else
		{
			$page->chunks = array(array(
				'id' => 'NEW',
				'slug' => 'default',
				'class' => '',
				'body' => '',
				'type' => 'wysiwyg-advanced',
			));
		}

		// Loop through each rule
		foreach ($this->page_m->fields() as $field)
		{
			if ($field === 'restricted_to[]' or $field === 'strict_uri')
			{
				$page->restricted_to = set_value($field, array('0'));

				// we'll set the default for strict URIs here also
				$page->strict_uri = true;

				continue;
			}

			$page->{$field} = set_value($field);
		}

		$parent_page = new stdClass;

		// If a parent id was passed, fetch the parent details
		if ($parent_id > 0)
		{
			$page->parent_id = $parent_id;
			$parent_page = $this->page_m->get($parent_id);
		}

		// Set some data that both create and edit forms will need
		$this->_form_data();

		// Load WYSIWYG editor
		$this->template
			->title($this->module_details['name'], lang('pages:create_title'))
			->append_metadata($this->load->view('fragments/wysiwyg', array(), true))
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

		// If there's a keywords hash
		if ($page->meta_keywords != '') {
			// Get comma-separated meta_keywords based on keywords hash
			$this->load->model('keywords/keyword_m');
			$old_keywords_hash = $page->meta_keywords;
			$page->meta_keywords = Keywords::get_string($page->meta_keywords);
		}

		// Turn the CSV list back to an array
		$page->restricted_to = explode(',', $page->restricted_to);

		// Got page?
		if ( ! $page OR empty($page))
		{
			// Maybe you would like to create one?
			$this->session->set_flashdata('error', lang('pages_page_not_found_error'));
			redirect('admin/pages/create');
		}

		// did they even submit?
		if ($input = $this->input->post())
		{
			// do they have permission to proceed?
			if ($input['status'] == 'live')
			{
				role_or_die('pages', 'put_live');
			}

			// were there keywords before this update?
			if (isset($old_keywords_hash)) {
				$input['old_keywords_hash'] = $old_keywords_hash;
			}

			// validate and insert
			if ($this->page_m->edit($id, $input))
			{
				$this->session->set_flashdata('success', sprintf(lang('pages_edit_success'), $input['title']));

				Events::trigger('page_updated', $id);

				$this->pyrocache->delete_all('page_m');
				$this->pyrocache->delete_all('navigation_m');

				// Mission accomplished!
				$input['btnAction'] == 'save_exit'
					? redirect('admin/pages')
					: redirect('admin/pages/edit/'.$id);
			}
			else
			{
				// validation failed, we must repopulate the chunks form
				$chunk_slugs 	= $this->input->post('chunk_slug') ? array_values($this->input->post('chunk_slug')) : array();
				$chunk_classes 	= $this->input->post('chunk_class') ? array_values($this->input->post('chunk_class')) : array();
				$chunk_bodies 	= $this->input->post('chunk_body') ? array_values($this->input->post('chunk_body')) : array();
				$chunk_types 	= $this->input->post('chunk_type') ? array_values($this->input->post('chunk_type')) : array();

				$page->chunks = array();
				$chunk_bodies_count = count($input['chunk_body']);
				for ($i = 0; $i < $chunk_bodies_count; $i++)
				{
					$page->chunks[] = array(
						'id' 	=> $i,
						'slug' 	=> ! empty($chunk_slugs[$i]) 	? $chunk_slugs[$i] 	: '',
						'class' => ! empty($chunk_classes[$i]) 	? $chunk_classes[$i] 	: '',
						'type' 	=> ! empty($chunk_types[$i]) 	? $chunk_types[$i] 	: '',
						'body' 	=> ! empty($chunk_bodies[$i]) 	? $chunk_bodies[$i] : '',
					);
				}
			}
		}

		// Loop through each validation rule
		foreach ($this->page_m->fields() as $field)
		{
			// Nothing to do for these two fields.
			if (in_array($field, array('navigation_group_id', 'chunk_body[]')))
			{
				continue;
			}

			// Translate the data of restricted_to to something we can use in the form.
			if ($field === 'restricted_to[]')
			{
				$page->restricted_to = set_value($field, $page->restricted_to);
				$page->restricted_to[0] = ($page->restricted_to[0] == '') ? '0' : $page->restricted_to[0];
				continue;
			}

			// Set all the other fields
			$page->{$field} = set_value($field, $page->{$field});
		}

		// If this page has a parent.
		if ($page->parent_id > 0)
		{
			// Get only the details for the parent, no chunks.
			$parent_page = $this->page_m->get($page->parent_id, false);
		}
		else
		{
			$parent_page = false;
		}

		$this->_form_data();

		$this->template
			->title($this->module_details['name'], sprintf(lang('pages:edit_title'), $page->title))
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
				Events::trigger('page_deleted', $deleted_ids);

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
}