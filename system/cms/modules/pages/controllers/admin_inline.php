<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Pages controller
 *
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Pages\Controllers
 */
class Admin_inline extends Admin_Controller {

	/**
	 * The current active section
	 *
	 * @var string
	 */
	protected $section = 'pages';


	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->library('form_validation');

		$this->load->model('page_m');
		$this->load->model('page_layouts_m');
		$this->load->model('navigation/navigation_m');
		$this->lang->load('pages');
		
		role_or_die('pages', 'edit_live');
	}


	public function save()
	{
		$return = array(
			'status'=>'error',
			'body'=>''
		);
		$id = $this->input->post('page_id');
		$chunk_id = $this->input->post('chunk_id');
		$type = $this->input->post('type');
		if ($id)
		{
		// Load the current theme so we can set the assets right away

			$body = str_replace(array('<?', '?>'), array('&lt;?', '?&gt;'), $this->input->post('body'));
			
			/*
			 * @todo Encode HTML before update/save
			 * */
			
			$chunk_data = array(
				'body'=>$body,
				'parsed'=> ($type == 'markdown') ? parse_markdown($body) : ''
			);
			$this->db->update('page_chunks', $chunk_data, array('id' => $chunk_id, 'page_id' => $id));
			if ($this->db->affected_rows() >= 0)
			{
				if ($type == 'markdown') 
				{
					$body = $chunk_data['parsed'];
				}
				$return = array(
					'status'=>'ok',
					'body'=>'<div class="page-chunk-pad">'.$this->parser->parse_string(str_replace(array('&#39;', '&quot;'), array("'", '"'), $body), '', TRUE).'</div>'
				);
			}
		}
		die(json_encode($return));
	}

	/**
	 * Create a new page
	 *
	 * @param int $parent_id The id of the parent page.
	 */
	public function create()
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
	public function edit()
	{
		// The user needs to be able to edit pages.
		role_or_die('pages', 'edit_live');
		
		$id = $this->input->post('page_id');
		$chunk_id = $this->input->post('chunk_id');

		$out = $this->db
				->order_by('sort')
				->get_where('page_chunks', array('page_id' => $id, 'id' => $chunk_id))
				->row();
		die(json_encode($out));
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