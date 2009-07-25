<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	// Validation rules to be used for create and edita
	private $rules = array(
	  	'title' 			=> 'trim|required|max_length[60]',
	    'slug' 				=> 'trim|required|alpha_dash|max_length[60]|callback__check_slug',
	    'body' 				=> 'trim|required',
	    'parent' 			=> 'trim|callback__check_parent',
	    'lang' 				=> 'trim|required|min_length[2]|max_length[2]',
	    'layout_file' 		=> 'trim|alphadash|required',
		'meta_title' 		=> 'trim|max_length[255]',
	    'meta_keywords' 	=> 'trim|max_length[255]',
	    'meta_description' 	=> 'trim'
	);
	
	// Used to pass page id to edit validation callback
	private $page_id;
	
	function __construct()
	{
  		parent::Admin_Controller();
    	$this->load->model('pages_m');
		$this->load->helper('pages');
		$this->load->module_model('navigation', 'navigation_m');
		$this->lang->load('pages');	
	}

	// Admin: List all Pages
	function index()
	{
  		$this->data->languages =& $this->config->item('supported_languages');
		$this->data->pages = $this->pages_m->getPages(array('lang' => 'all', 'order' => 'title'));
    	$this->layout->create('admin/index', $this->data);
 	}
    
	// Admin: Create a new Page
	function create()
	{
  		$this->load->library('validation');
		$this->validation->set_rules($this->rules);
    	$this->validation->set_fields();
        
		// Validate the page
    	if ($this->validation->run())
	    {
	    	if ( $this->pages_m->newPage($_POST) > 0 )
	    	{
	      		$this->session->set_flashdata('success', $this->lang->line('pages_create_success'));
	    	}
	      
	    	else
	    	{
	     		$this->session->set_flashdata('notice', $this->lang->line('pages_create_error'));
	    	}
	    	
	    	redirect('admin/pages/index');
	    }
		
		// Get the data back to the form
	    foreach(array_keys($this->rules) as $field)
	    {
	    	$this->data->page->$field = isset($this->validation->$field) ? $this->validation->$field : '';
	    }
	        
	    // Send an array of languages to the view
	    $this->data->languages = array();
	    foreach($this->config->item('supported_languages') as $lang_code => $lang)
	    {
	    	$this->data->languages[$lang_code] = $lang['name'];
	    }
	    	
		// Get Pages and create pages tree
	    $tree = array();
	    if($pages = $this->pages_m->getPages())
	    {
			foreach(@$pages AS $data)
			{
				$tree[$data->parent][] = $data;
			}
		}
		unset($pages);
	    $this->data->pages = $tree;
			    	
	    // Load WYSIWYG editor
		$this->layout->extra_head( $this->load->view('fragments/wysiwyg', $this->data, TRUE) );		
	    $this->layout->create('admin/form', $this->data);
	}

	// Admin: Edit a Page
	function edit($id = 0)
	{
		if (empty($id))
	    {
	    	redirect('admin/pages/index');
	    }
	        
	    // We use this controller property for a validation callback later on
	    $this->page_id = $id;
	    
	    // Set data, if it exists
	    if (!$this->data->page = $this->pages_m->getById($id)) 
	    {
			$this->session->set_flashdata('error', $this->lang->line('pages_page_not_found_error'));
			redirect('admin/pages/create');
	    }
			
	    // Get Pages and create pages tree
	    $tree = array();
	    $this->data->pages = $this->pages_m->getPages();
	    if(!empty($this->data->pages))
	    {
		    foreach($this->data->pages as $data)
		    {
		    	$tree[$data->parent][] = $data;
		    }
		    $this->data->pages = $tree;
	    }
	    	
	    $this->load->library('validation');
	    $this->validation->set_rules($this->rules);
	    $this->validation->set_fields();
		
	    // Auto-set data for the page if a post variable overrides it
	    foreach(array_keys($this->rules) as $field)
	    {
	    	if(isset($_POST[$field])) $this->data->page->$field = $this->validation->$field;
	    }
	    
	    // Give validation a try, who knows, it just might work!
		if ($this->validation->run())
	    {
			// Run the update code with the POST data	
	    	$this->pages_m->updatePage($id, $_POST);			
				
			// Wipe cache for this model as the data has changed
			$this->cache->delete_all('pages_m');			
			$this->session->set_flashdata('success', sprintf($this->lang->line('pages_edit_success'), $this->input->post('title')));
			redirect('admin/pages/index');
	    }
	    
		// Send an array of languages to the view
	    $this->data->languages = array();
	    foreach($this->config->item('supported_languages') as $lang_code => $lang)
	    {
	    	$this->data->languages[$lang_code] = $lang['name'];
	    }
	    	
		// Load WYSIWYG editor
		$this->layout->extra_head( $this->load->view('fragments/wysiwyg', $this->data, TRUE) );		
	    $this->layout->create('admin/form', $this->data);
	}
    
	// Admin: Delete Pages
	function delete($id = 0)
	{
		// Attention! Error of no selection not handeled yet.
		$ids = ($id) ? array($id) : $this->input->post('action_to');
		
		if(!empty($ids))
		{
			// Go through the array of slugs to delete
			$page_titles = array();
			foreach ($ids as $id)
			{
				// Get the current page so we can grab the id too
				if($page = $this->pages_m->getById($id) )
				{
					if ($page->slug != 'home')
					{
						$this->pages_m->deletePage($id);
						$this->navigation_m->deleteLink(array('page_id' => $id));					
						// Wipe cache for this model, the content has changd
						$this->cache->delete_all('pages_m');
						$this->cache->delete_all('navigation_m');			
						$page_titles[] = $page->title;
					}				
					else
					{
						$this->session->set_flashdata('error', $this->lang->line('pages_delete_home_error'));
					}
				}
			}
		}
			
		// Some pages have been deleted
		if(!empty($page_titles))
		{
			// Only deleting one page
			if( count($page_titles) == 1 )
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('pages_delete_success'), $page_titles[0]));
			}			
			else // Deleting multiple pages
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('pages_mass_delete_success'), implode('", "', $page_titles)));
			}
		}		
		else // For some reason, none of them were deleted
		{
			$this->session->set_flashdata('notice', $this->lang->line('pages_delete_none_notice'));
		}		
		redirect('admin/pages/index');
	}
    
	// Callback: From create()
	function _check_slug($slug)
	{
	  	$page = $this->pages_m->getBySlug($slug, $this->input->post('lang'));
	    $languages =& $this->config->item('supported_languages');
	    	
	    if($page && $page->id != $this->page_id )
			{
	    	$this->validation->set_message('_check_slug', sprintf($this->lang->line('pages_page_already_exist_error'), $slug, $languages[$this->input->post('lang')]['name']));
	      return FALSE;
	    }
			else
			{
	     	return TRUE;
	    }
	}

	// Callback: From create() && edit()
	function _check_parent($parent_id)
	{
	  	if(empty($parent_id))
	    {
	    	return TRUE;
	    }
		
	    elseif(!$this->pages_m->getById($parent_id))
		{
	    	$this->validation->set_message('_check_parent', $this->lang->line('pages_parent_not_exist_error'));
	    	return FALSE;
	    }
		
	    else
		{
	    	return TRUE;
	    }
	}
}
?>