<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin controller for the navigation module. Handles actions such as editing links or creating new ones.
 *
 * @author PyroCMS Development Team
 * @package PyroCMS\Core\Modules\Navigation\Controllers
 *
 */
class Admin extends Admin_Controller {

	/**
	 * The current active section.
	 *
	 * @var int
	 */
	protected $section = 'links';

	/**
	 * The array containing the rules for the navigation items.
	 *
	 * @var array
	 */
	private $validation_rules 	= array(
		array(
			'field' => 'title',
			'label'	=> 'lang:global:title',
			'rules'	=> 'trim|required|max_length[100]'
		),
		array(
			'field' => 'link_type',
			'label'	=> 'lang:nav_type_label',
			'rules'	=> 'trim|required|alpha|callback__link_check'
		),
		array(
			'field' => 'url',
			'label'	=> 'lang:nav_url_label',
			'rules'	=> 'trim'
		),
		array(
			'field' => 'uri',
			'label'	=> 'lang:nav_uri_label',
			'rules'	=> 'trim'
		),
		array(
			'field' => 'module_name',
			'label'	=> 'lang:nav_module_label',
			'rules'	=> 'trim|alpha_dash'
		),
		array(
			'field' => 'page_id',
			'label'	=> 'lang:nav_page_label',
			'rules'	=> 'trim|numeric'
		),
		array(
			'field' => 'navigation_group_id',
			'label'	=> 'lang:nav_group_label',
			'rules'	=> 'trim|numeric'
		),
		array(
			'field' => 'current_group_id',
			'label'	=> 'lang:nav_group_label',
			'rules'	=> 'trim|numeric'
		),
		array(
			'field' => 'target',
			'label'	=> 'lang:nav_target_label',
			'rules'	=> 'trim|max_length[10]'
		),
		array(
			'field' => 'restricted_to',
			'label'	=> 'lang:nav_restricted_to',
			'rules'	=> ''
		),
		array(
			'field' => 'class',
			'label'	=> 'lang:nav_class_label',
			'rules'	=> 'trim'
		)
	);

	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->library('form_validation');
		$this->load->model('navigation_m');
		$this->load->model('pages/page_m');
		$this->lang->load('navigation');

		$this->template
			->append_js('module::navigation.js')
			->append_css('module::navigation.css');

		// Get Navigation Groups
		$this->template->groups 		= $this->navigation_m->get_groups();
		$this->template->groups_select 	= array_for_select($this->template->groups, 'id', 'title');
		$all_modules				= $this->module_m->get_all(array('is_frontend'=>true));

		//only allow modules that user has permissions for
		foreach($all_modules as $module)
		{
			if (in_array($module['slug'], $this->permissions) or $this->current_user->group == 'admin') $modules[] = $module;
		}

		$this->template->modules_select = array_for_select($modules, 'slug', 'name');

		// Get Pages and create pages tree
		$tree = array();

		if ($pages = $this->page_m->get_all())
		{
			foreach($pages AS $page)
			{
				$tree[$page->parent_id][] = $page;
			}
		}

		unset($pages);
		$this->template->pages_select = $tree;

