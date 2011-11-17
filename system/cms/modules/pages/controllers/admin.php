<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Pages controller
 *
 * @author	PyroCMS Dev Team, Don Myers
 * @package 	PyroCMS
 * @subpackage 	Pages module
 * @category	Modules
 */
class Admin extends Admin_Controller {

	/**
	 * The current active section
	 * @access protected
	 * @var string
	 */
	protected $section = 'pages';

	/**
	 * Array containing the validation rules
	 * @access private
	 * @var array
	 */
	private $validation_rules = array(
		array(
			'field' => 'title',
			'label'	=> 'lang:pages.title_label',
			'rules'	=> 'trim|required|max_length[250]'
		),
		'slug' => array(
			'field' => 'slug',
			'label'	=> 'lang:pages.slug_label',
			'rules'	=> 'trim|required|alpha_dot_dash|max_length[250]'
		),
		array(
			'field' => 'layout_id',
			'label'	=> 'lang:pages.layout_id_label',
			'rules'	=> 'trim|numeric|required'
		),
		array(
			'field'	=> 'css',
			'label'	=> 'lang:pages.css_label',
			'rules'	=> 'trim'
		),
		array(
			'field'	=> 'js',
			'label'	=> 'lang:pages.js_label',
			'rules'	=> 'trim'
		),
		array(
			'field' => 'meta_title',
			'label' => 'lang:pages.meta_title_label',
			'rules' => 'trim|max_length[250]'
		),
		array(
			'field'	=> 'meta_keywords',
			'label' => 'lang:pages.meta_keywords_label',
			'rules' => 'trim|max_length[250]'
		),
		array(
			'field'	=> 'meta_description',
			'label'	=> 'lang:pages.meta_description_label',
			'rules'	=> 'trim'
		),
		array(
			'field' => 'restricted_to[]',
			'label'	=> 'lang:pages.access_label',
			'rules'	=> 'trim|numeric'
		),
		array(
			'field' => 'rss_enabled',
			'label'	=> 'lang:pages.rss_enabled_label',
			'rules'	=> 'trim|numeric'
		),
		array(
			'field' => 'comments_enabled',
			'label'	=> 'lang:pages.comments_enabled_label',
			'rules'	=> 'trim|numeric'
		),
		array(
			'field' => 'is_home',
			'label'	=> 'lang:pages.is_home_label',
			'rules'	=> 'trim|numeric'
		),
		array(
			'field'	=> 'status',
			'label'	=> 'lang:pages.status_label',
			'rules'	=> 'trim|alpha|required'
		),
		array(
			'field' => 'navigation_group_id',
			'label' => 'lang:pages.navigation_label',
			'rules' => 'numeric'
		)
	);

	/**
	 * Constructor method
	 * @access public
	 * @return void
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
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$this->data->pages = $this->page_m->get_page_tree();
		$this->data->controller =& $this;

		$this->template
			->title($this->module_details['name'])
			->append_metadata( js('jquery/jquery.ui.nestedSortable.js') )
			->append_metadata( js('jquery/jquery.cooki.js') )
			->append_metadata( js('index.js', 'pages') )
			->append_metadata( css('index.css', 'pages') )
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

		$chunks = $this->page_m->get_chunks($page->id);
		
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
		// Loop through each rule to setup empty variables
		foreach ($this->validation_rules as $rule)
		{
			if (substr($rule['field'],-2) === '[]')
			{
				$name = substr($rule['field'],0,-2);
				$page->{$name} = '';
				continue;
			}

			$page->{$rule['field']} = '';
		}

		// get me a empty default chunk
		$page->chunks = array($this->page_m->create_chunk('default'));

		// Set the page ID and get the current page
		$page->id = -1;
		$page->parent_id = $parent_id;

		$this->_build_form($page,true);
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
		$page->chunks = $this->page_m->get_chunks($id);

		// Got page?
		if (!$page)
		{
			$this->session->set_flashdata('error', lang('pages_page_not_found_error'));
			redirect('admin/pages/create');
		}

		$this->_build_form($page);
	}

	/**
	 * Build the html for the admin page tree view
	 *
	 * @access public
	 * @param array $page Current page
	 * @param boolean Is New Form
	 * @return void
	 */
	private function _build_form(&$page,$isnew = false)
	{

		if ($page->parent_id > 0)
		{
			$parent_page = $this->page_m->get($page->parent_id);
		}

		// It's stored as a CSV list
		$page->restricted_to = explode(',', $page->restricted_to);
		$page->old_slug = $page->slug;

		// Assign data for display
		$this->data->page =& $page;
		$this->data->parent_page =& $parent_page;

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

		$title = ($isnew) ? lang('pages.create_title') : sprintf(lang('pages.edit_title'), $page->title);

		$this->template
			->title($this->module_details['name'], $title)
			->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			->append_metadata( js('pyro.js', 'pages') )
			->append_metadata( js('form.js', 'pages') )
			->build('admin/form', $this->data);
	}

