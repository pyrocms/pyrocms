<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin controller for the navigation module. Handles actions such as editing links or creating new ones.
 *
 * @package 		PyroCMS
 * @subpackage 		Navigation module
 * @category		Modules
 * @author			Phil Sturgeon - PyroCMS Development Team
 *
 */
class Admin extends Admin_Controller
{
	/**
	 * The array containing the rules for the navigation items
	 * @var array
	 * @access private
	 */
	private $validation_rules 	= array();

	/**
	 * Constructor method
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		// Call the parent's contstructor
		parent::__construct();

		// Load the required classes
		$this->load->library('form_validation');
		$this->load->model('navigation_m');
		$this->load->model('pages/pages_m');
		$this->lang->load('navigation');

	    $this->template->set_partial('shortcuts', 'admin/partials/shortcuts');
	    $this->template->append_metadata( js('navigation.js', 'navigation') );

		// Get Navigation Groups
		$this->data->groups 		= $this->navigation_m->get_groups();
		$this->data->groups_select 	= array_for_select($this->data->groups, 'id', 'title');
		$modules 					= $this->module_m->get_all(array('is_frontend'=>true));
		$this->data->modules_select = array_for_select($modules, 'slug', 'name');

		// Get Pages and create pages tree
		$tree = array();

		if($pages = $this->pages_m->get_all())
		{
			foreach($pages AS $page)
			{
				$tree[$page->parent_id][] = $page;
			}
		}

		unset($pages);
		$this->data->pages_select = $tree;

		// Set the validation rules for the navigation items
		$this->validation_rules = array(
			array(
				'field' => 'title',
				'label'	=> lang('nav_title_label'),
				'rules'	=> 'trim|required|max_length[40]'
			),
			array(
				'field' => 'link_type',
				'label'	=> lang('nav_type_label'),
				'rules'	=> 'trim|alpha'
			),
			array(
				'field' => 'url',
				'label'	=> lang('nav_url_label'),
				'rules'	=> 'trim'
			),
			array(
				'field' => 'uri',
				'label'	=> lang('nav_uri_label'),
				'rules'	=> 'trim'
			),
			array(
				'field' => 'module_name',
				'label'	=> lang('nav_module_label'),
				'rules'	=> 'trim|alpha_dash'
			),
			array(
				'field' => 'page_id',
				'label'	=> lang('nav_page_label'),
				'rules'	=> 'trim|numeric'
			),
			array(
				'field' => 'navigation_group_id',
				'label'	=> lang('nav_group_label'),
				'rules'	=> 'trim|numeric|required'
			),
			array(
				'field' => 'target',
				'label'	=> lang('nav_target_label'),
				'rules'	=> 'trim|max_length[10]'
			),
		);

		$this->form_validation->set_rules($this->validation_rules);
	}

	/**
	 * List all navigation elements
	 * @access public
	 * @return void
	 */
	public function index()
	{
		// Go through all the groups
		foreach($this->data->groups as $group)
		{
			//... and get navigation links for each one
			$this->data->navigation[$group->abbrev] = $this->navigation_m->get_links(array('group'=>$group->id, 'order'=>'position, title'));
		}

		// Create the layout
		$this->template
			->title($this->module_details['name'])
			->build('admin/index', $this->data);
	}

	/**
	 * Create a new navigation item
	 * @access public
	 * @return void
	 */
	public function create()
	{
		// Run if valid
		if ($this->form_validation->run())
		{
			// Got post?
			if ($this->navigation_m->insert_link($_POST) > 0)
			{
				$this->cache->delete_all('navigation_m');
				$this->session->set_flashdata('success', lang('nav_link_add_success'));
			}
			else
			{
				$this->session->set_flashdata('error', lang('nav_link_add_error'));
			}

			// Redirect
			redirect('admin/navigation');
		}

		// Loop through each validation rule
		foreach($this->validation_rules as $rule)
		{
			$navigation_link->{$rule['field']} = set_value($rule['field']);
		}

		// Render the view
		$this->data->navigation_link =& $navigation_link;
		$this->template
			->title($this->module_details['name'],lang('nav_link_create_title'))
			->build('admin/links/form', $this->data);
	}

	/**
	 * Edit a navigation item
	 * @access public
	 * @param int $id The ID of the navigation item
	 * @return void
	 */
	public function edit($id = 0)
	{
		// Got ID?
		if (empty($id))
		{
			redirect('admin/navigation');
		}

		// Get the navigation item based on the ID
		$navigation_link = $this->navigation_m->get_link($id);

		if (!$navigation_link)
		{
			$this->session->set_flashdata('error', $this->lang->line('nav_link_not_exist_error'));
			redirect('admin/navigation/create');
		}

		// Valid data?
		if ($this->form_validation->run())
		{
			// Update the link and flush the cache
			$this->navigation_m->update_link($id, $_POST);
			$this->cache->delete_all('navigation_m');

			// Notify and redirect
			$this->session->set_flashdata('success', lang('nav_link_edit_success'));
			redirect('admin/navigation');
		}

		// Loop through each rule
		foreach($this->validation_rules as $rule)
		{
			if($this->input->post($rule['field']) !== FALSE)
			{
				$navigation_link->{$rule['field']} = $this->input->post($rule['field']);
			}
		}

		// Render the view
		$this->data->navigation_link =& $navigation_link;
		$this->template
			->title($this->module_details['name'], sprintf(lang('nav_link_edit_title'), $navigation_link->title))
			->build('admin/links/form', $this->data);
	}

	/**
	 * Delete an existing navigation link
	 * @access public
	 * @param int $id The ID of the navigation link
	 * @return void
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
		}
		// Flush the cache and redirect
		$this->cache->delete_all('navigation_m');
		$this->session->set_flashdata('success', $this->lang->line('nav_link_delete_success'));
		redirect('admin/navigation');
	}

	/**
	 * Update the position of the navigation link
	 * @access public
	 * @return void
	 */
	function ajax_update_positions()
	{
		// Create an array containing the IDs
		$ids = explode(',', $this->input->post('order'));

		// Counter variable
		$i = 1;

		foreach($ids as $id)
		{
			// Update the position
			$this->navigation_m->update_link_position($id, $i);
			++$i;
		}

		// Flush the cache
		$this->cache->delete_all('navigation_m');
	}
}
?>