		// Set the validation rules for the navigation items
		$this->form_validation->set_rules($this->validation_rules);
	}

	/**
	 * List all navigation elements
	 */
	public function index()
	{
		$navigation = array();
		// Go through all the groups
		foreach ($this->template->groups as $group)
		{
			//... and get navigation links for each one
			$navigation[$group->id] = $this->navigation_m->get_link_tree($group->id);
		}

		// Create the layout
		$this->template
			->append_js('jquery/jquery.ui.nestedSortable.js')
			->append_js('jquery/jquery.cooki.js')
			->title($this->module_details['name'])
			->set('navigation', $navigation)
			->build('admin/index');
	}

	/**
	 * Order the links and record their children
	 */
	public function order()
	{
		$order	= $this->input->post('order');
		$data	= $this->input->post('data');
		$group	= isset($data['group']) ? (int) $data['group'] : 0;

		if (is_array($order))
		{
			//reset all parent > child relations
			$this->navigation_m->update_by_group($group, array('parent' => 0));

			foreach ($order as $i => $link)
			{
				//set the order of the root links
				$this->navigation_m->update_by('id', str_replace('link_', '', $link['id']), array('position' => $i));

				//iterate through children and set their order and parent
				$this->navigation_m->_set_children($link);
			}

			$this->pyrocache->delete_all('navigation_m');
			Events::trigger('post_navigation_order', array($order, $group));
		}
	}

	/**
	 * Get the details of a link using Ajax
	 *
	 * @param int $link_id The ID of the link
	 */
	public function ajax_link_details($link_id)
	{
		$link = $this->navigation_m->get_url($link_id);

		$ids = explode(',', $link->restricted_to);

		$this->load->model('groups/group_m');
		$this->db->where_in('id', $ids);
		$groups = $this->group_m->dropdown('id', 'name');

		$link->restricted_to = implode(', ', $groups);

		$this->load->view('admin/ajax/link_details', array('link' => $link));
	}

	/**
	 * Create a new navigation item
	 *
	 * @todo This should use the template system too.
	 *
	 * @param string $group_id
	 *
	 * @return
	 */
	public function create($group_id = '')
	{
		// Set the options for restricted to
		$this->load->model('groups/group_m');
		$groups = $this->group_m->get_all();
		foreach ($groups as $group)
		{
			$group_options[$group->id] = $group->name;
		}
		$this->template->group_options = $group_options;

		// Run if valid
		if ($this->form_validation->run())
		{
			$input = $this->input->post();
			$input['restricted_to'] = isset($input['restricted_to']) ? implode(',', $input['restricted_to']) : '';

			// Got post?
			ob_end_clean();
			if ($this->navigation_m->insert_link($input) > 0)
			{
				$this->pyrocache->delete_all('navigation_m');

				Events::trigger('post_navigation_create', $input);

				$this->session->set_flashdata('success', lang('nav:link_add_success'));

				// echo success to let the js refresh the page
				echo 'success';
				return;
			}
			else
			{
				$this->template->messages['error'] = lang('nav:link_add_error');

				echo $this->load->view('admin/partials/notices', $this->template);
				return;
			}
		}

		// check for errors
		if (validation_errors())
		{
			echo $this->load->view('admin/partials/notices');
			return;
		}

		$link = (object)array();

		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$link->{$rule['field']} = set_value($rule['field']);
		}

		$link->navigation_group_id = $group_id;

		$this->template
			->set('link',$link);

		// Get Pages and create pages tree
		$this->template->tree_select = $this->_build_tree_select(array('current_parent' => $this->template->link->page_id));

		$this->template
			->set_layout(false)
			->build('admin/ajax/form');
	}

	/**
	 * Edit a navigation item
	 *
	 * @param int $id The ID of the navigation item.
	 */
	public function edit($id = 0)
	{
		// Got ID?
		if (empty($id))
		{
			return;
		}

		// Get the navigation item based on the ID
		$link = $this->navigation_m->get_link($id);

		// Set the options for restricted to
		$this->load->model('groups/group_m');
		$groups = $this->group_m->get_all();
		foreach ($groups as $group)
		{
			$group_options[$group->id] = $group->name;
		}

		if ( ! $link)
		{
			$this->template->messages['error'] = lang('nav:link_not_exist_error');

			exit($this->load->view('admin/partials/notices', compact('link', 'group_options')));
		}

		// Valid data?
		if ($this->form_validation->run())
		{
			$input = $this->input->post();
			$input['restricted_to'] = isset($input['restricted_to']) ? implode(',', $input['restricted_to']) : '';

			// Update the link and flush the cache
			$this->navigation_m->update_link($id, $input);
			$this->pyrocache->delete_all('navigation_m');

			Events::trigger('post_navigation_edit', $input);

			$this->session->set_flashdata('success', lang('nav:link_edit_success'));

			// echo success to let the js refresh the page
			exit('success');
		}

		// check for errors
		if (validation_errors())
		{
			exit($this->load->view('admin/partials/notices', $this->template));
		}

		// Loop through each rule
		foreach ($this->validation_rules as $rule)
		{
			if ($this->input->post($rule['field']) !== null)
			{
				$link->{$rule['field']} = $this->input->post($rule['field']);
			}
		}

		// Get Pages and create pages tree
		$this->template->tree_select = $this->_build_tree_select(array('current_parent' => $link->page_id));

		// Render the view
		$this->template
			->set_layout(false)
			->build('admin/ajax/form', compact('link', 'group_options'));
	}

	/**
	 * Delete an existing navigation link
	 *
	 * @param int $id The ID of the navigation link
	 */
	public function delete($id = 0)
	{
		$id_array = (!empty($id)) ? array($id) : $this->input->post('action_to');

		// Loop through each item to delete
		if(!empty($id_array))
		{
			foreach ($id_array as $id)
			{
				$this->navigation_m->delete_link($id);
			}

			Events::trigger('post_navigation_delete', $id_array);
		}
		// Flush the cache and redirect
		$this->pyrocache->delete_all('navigation_m');
		$this->session->set_flashdata('success', $this->lang->line('nav:link_delete_success'));
		redirect('admin/navigation');
	}

	/**
	 * Tree select function
	 *
	 * Creates a tree to form select
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public function _build_tree_select($params)
	{
		$params = array_merge(array(
			'tree'			=> array(),
			'parent_id'		=> 0,
			'current_parent'=> 0,
			'current_id'	=> 0,
			'level'			=> 0
		), $params);

		extract($params);

		if ( ! $tree)
		{
			if ($pages = $this->db->select('id, parent_id, title')->get('pages')->result())
			{
				foreach($pages as $page)
				{
					$tree[$page->parent_id][] = $page;
				}
			}
		}

		if ( ! isset($tree[$parent_id]))
		{
			return;
		}

		$html = '';

		foreach ($tree[$parent_id] as $item)
		{
			if ($current_id == $item->id)
			{
				continue;
			}

			$html .= '<option value="' . $item->id . '"';
			$html .= $current_parent == $item->id ? ' selected="selected">': '>';

			if ($level > 0)
			{
				for ($i = 0; $i < ($level*2); $i++)
				{
					$html .= '&nbsp;';
				}

				$html .= '-&nbsp;';
			}

			$html .= $item->title . '</option>';

			$html .= $this->_build_tree_select(array(
				'tree'			=> $tree,
				'parent_id'		=> (int) $item->id,
				'current_parent'=> $current_parent,
				'current_id'	=> $current_id,
				'level'			=> $level + 1
			));
		}

		return $html;
	}

	/**
	 * Validate the link value.
	 *
	 * Only the URI field may be submitted blank.
	 *
	 * @param string $link The link value
	 * @return bool
	 */
	public function _link_check($link)
	{
		$status = true;

		switch ($link) {

			case 'url':
				$status = ($this->input->post('url') > '' AND $this->input->post('url') !== 'http://');
			break;

			case 'module':
				$status = ($this->input->post('module_name') > '');
			break;

			case 'page':
				$status = ($this->input->post('page_id') > '');
			break;
		}

		if ( ! $status)
		{
			$this->form_validation->set_message('_link_check', sprintf(lang('nav:choose_value'), lang('nav:'.$link.'_label')));
			return false;
		}
		return true;
	}
}