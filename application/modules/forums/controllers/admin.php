<?php

class Admin extends Controller {
	
	var $user_table = 'fa_user';
	
	function Admin()
	{
		parent::Controller();
		$this->freakauth_light->check('admin');
		
		$this->load->library('rapyd');
		$this->load->helper('url');
	
		$this->load->model('forum_model');
		//$this->load->model('action_model');
		
		$this->template->navigation(array(
			'Manage Categories' => 'forums/admin/categories',
			'Manage Forums' => 'forums/admin/forums'
		));
	}
	
	##### index #####
	function index()
	{
		echo anchor('forums/admin/categories', 'Edit Categories').' | '. anchor('forums/admin/forums', 'Edit Forums');
	}

	##### datagrid #####
	function categories()
	{
		$data['pagetitle'] = 'Category List';
		
		//datagrid//
		$this->rapyd->load('datafilter', 'datagrid');

		$add_link  = 'forums/admin/manage_category/create';	
		$edit_link = 'forums/admin/manage_category/modify/<#categoryID#>';
		$delete_link = 'forums/admin/manage_category/delete/<#categoryID#>';
		$show_link = 'forums/category/<#categoryID#>';
	
		$grid = new DataGrid($data['pagetitle'], $this->forum_model->category_table);
		$grid->per_page = 20;
		$grid->use_function('callback__ban_option');

		$grid->column('ID', 'categoryID'); 
		$grid->column('Category Name', anchor($show_link, '<#category_name#>', 'target="_blank"'));
			
		$grid->column('Options', anchor($edit_link, 'Modify') .' | '
							   . anchor($delete_link, 'Delete'));
		
		$grid->add($add_link);
	
		$grid->build();
	
		$data['filter'] = '';
		$data['grid'] = $grid->output;
		//enddatagrid//
		

    	$this->template->create('crud_list', $data);
	}


	function manage_category($action='create', $categoryID = 0)
	{  
		$data['pagetitle'] = 'Category Details';
				
		//dataedit//
		$this->rapyd->load('dataedit');
		
		$edit = new DataEdit($data['pagetitle'], $this->forum_model->category_table);
		$edit->back_uri = 'forums/admin/categories';
		
		$edit->user_name = new inputField('Category Name', 'category_name');
		$edit->user_name->rule = 'trim|required|max_length[50]';
		
		/* $edit->role = new dropdownField('Role', 'role');
		foreach($this->config->item('FAL_roles') as $name => $weight):
			$edit->role->option($name, ucfirst($name));
		endforeach;
		*/
						
		// Record the action
		$edit->post_process('insert', '_record_action');
		$edit->post_process('update', '_record_action');
		$edit->post_process('delete', '_record_action');
		
		// Set the buttons
		$edit->buttons('modify', 'save', 'undo', 'delete', 'back');
		
		$edit->build();
		
		$data['form'] = $edit->output;
		
		$this->template->create('crud_form', $data);
	}
	
	
	##### datagrid #####
	function forums()
	{
		$data['pagetitle'] = 'Forum List';
		
		//datagrid//
		$this->rapyd->load('datafilter', 'datagrid');

		$add_link  = 'forums/admin/manage_forum/create';	
		$edit_link = 'forums/admin/manage_forum/modify/<#forumID#>';
		$delete_link = 'forums/admin/manage_forum/delete/<#forumID#>';
		$show_link = 'forums/forum/<#forumID#>';
	
		$grid = new DataGrid($data['pagetitle']);
		$grid->per_page = 20;
		$grid->db->from($this->forum_model->forum_table .' f');
		$grid->db->join($this->forum_model->category_table .' c', 'c.categoryID=f.categoryID', 'LEFT');

		$grid->column('ID', 'forumID'); 
		$grid->column('Forum Name', anchor($show_link, '<#forum_name#>', 'target="_blank"'));
			
		$grid->column('Options', anchor($edit_link, 'Modify') .' | '
							   . anchor($delete_link, 'Delete'));
		
		$grid->add($add_link);
	
		$grid->build();
	
		$data['filter'] = '';
		$data['grid'] = $grid->output;
		//enddatagrid//
		

    	$this->template->create('crud_list', $data);
	}
	
	
	function manage_forum($action='create', $forumID = 0)
	{  
		$data['pagetitle'] = 'Forum Details';
				
		//dataedit//
		$this->rapyd->load('dataedit');
		
		$edit = new DataEdit($data['pagetitle'], $this->forum_model->forum_table);
		$edit->back_uri = 'forums/admin/forums';
		
		$edit->forum_name = new inputField('Forum Name', 'forum_name');
		$edit->forum_name->rule = 'trim|required|max_length[50]';
		
		$edit->category = new dropdownField('Category', 'categoryID');
		$edit->category->rule = 'trim|required|numeric';
		foreach($this->forum_model->getCategories() as $cat):
			$edit->category->option($cat['categoryID'], $cat['category_name']);
		endforeach;
		
		$edit->description = new textareaField('Description', 'forum_description');
		$edit->description->rule = 'trim|required|min_length[10]|max_length[255]';
		
						
		// Record the action
		$edit->post_process('insert', '_record_action');
		$edit->post_process('update', '_record_action');
		$edit->post_process('delete', '_record_action');
		
		// Set the buttons
		$edit->buttons('modify', 'save', 'undo', 'delete', 'back');
		
		$edit->build();
		
		$data['form'] = $edit->output;
		
		$this->template->create('crud_form', $data);
	}
	
	
	function _record_action($object)
	{
		//$this->action_model->logAction($this->uri->segment(4), 'user', $object->get('id'));
	}
}
?>
