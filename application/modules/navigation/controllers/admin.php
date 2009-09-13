<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	function __construct()
	{
		parent::Admin_Controller();
		$this->load->model('navigation_m');
		$this->load->module_model('pages', 'pages_m');
		$this->load->module_helper('pages', 'pages');        
		$this->load->helper('array');		
		$this->lang->load('navigation');
		
		// Get Navigation Groups
		$this->data->groups = $this->navigation_m->getGroups();
		$this->data->groups_select = array_for_select($this->data->groups, 'id', 'title');				
		$modules = $this->modules_m->getModules(array('is_frontend'=>true));
		$this->data->modules_select = array_for_select($modules, 'slug', 'name');				
		// Get Pages and create pages tree
		$tree = array();
		
		if($pages = $this->pages_m->get())
		{
			foreach($pages AS $page)
			{
				$tree[$page->parent_id][] = $page;
			}
		}
	
		unset($pages);
		$this->data->pages_select = $tree;
	}
	
	// Admin: List all Pages
	function index()
	{
		// Go through all the groups 
		foreach($this->data->groups as $group)
		{
			//... and get navigation links for each one
			$this->data->navigation[$group->abbrev] = $this->navigation_m->getLinks(array('group'=>$group->id, 'order'=>'position, title'));
		}
		$this->layout->create('admin/index', $this->data);
	}
	
	// Admin: Create a new Page
	function create()
	{
		$this->load->library('validation');
		$rules['title'] = 'trim|required|max_length[40]';
		$rules['url'] = 'trim';
		$rules['uri'] = 'trim';
		$rules['module_name'] = 'trim|alpha_dash';
		$rules['page_id'] = 'trim|numeric';
		$rules['navigation_group_id'] = 'trim|numeric|required';
		$rules['position'] = 'trim|numeric|required';
		
		$this->validation->set_rules($rules);
		
		$fields['module_name'] = 'Module';
		$fields['page_id'] = 'Page';
		$fields['navigation_group_id'] = 'Group';
		
		$this->validation->set_fields($fields);
		
		if ($this->validation->run())
		{
			if ($this->navigation_m->newLink($_POST) > 0)
			{
				$this->cache->delete_all('navigation_m');
				$this->session->set_flashdata('success', $this->lang->line('nav_link_add_success'));
			}            
			else 
			{
				$this->session->set_flashdata('error', $this->lang->line('nav_link_add_error'));
			}
			redirect('admin/navigation/index');
		}
		
		foreach(array_keys($rules) as $field)
		{
			$this->data->navigation_link->$field = (isset($_POST[$field])) ? $this->validation->$field : '';
		}
		
		$this->layout->create('admin/links/form', $this->data);
	}
	
	// Admin: Edit a Page
	function edit($id = 0)
	{
		if (empty($id)) redirect('admin/navigation/index');
		
		$this->data->navigation_link = $this->navigation_m->getLink( $id );
		if (!$this->data->navigation_link) 
		{
			$this->session->set_flashdata('error', $this->lang->line('nav_link_not_exist_error'));
			redirect('admin/navigation/create');
		}
		
		$this->load->library('validation');
		
		$rules['title'] = 'trim|required|max_length[40]';
		$rules['url'] = 'trim';
		$rules['uri'] = 'trim';
		$rules['module_name'] = 'trim|alpha_dash';
		$rules['page_id'] = 'trim|numeric';
		$rules['navigation_group_id'] = 'trim|numeric|required';
		$rules['position'] = 'trim|numeric|required';
		
		$this->validation->set_rules($rules);
		
		$fields['module_name'] = 'Module';
		$fields['page_id'] = 'Page';
		$fields['navigation_group_id'] = 'Group';
		
		$this->validation->set_fields($fields);
		
		if ($this->validation->run())
		{
			$this->navigation_m->updateLink($id, $_POST);
			$this->cache->delete_all('navigation_m');
					
			$this->session->set_flashdata('success', $this->lang->line('nav_link_edit_success'));
			redirect('admin/navigation/index');
		}
		
		foreach(array_keys($rules) as $field)
		{
			if(isset($_POST[$field]))
			{
				$this->data->navigation_link->$field = $this->validation->$field;
			}
		}
		
		$this->layout->create('admin/links/form', $this->data);
	}
	
	// Admin: Delete Pages
	function delete($id = 0)
	{
		// Delete one
		if($id)
		{
			$this->navigation_m->deleteLink($id);
		}
		// Delete multiple
		else
		{		
			foreach (array_keys($this->input->post('delete')) as $id)
			{
				$this->navigation_m->deleteLink($id);
			}
		}
		
		$this->cache->delete_all('navigation_m');		
		$this->session->set_flashdata('success', $this->lang->line('nav_link_delete_success'));
		redirect('admin/navigation/index');
	}
}
?>
