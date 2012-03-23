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
	 * @access protected
	 * @var string
	 */
	protected $section = 'pages';

	/**
	 * Constructor method
	 * @access public
	 * @return void
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
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$this->data->pages = $this->page_m->get_page_tree();
		$this->data->controller =& $this;
		
		$this->template
		
			->title($this->module_details['name'])
			
			->append_js('jquery/jquery.ui.nestedSortable.js')
			->append_js('jquery/jquery.cooki.js')
			->append_js('jquery/jquery.stickyscroll.js')
			->append_js('module::index.js')
			
			->append_css('module::index.css')
			
			->build('admin/index', $this->data);
	}

	/**
	 * Order the pages and record their children
	 *
	 * @access public
	 * @return string json message
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
	 * Get the details of a page using Ajax
	 * @access public
	 * @param int $page_id The ID of the page
	 * @return void
	 */
	public function ajax_page_details($page_id)
	{
		$page = $this->page_m->get($page_id);

		$this->load->view('admin/ajax/page_details', array('page' => $page));
	}

	/**
	 * Show a page preview
	 * @access public
	 * @param int $id The ID of the page
	 * @return void
	 */
	public function preview($id = 0)
	{
		$this->template->set_layout('modal', 'admin');
		$this->template->build('admin/preview', array(
			'page' => $this->page_m->get($id),
		));
	}

	/**
	 * Duplicate a page
	 * @access public
	 * @param int $id The ID of the page
	 * @param int $id The ID of the parent page, if this is a recursive nested duplication
	 * @return void
	 */
	public function duplicate($id, $parent_id = null)
	{
		$page  = $this->page_m->get($id);

		// Steal their children
		$children = $this->page_m->get_many_by('parent_id', $id);

		$new_slug = $page->slug;

		// No parent around? Do what you like
		if (is_null($parent_id))
		{
			do
			{
				// Turn "Foo" into "Foo 2"
				$page->title = increment_string($page->title, ' ', 2);

				// Turn "foo" into "foo-2"
				$page->slug = increment_string($page->slug, '-', 2);

				// Find if this already exists in this level
				$dupes = $this->page_m->count_by(array(
					'slug' => $page->slug,
					'parent_id' => $page->parent_id,
				));
			}
			while ($dupes > 0);
		}

		// Oop, a parent turned up, work with that
		else
		{
			$page->parent_id = $parent_id;
		}

		$chunks = $this->db->get_where('page_chunks', array('page_id' => $page->id))->result();

		$new_page_id = $this->page_m->insert((array) $page, $chunks);

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
	 * @access public
	 * @param int $parent_id The ID of the parent page
	 * @return void
	 */
	public function create($parent_id = 0)
	{
		// did they even submit?
		if ($input = $this->input->post())
		{
			// do they have permission to proceed?
			if ($input['status'] == 'live')
			{
				role_or_die('pages', 'put_live');
			}

			// validate and insert
			if ($data = $this->page_m->create($input))
			{
				$this->session->set_flashdata('success', lang('pages_create_success'));

				Events::trigger('post_page_create', $data);

				// Mission accomplished!
				$input['btnAction'] == 'save_exit'
					? redirect('admin/pages')
					: redirect('admin/pages/edit/'.$data['id']);
			}
			else
			{
				// validation failed, we must repopulate the chunks form
				$chunk_slugs 	= $this->input->post('chunk_slug') ? array_values($this->input->post('chunk_slug')) : array();
				$chunk_bodies 	= $this->input->post('chunk_body') ? array_values($this->input->post('chunk_body')) : array();
				$chunk_types 	= $this->input->post('chunk_type') ? array_values($this->input->post('chunk_type')) : array();

				$page->chunks 		= array();
				$chunk_bodies_count = count($input['chunk_body']);
				for ($i = 0; $i < $chunk_bodies_count; $i++)
				{
					$page->chunks[] = (object) array(
						'id' 	=> $i,
						'slug' 	=> ! empty($chunk_slugs[$i]) 	? $chunk_slugs[$i] 	: '',
						'type' 	=> ! empty($chunk_types[$i]) 	? $chunk_types[$i] 	: '',
						'body' 	=> ! empty($chunk_bodies[$i]) 	? $chunk_bodies[$i] : '',
					);
				}
			}
		}
		else
		{
			// define some default values for the chunks form
			$page->chunks = array((object) array(
				'id' => 'NEW',
				'slug' => 'default',
				'body' => '',
				'type' => 'wysiwyg-advanced',
			));
		}

		// Populate the rest of the form variables
		foreach ($this->page_m->validate as $rule)
		{
			if ($rule['field'] === 'restricted_to[]')
			{
				$page->restricted_to = set_value($rule['field'], array('0'));

				continue;
			}

			$page->{$rule['field']} = set_value($rule['field']);
		}

		// If a parent id was passed, fetch the parent details
		if ($parent_id > 0)
		{
			$page->parent_id 	= $parent_id;
			$page->parent_page 	= $this->page_m->get($parent_id);
		}

		// Set some data that both create and edit forms will need
		self::_form_data();

		$data->page = $page;

		// Load WYSIWYG editor
		$this->template
			->title($this->module_details['name'], lang('pages.create_title'))
			->append_metadata( $this->load->view('fragments/wysiwyg', NULL, TRUE) )
			->build('admin/form', $data);
	}

	/**
	 * Edit an existing page
	 * @access public
	 * @param int $id The ID of the page to edit
	 * @return void
	 */
	public function edit($id = 0)
	{
		$id OR redirect('admin/pages');

		role_or_die('pages', 'edit_live');

		$page = $this->page_m->get($id);

		// Grab all the chunks that make up the body
		$page->chunks = $this->db->order_by('sort')
			->get_where('page_chunks', array('page_id' => $id))
			->result();

		// Got page?
		if ( ! $page)
		{
			$this->session->set_flashdata('error', lang('pages_page_not_found_error'));
			redirect('admin/pages/create');
		}

		// Set the page ID and get the current page
		$this->page_id = $page->id;

		// It's stored as a CSV list
		$page->restricted_to = explode(',', $page->restricted_to);

		if ($_POST)
		{
			$chunk_slugs = $this->input->post('chunk_slug') ? array_values($this->input->post('chunk_slug')) : array();
			$chunk_bodies = $this->input->post('chunk_body') ? array_values($this->input->post('chunk_body')) : array();
			$chunk_types = $this->input->post('chunk_type') ? array_values($this->input->post('chunk_type')) : array();

			$chunk_slugs_count = count($chunk_slugs);

			$page->chunks = array();
			for ($i = 0; $i < $chunk_slugs_count; $i++)
			{
				// Nothing in here?
				if (empty($chunk_slugs[$i]) and ! strip_tags($chunk_bodies[$i])) continue;

				// Strip PHP from chunks
				$chunk_bodies[$i] = str_replace(array(
					'<?', '?>'
				), array(
					'&lt;?', '?&gt;'
				), $chunk_bodies[$i]);

				$page->chunks[] = (object) array(
					'id' => $i,
					'slug' => ! empty($chunk_slugs[$i]) ? $chunk_slugs[$i] : '',
					'type' => ! empty($chunk_types[$i]) ? $chunk_types[$i] : '',
					'body' => ! empty($chunk_bodies[$i]) ? $chunk_bodies[$i] : '',
				);
			}

			$this->form_validation->set_rules(array_merge($this->validation_rules, array(
				'slug' => array(
					'field' => 'slug',
					'label'	=> 'lang:pages.slug_label',
					'rules'	=> 'trim|required|alpha_dot_dash|max_length[250]|callback__check_slug['.$id.']'
				)
			)));

			if ($this->form_validation->run())
			{
				$input = $this->input->post();

				if ($page->status != 'live' and $input['status'] == 'live')
				{
					role_or_die('pages', 'put_live');
				}

				$input['restricted_to'] = isset($input['restricted_to']) ? implode(',', $input['restricted_to']) : '0';

				// Run the update code with the POST data
				$this->page_m->update($id, $input, $page->chunks);

				// The slug has changed
				if ($this->input->post('slug') != $this->input->post('old_slug'))
				{
					$this->page_m->reindex_descendants($id);
				}

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

		// Loop through each validation rule
		foreach ($this->page_m->validate as $rule)
		{
			if (in_array($rule['field'], array('navigation_group_id', 'chunk_body[]')))
			{
				continue;
			}

			if ($rule['field'] === 'restricted_to[]')
			{
				$page->restricted_to = set_value($rule['field'], $page->restricted_to);
				$page->restricted_to[0] = ($page->restricted_to[0] == '') ? '0' : $page->restricted_to[0];
				continue;
			}

			$page->{$rule['field']} = set_value($rule['field'], $page->{$rule['field']});
		}

		// If a parent id was passed, fetch the parent details
		if ($page->parent_id > 0)
		{
			$parent_page = $this->page_m->get($page->parent_id);
		}

		// Assign data for display
		$this->data->page =& $page;
		$this->data->parent_page =& $parent_page;

		self::_form_data();

		$this->template

			->title($this->module_details['name'], sprintf(lang('pages.edit_title'), $page->title))

			// Load WYSIWYG Editor
			->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			->append_css('module::page-edit.css')
			->build('admin/form', $this->data);
	}


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
		
		$this->template->append_js('jquery/jquery.tagsinput.js');
		$this->template->append_js('jquery/jquery.cooki.js');
		$this->template->append_js('module::form.js');
		$this->template->append_css('jquery/jquery.tagsinput.css');
	}

	/**
	 * Delete an existing page
	 * @access public
	 * @param int $id The ID of the page to delete
	 * @return void
	 */
	public function delete($id = 0)
	{
		role_or_die('pages', 'delete_live');

		// Attention! Error of no selection not handeled yet.
		$ids = ($id) ? array($id) : $this->input->post('action_to');

		// Go through the array of slugs to delete
		if ( ! empty($ids))
		{
			foreach ($ids as $id)
			{
				if ($id !== 1)
				{
					$deleted_ids = $this->page_m->delete($id);

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
				else // Deleting multiple pages
				{
					$this->session->set_flashdata('success', sprintf(lang('pages_mass_delete_success'), count($deleted_ids)));
				}
			}

			else // For some reason, none of them were deleted
			{
				$this->session->set_flashdata('notice', lang('pages_delete_none_notice'));
			}
		}

		redirect('admin/pages');
	}

	/**
	 * Build the html for the admin page tree view
	 *
	 * @access public
	 * @param array $page Current page
	 */
	public function tree_builder($page)
	{
		if (isset($page['children'])):

			foreach($page['children'] as $page): ?>

				<li id="page_<?php echo $page['id']; ?>">
					<div>
						<a href="#" rel="<?php echo $page['id'] . '">' . $page['title']; ?></a>
					</div>

			<?php if(isset($page['children'])): ?>
					<ul>
							<?php $this->tree_builder($page); ?>
					</ul>
				</li>
			<?php else: ?>
				</li>
			<?php endif;
			endforeach;
		endif;
	}
}