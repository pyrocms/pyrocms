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
		$this->load->model('page_type_m');
		$this->load->model('navigation/navigation_m');
		$this->lang->load('pages');
		$this->lang->load('page_types');

		$this->load->driver('Streams');

		// Get our chunks field type if this is an
		// upgraded site.
		if ($this->db->table_exists('page_chunks'))
		{
			$this->type->load_types_from_folder(APPPATH.'modules/pages/field_types/', 'pages_module');
		}
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
	 * Choose a page type
	 */
	public function choose_type()
	{
		// Get our types.
		$this->load->model('page_type_m');

		$all = $this->page_type_m->get_all();

		// Do we have a parent ID?
		$parent = ($this->input->get('parent')) ? '&parent='.$this->input->get('parent') : null;

        // Who needs a menu when there is only one option?
        if (count($all) === 1) 
        {
            redirect('admin/pages/create?page_type='.$all[0]->id.$parent);
        }

        // Directly output the menu if it's for the modal.
        // All we need is the <ul>.
        if ($this->input->get('modal') === 'true') 
        {
            $html  = '<h4>'.lang('pages:choose_type_title').'</h4>';
    		$html .= '<ul class="modal_select">';
    		
    		foreach ($all as $pt)
    		{
    			$html .= '<li><a href="'.site_url('admin/pages/create?page_type='.$pt->id.$parent).'"><strong>'.$pt->title.'</strong>';

    			if (trim($pt->description))
    			{
    				$html .= ' | '.$pt->description;
    			}

    			$html .= '</a></li>';
    		}
    		
    		ob_end_clean();
    		echo $html .= '</ul>';
            return;
        }
        
        // If this is not being displayed in the modal, we can
        // display an entire page.
        $this->template
            ->set('parent', $parent)
            ->set('page_types', $all)
            ->build('admin/choosetype');
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

        $this->load->model('keywords/keyword_m');
        $page->meta_keywords = $this->keywords->get_string($page->meta_keywords);

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
		// We are going to get the page in a stripped down way since
		// we need to only get what is in the database, in order
		// to be able to duplicate it.
		$page_raw = $this->db
						->select('pages.*, page_types.stream_id as pt_stream_id')
						->join('page_types', 'page_types.id = pages.type_id')
						->limit(1)->where('pages.id', $id)->get('pages')->row_array();

		$stream = $this->streams_m->get_stream($page_raw['pt_stream_id']);

		// Get entry
		$entry = $this->db->limit(1)
						->where('id', $page_raw['entry_id'])
						->get($stream->stream_prefix.$stream->stream_slug)->row_array();

		unset($page_raw['pt_stream_id']);
		unset($page_raw['entry_id']);

		// We can merge because there are rules in place so no stream slugs
		// are the same as slugs in the pages table.
		$page = $page_raw + $entry;

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

		$new_page = $this->page_m->create($page, $stream);

		foreach ($children as $child)
		{
			$this->duplicate($child->id, $new_page);
		}

		// only allow a redirect when everything is finished (only the top level page has a null parent_id)
		if (is_null($parent_id))
		{
			redirect('admin/pages');
		}
	}

	/**
	 * Create a new page
	 *
	 * @param int $parent_id The id of the parent page.
	 */
	public function create()
	{
		$page = new stdClass;

		// Parent ID
		$parent_id = ($this->input->get('parent')) ? $this->input->get('parent') : false;
		$this->template->set('parent_id', $parent_id);

        // What type of page are we creating?
        $page_type_id = $this->input->get('page_type');
        
        // Redirect to the page type selection menu if no page type was specified 
        if ( ! $page_type_id) 
        {
            redirect('admin/pages/choose_type');
        }
        
        // Get page type
        $page_type = $this->db->limit(1)->where('id', $page_type_id)->get('page_types')->row();        

		if ( ! $page_type) show_error('No page type found.');

		$stream = $this->_setup_stream_fields($page_type);

		// Run our validation. At this point, this is running the
		// compiled validation for both stream and standard.
		if ($this->form_validation->run())
		{
			$input = $this->input->post();

			// do they have permission to proceed?
			if ($input['status'] == 'live')
			{
				role_or_die('pages', 'put_live');
			}

			// We need to manually add this since we don't allow
			// users to change it in the page form.
			$input['type_id'] = $page_type_id;

			// Insert the page data, along with
			// the stream data.
			if ($id = $this->page_m->create($input, $stream))
			{
				if (isset($input['navigation_group_id']) and count($input['navigation_group_id']) > 0)
				{
					$this->pyrocache->delete_all('page_m');
					$this->pyrocache->delete_all('navigation_m');
				}

				Events::trigger('page_created', $id);

				$this->session->set_flashdata('success', lang('pages:create_success'));

				// Redirect back to the form or main page
				$input['btnAction'] == 'save_exit'
					? redirect('admin/pages')
					: redirect('admin/pages/edit/'.$id);
			}
		}

		// Loop through each rule for the standard page fields and 
		// set our current value for the form.
		foreach ($this->page_m->fields() as $field)
		{
			switch ($field)
			{
				case 'restricted_to[]':
					$page->restricted_to = set_value($field, array('0'));
					break;
				
				case 'navigation_group_id[]':
					$page->navigation_group_id = $this->input->post('navigation_group_id');
					break;

				case 'strict_uri':
					$page->strict_uri = set_value($field, true);
					break;

				default:
					$page->{$field} = set_value($field);
					break;
			}
		}

		// Go through our stream fields and set the current value 
		// for the form. Since we are creating a new form, this should
		// simply be the post data if it is available.
		$assignments = $this->streams->streams->get_assignments($stream->stream_slug, $stream->stream_namespace);
		$page_content_data = array();

		if ($assignments)
		{
			foreach ($assignments as $assign)
			{
				$page_content_data[$assign->field_slug] = $this->input->post($assign->field_slug);
			}
		}

		$stream_fields = $this->streams_m->get_stream_fields($this->streams_m->get_stream_id_from_slug($stream->stream_slug, $stream->stream_namespace));

		// Set Values
		$values = $this->fields->set_values($stream_fields, null, 'new');

		// Run stream field events
		$this->fields->run_field_events($stream_fields, array(), $values);

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
			->set('stream_fields', $this->streams->fields->get_stream_fields($stream->stream_slug, $stream->stream_namespace, $values))
			->set('parent_page', $parent_page)
			->set('page_type', $page_type)
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
		$id or redirect('admin/pages');

		$this->template->set('parent_id', null);

		// The user needs to be able to edit pages.
		role_or_die('pages', 'edit_live');

		// This is a temporary global until the page chunk field type is removed
		ci()->page_id = $id;

		// Retrieve the page data along with its data as part of the array.
		$page = $this->page_m->get($id);

		// Got page?
		if ( ! $page or empty($page))
		{
			// Maybe you would like to create one?
			$this->session->set_flashdata('error', lang('pages:page_not_found_error'));
			redirect('admin/pages/choose_type');
		}

		// Note: we don't need to get the page type
		// from the URL since it is present in the $page data

		// Get the page type.
		$page_type = $this->db->limit(1)->where('id', $page->type_id)->get('page_types')->row();

		if ( ! $page_type) show_error('No page type found.');

		$stream = $this->_setup_stream_fields($page_type, 'edit', $page->entry_id);

		// If there's a keywords hash
		if ($page->meta_keywords != '')
		{
			// Get comma-separated meta_keywords based on keywords hash
			$this->load->model('keywords/keyword_m');
			$old_keywords_hash = $page->meta_keywords;
			$page->meta_keywords = $this->keywords->get_string($page->meta_keywords);
		}

		// Turn the CSV list back to an array
		$page->restricted_to = explode(',', $page->restricted_to);

		// Did they even submit?
		if ($this->form_validation->run())
		{
			$input = $this->input->post();

			// do they have permission to proceed?
			if ($input['status'] == 'live')
			{
				role_or_die('pages', 'put_live');
			}

			// Were there keywords before this update?
			if (isset($old_keywords_hash))
			{
				$input['old_keywords_hash'] = $old_keywords_hash;
			}

			// We need to manually add this since we don't allow
			// users to change it in the page form.
			$input['type_id'] = $page->type_id;

			// validate and insert
			if ($this->page_m->edit($id, $input, $stream, $page->entry_id))
			{
				$this->session->set_flashdata('success', sprintf(lang('pages:edit_success'), $input['title']));

				Events::trigger('page_updated', $id);

				$this->pyrocache->delete_all('page_m');
				$this->pyrocache->delete_all('navigation_m');

				// Mission accomplished!
				$input['btnAction'] == 'save_exit'
					? redirect('admin/pages')
					: redirect('admin/pages/edit/'.$id);
			}
		}

		// Loop through each validation rule
		foreach ($this->page_m->validate as $field)
		{
			$field = $field['field'];

			// Nothing to do for the navigation field
			if (in_array($field, array('navigation_group_id[]')))
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

		// Go through our stream fields and set the current value 
		// for the form. Since we are creating a new form, this should
		// simply be the post data if it is available.

		$assignments = $this->streams->streams->get_assignments($stream->stream_slug, $stream->stream_namespace);
		$page_content_data = array();

		// Get straight raw from the db
		$page_stream_entry_raw = $this->db->limit(1)->where('id', $page->entry_id)->get($stream->stream_prefix.$stream->stream_slug)->row();

		if ($assignments)
		{
			foreach ($assignments as $assign)
			{
				$from_db = isset($page_stream_entry_raw->{$assign->field_slug}) ? $page_stream_entry_raw->{$assign->field_slug} : null;

				$page_content_data[$assign->field_slug] = isset($_POST[$assign->field_slug]) ? $_POST[$assign->field_slug] : $from_db;
			}	
		}

		$stream_fields = $this->streams_m->get_stream_fields($this->streams_m->get_stream_id_from_slug($stream->stream_slug, $stream->stream_namespace));

		// Set Values
		$values = $this->fields->set_values($stream_fields, $page_stream_entry_raw, 'edit');

		// Run stream field events
		$this->fields->run_field_events($stream_fields, array(), $values);

		// If this page has a parent.
		if ($page->parent_id > 0)
		{
			// Get only the details for the parent, no data.
			$parent_page = $this->page_m->get($page->parent_id, false);
		}
		else
		{
			$parent_page = false;
		}

		$this->_form_data();

		$this->template
			->title($this->module_details['name'], sprintf(lang('pages:edit_title'), $page->title))
			->append_metadata($this->load->view('fragments/wysiwyg', array() , true))
			->append_css('module::page-edit.css')
			->set('stream_fields', $this->streams->fields->get_stream_fields($stream->stream_slug, $stream->stream_namespace, $values, $page->entry_id))
			->set('page', $page)
			->set('parent_page', $parent_page)
			->set('page_type', $page_type)
			->build('admin/form');
	}

	/**
	 * Setup Stream fields
	 *
	 * Sets up our validation and some other common
	 * elements for our page create/edit functions.
	 *
	 * @param 	obj
	 * @param 	string - new or edit
	 * @param 	int - entry id
	 * @return 	obj - the stream object
	 */
	private function _setup_stream_fields($page_type, $method = 'new', $id = null)
	{
		// Get the stream that we are using for this page type.
		$stream = $this->db->limit(1)->where('id', $page_type->stream_id)->get('data_streams')->row();

		$this->load->driver('Streams');
		$this->load->library('Form_validation');

		// So we can use the callbacks in page_m
		$this->form_validation->set_model('page_m');

		// If we have renamed the title, then we need to change that in the validation array
		if ($page_type->title_label)
		{
			foreach ($this->page_m->validate as $k => $v)
			{
				if ($v['field'] == 'title')
				{
					$this->page_m->validate[$k]['label'] = lang_label($page_type->title_label);
				}
			}
		}

		// Get validation for our page fields.
		$page_validation = $this->streams->streams->validation_array($stream->stream_slug, $stream->stream_namespace, $method, array(), $id);

		$this->page_m->compiled_validate = array_merge($this->page_m->validate, $page_validation);

		// Set the validation rules based on the compiled validation.
		$this->form_validation->set_rules($this->page_m->compiled_validate);

		return $stream;
	}

	// --------------------------------------------------------------------------

	/**
	 * Sets up common form inputs.
	 *
	 * This is used in both the creation and editing forms.
	 */
	private function _form_data()
	{
		$page_types = $this->page_type_m->order_by('title')->get_all();
		$this->template->page_types = array_for_select($page_types, 'id', 'title');

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
		$this->load->model('comments/comment_m');

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

					// Delete any page comments for this entry
					$this->comment_m->where('module', 'pages')->delete_by(array(
						'entry_key' => 'page:page',
						'entry_id' => $id
					));

					// Wipe cache for this model, the content has changd
					$this->pyrocache->delete_all('page_m');
					$this->pyrocache->delete_all('navigation_m');
				}
				else
				{
					$this->session->set_flashdata('error', lang('pages:delete_home_error'));
				}
			}

			// Some pages have been deleted
			if ( ! empty($deleted_ids))
			{
				Events::trigger('page_deleted', $deleted_ids);

				// Only deleting one page
				if ( count($deleted_ids) == 1 )
				{
					$this->session->set_flashdata('success', sprintf(lang('pages:delete_success'), $deleted_ids[0]));
				}
				// Deleting multiple pages
				else
				{
					$this->session->set_flashdata('success', sprintf(lang('pages:mass_delete_success'), count($deleted_ids)));
				}
			}
			// For some reason, none of them were deleted
			else
			{
				$this->session->set_flashdata('notice', lang('pages:delete_none_notice'));
			}
		}

		redirect('admin/pages');
	}

}