	/**
	 * Request the HTML for a New Empty Page Chunk
	 * @access public
	 * @return string containing HTML
	 */
	public function page_chunk()
	{
		// make a random chunk;
		$this->load->view('admin/page_chunk',$this->page_m->create_chunk());
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
	 * Delete an existing page chunk
	 * @access public
	 * @param int $id The ID of the page chunk to delete
	 * @return json
	 */
	public function delete_chunk($id = 0)
	{
		// we need to find this chunk and remove it
		role_or_die('pages', 'delete_live');

		if ($this->input->is_ajax_request())
		{
			// if it's a md5 then they didn't add it yet so we just remove it off the front end
			if (strlen($id) < 32)
			{
				$chunk = $this->page_m->get_chunk($id);
				$this->page_m->delete_chunks($chunk);
			}
		}
		
		$this->template->build_json(array('finished'=>true));
	}

	/**
	 * handle the complete form create/insert or edit/update - upsert
	 *
	 * @access public
	 * @param none
	 * @global mixed $_POST via CI input
	 * @return json
	 */
	public function upsert()
	{
		// Let's assume it's bad/unsafe input unless told otherwise
		$json_responds = array('valid'=>false);

		// did we get anything?
		if ($this->input->is_ajax_request() && $this->input->post())
		{
			// let's add these dynamically even thou they were passed as arrays since they
			// contain keys the CI validation array handler can't handle them

			$chunks = array();
			$dynamic_validation_rules = array();
			$chunk_slugs = $this->input->post('chunk_slug') ? $this->input->post('chunk_slug') : array();
			$chunk_bodies = $this->input->post('chunk_body') ? $this->input->post('chunk_body') : array();
			$chunk_types = $this->input->post('chunk_type') ? $this->input->post('chunk_type') : array();

			// we need this as well
			$chunk_slugs_keys = $this->input->post('chunk_slug') ? array_keys($this->input->post('chunk_slug')) : array();

			$this->form_validation->set_message('_custom_required', lang('pages_chunk_slugs_empty'));

			// this gets replaced because if it's the same page it's ok to fail on check slug
			$dynamic_validation_rules['slug'] = array(
				'field' => 'slug',
				'label'	=> 'lang:pages.slug_label',
				'rules'	=> 'trim|required|alpha_dot_dash|max_length[250]|callback__check_slug['.$this->input->post('id').']'
			);

			foreach ($chunk_slugs_keys as $key)
			{
				$dynamic_validation_rules[] = array(
					'field' => 'chunk_slug['.$key.']',
					'label'	=> 'lang:pages_chunk_slugs_empty',
					'rules'	=> 'trim|required|alpha_dot_dash|max_length[30]'
				);
				$dynamic_validation_rules[] = array(
					'field' => 'chunk_body['.$key.']',
					'label'	=> 'lang:pages.body_label',
					'rules'	=> 'trim|callback__strip_php'
				);


				// prep the chunks while we are at it
				$chunks[$key] = array(
					'id' => $key,
					'slug' => !empty($chunk_slugs[$key]) ? $chunk_slugs[$key] : '',
					'type' => !empty($chunk_types[$key]) ? $chunk_types[$key] : '',
					'body' => !empty($chunk_bodies[$key]) ? $chunk_bodies[$key] : '',
				);
			}

			// we need to validate the input
			$this->form_validation->set_rules(array_merge($this->validation_rules,$dynamic_validation_rules));
			$this->form_validation->set_error_delimiters('','<br>');

			// let the validation begin
			if ($this->form_validation->run())
			{
				$input = $this->input->post();

				$json_responds['old_slug'] = $input['slug'];

				if ($input['status'] == 'live')
				{
					role_or_die('pages', 'put_live');
				}

				$input['restricted_to'] = isset($input['restricted_to']) ? implode(',', $input['restricted_to']) : '';

				if ($input['id'] == -1)
				{
					// *** new page

					// First create the page
					$nav_group_id = $input['navigation_group_id'];
					unset($input['navigation_group_id']);

					if ($page_id = $this->page_m->insert($input))
					{
						$json_responds['id'] = $page_id;

						$json_responds['replace'] = $this->upsert_chunks($page_id,$chunks);

						// Add a Navigation Link
						if ($nav_group_id)
						{
							$this->load->model('navigation/navigation_m');
							$this->navigation_m->insert_link(array(
								'title'					=> $input['title'],
								'link_type'				=> 'page',
								'page_id'				=> $page_id,
								'navigation_group_id'	=> (int) $nav_group_id
							));
						}

						if ($this->page_m->update($page_id, $input))
						{
							// ok now we know it's good!
							$json_responds['valid'] = true;
							$link = anchor('admin/pages/preview/'.$page_id, $input['title'], 'class="modal-large"');
							$json_responds['msg'] = '<span class="save_alert" style="padding-left: 32px">'.sprintf(lang('pages_edit_success'), $link).'</span>';
						}
					}
					else
					{
						$json_responds['valid'] = false;
						$json_responds['msg'] = '<div class="alert error">'.lang('pages_upsert_error').'</div>';
					}

				}
				else
				{
					// *** update
					$page_id = $input['id'];

					$this->page_m->update($page_id,$input);

					$json_responds['replace'] = $this->upsert_chunks($page_id,$chunks);

					// The slug has changed
					if ($input['slug'] != $input['old_slug'])
					{
						$this->page_m->reindex_descendants($page_id);
					}

					// ok now we know it's good!
					$json_responds['valid'] = true;
					$link = anchor('admin/pages/preview/'.$page_id, $input['title'], 'class="modal-large"');
					$json_responds['msg'] = '<span class="save_alert" style="padding-left: 32px">'.sprintf(lang('pages_edit_success'), $link).'</span>';
				}
			}
			else
			{
				$json_responds['msg'] = '<div class="alert error">'.substr(validation_errors(),0,-5).'</div>';
			}
		}
		else
		{
			$json_responds['msg'] = '<div class="alert error">'.lang('pages_upsert_error').'</div>';
		}

		$this->template->build_json($json_responds);
	}


	/**
	 * handle the complete form page chunk create/insert or edit/update - upsert
	 *
	 * @access public
	 * @param int parent page id
	 * @param array chunks in an array
	 * @return array of database primary ids for each md5 temp id
	 */
	public function upsert_chunks($page_id,$chunks)
	{
		$new_ids = array();
		// we need to run these individually so we can capture the new primary ids
		foreach ($chunks as $key => $chunk)
		{
			$chunk['page_id'] = $page_id;
			/*
			if the current primary is 32 chars long it's a new entry
			if we have a primary id that's 32 characters long this would fail
			but mysql primary id would fail first that's a lot of chunks!
			*/
			if (strlen($key) == 32)
			{
				// insert new chunk
				$new_ids[] = array($key,$this->page_m->insert_chunks($page_id,$chunk));
			}
			else
			{
				// update a current chunk
				$this->page_m->update_chunks($chunk);
			}
		}
		return $new_ids;
	}

	/**
	 * Callback to check uniqueness of slug + parent
	 *
	 * @access public
	 * @param $slug slug to check
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
			return FALSE;
		}

	return TRUE;
	}

	/**
	 * Callback to strip php tags from chunk content
	 *
	 * @access public
	 * @param $body body content to check
	 * @return string
	 */
	public function _strip_php($body)
	{
		return str_replace(array('<?', '?>'), array('&lt;?', '?&gt;'), $body);
	}

	/**
	 * Callback for custom required form chunk(s)
	 *
	 * @access public
	 * @param string input
	 * @return boolean
	 */
	public function _custom_required($input)
	{
		return empty($input);
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