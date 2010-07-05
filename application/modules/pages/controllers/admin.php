<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Pages controller
 * 
 * @author 		Phil Sturgeon - PyroCMS Dev Team
 * @modified	Yorick Peterse
 * @package 	PyroCMS
 * @subpackage 	Pages module
 * @category	Modules
 */
class Admin extends Admin_Controller
{
	/**
	 * Array containing the validation rules
	 * @access private
	 * @var array
	 */
	private $validation_rules = array();
	
	/**
	 * The ID of the page, used for the validation callback
	 * @access private
	 * @var int
	 */
	private $page_id;
	
	/**
	 * Constructor method
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		// Call the parent's constructor
		parent::Admin_Controller();
		
		// Load the required classes
		$this->load->library('form_validation');
		
		// Versioning
		$this->load->library('versioning');
		$this->versioning->set_table('pages');
		
		$this->load->model('pages_m');
		$this->load->model('page_layouts_m');
		$this->load->model('navigation/navigation_m');
		$this->lang->load('pages');
		$this->load->helper(array('array', 'pages'));
		
	    $this->template->set_partial('sidebar', 'admin/sidebar');
	
		// Large array is large
		$this->validation_rules = array(
			array(
				'field' => 'title',
				'label'	=> lang('pages.title_label'),
				'rules'	=> 'trim|required|max_length[60]'
			),
			array(
				'field' => 'slug',
				'label'	=> lang('pages.slug_label'),
				'rules'	=> 'trim|required|alpha_dot_dash|max_length[60]'
			),
			array(
				'field' => 'body',
				'label'	=> lang('pages.body_label'),
				'rules' => 'trim|required'
			),
			array(
				'field' => 'layout_id',
				'label'	=> lang('pages.layout_id_label'),
				'rules'	=> 'trim|numeric|required'
			),
			array(
				'field'	=> 'css',
				'label'	=> lang('pages.css_label'),
				'rules'	=> 'trim'
			),
			array(
				'field'	=> 'js',
				'label'	=> lang('pages.js_label'),
				'rules'	=> 'trim'
			),
			array(
				'field' => 'meta_title',
				'label' => lang('pages.meta_title_label'),
				'rules' => 'trim|max_length[255]'
			),
			array(
				'field'	=> 'meta_keywords',
				'label' => lang('pages.meta_keywords_label'),
				'rules' => 'trim|max_length[255]'
			),
			array(
				'field'	=> 'meta_description',
				'label'	=> lang('pages.meta_description_label'),
				'rules'	=> 'trim'
			),
			array(
				'field' => 'rss_enabled',
				'label'	=> lang('pages.rss_enabled_label'),
				'rules'	=> 'trim|numeric'
			),
			array(
				'field' => 'comments_enabled',
				'label'	=> lang('pages.comments_enabled_label'),
				'rules'	=> 'trim|numeric'
			),
			array(
				'field'	=> 'status',
				'label'	=> lang('pages.status_label'),
				'rules'	=> 'trim|alpha|required'
			),
		);
		
		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);
	}


	/**
	 * Index methods, lists all pages
	 * @access public
	 * @return void
	 */
	public function index()
	{
		// Get list of open parent pages from cookie
		$open_parent_pages = isset($_COOKIE['page_parent_ids']) ? explode(',', '0,'.$_COOKIE['page_parent_ids']) : array(0);

		// Get the page tree
		$this->data->page_tree_html = $this->recurse_page_tree(0, $open_parent_pages);
		
		$this->template
			->append_metadata( css('jquery/jquery.treeview.css') )
			->append_metadata( js('jquery/jquery.treeview.min.js') )
			->append_metadata( js('index.js', 'pages') )
			->append_metadata( css('index.css', 'pages') )
			->build('admin/index', $this->data);
	}
	
	/**
	 * Fetch the children using Ajax
	 * @access public
	 * @param int $parent_id The ID of the parent page
	 * @return void 
	 */
	public function ajax_fetch_children($parent_id)
	{
		// get list of open parent pages from cookie
		$open_parent_pages 	= isset($_COOKIE['page_parent_ids']) ? explode(',', '0,'.$_COOKIE['page_parent_ids']) : array(0);
		$pages 				= $this->pages_m->get_many_by('parent_id', $parent_id);
	
		foreach($pages as &$page)
		{
			$page->has_children = $this->pages_m->has_children($page->id);
		}
		
		$this->data->open_parent_pages 	= $open_parent_pages;
		$this->data->controller 		=& $this;
		$this->data->pages 				=& $pages;
		$this->load->view('admin/ajax/child_list', $this->data);
	}
	
	/**
	 * Get the details of a page using Ajax
	 * @access public
	 * @param int $page_id The ID of the page
	 * @return void
	 */
	public function ajax_page_details($page_id)
	{
		$page 			= $this->pages_m->get($page_id);
		$page->path 	= $this->pages_m->get_path_by_id($page_id);
		
		$this->load->view('admin/ajax/page_details', array('page' => $page));
	}

	/**
	 * Show the page tree
	 * @access public
	 * @param int $parent_id The ID of the parent
	 * @param array $open_parent_pages An array containing the parent pages
	 * @return mixed 
	 */
	public function recurse_page_tree($parent_id, $open_parent_pages=array())
	{
		if (!in_array($parent_id, $open_parent_pages))
		{
			return $this->pages_m->has_children($parent_id) ? '<ul></ul>' : '';
		}
		
		$pages = $this->pages_m->get_many_by('parent_id', $parent_id);
		if (!empty($pages))
		{
			foreach($pages as &$page)
			{
				$page->has_children = $this->pages_m->has_children($page->id);
			}
			
			$this->data->pages 				=& $pages;
			$this->data->controller 		=& $this;
			$this->data->open_parent_pages 	= $open_parent_pages;
			return $this->load->view('admin/ajax/child_list', $this->data, true);
		}
		return '';
	}
    
	/**
	 * Show a page preview
	 * @access public
	 * @param int $id The ID of the page
	 * @return void
	 */
	public function preview($id = 0)
	{		
		$data->page 		= $this->pages_m->get($id);
		$data->page->path 	= $this->pages_m->get_path_by_id($id);
		
		$this->template->set_layout('admin/basic_layout');
		$this->template->build('admin/preview', $data);
	}
	
	/**
	 * Create a new page
	 * @access public
	 * @param int $parent_id The ID of the parent page
	 * @return void
	 */
	public function create($parent_id = 0)
	{			
		// Validate the page
		if ($this->form_validation->run())
	    {
			// First create the page
			$page_body = $_POST['body'];
			unset($_POST['body']);
			$insert_id = $this->pages_m->create($_POST);
			
			if ( $insert_id > 0 )
			{
				// Create the revision
				$revision_id = $this->versioning->create_revision( array('author_id' => $this->user->id, 'owner_id' => $insert_id, 'body' => $page_body) );
				
				// Update the page row
				$to_update 					= $_POST;
				$to_update['revision_id'] 	= $revision_id; 
				
				if ( $this->pages_m->update($insert_id, $to_update ) )
				{
					$this->session->set_flashdata('success', $this->lang->line('pages_create_success'));
				}
			}
		      
			// Fail
			else
			{
				$this->session->set_flashdata('notice', $this->lang->line('pages_create_error'));
			}
			
			// Redirect
			redirect('admin/pages');
	    }

		// Loop through each rule
		foreach($this->validation_rules as $rule)
		{
			$page->{$rule['field']} = $this->input->post($rule['field']);
		}
		
	    // If a parent id was passed, fetch the parent details
	    if($parent_id > 0)
	    {
			$page->parent_id 	= $parent_id;
			$parent_page 		= $this->pages_m->get($parent_id);
			$parent_page->path 	= $this->pages_m->get_path_by_id($parent_id);
	    }
	    
	    // Assign data for display
	    $this->data->page 			=& $page;
	    $this->data->parent_page 	=& $parent_page;
	    
		$page_layouts 				= $this->page_layouts_m->get_all();
		$this->data->page_layouts 	= array_for_select($page_layouts, 'id', 'title');	
	    
	    // Load WYSIWYG editor
		$this->template
			->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			->append_metadata( js('codemirror/codemirror.js') )
			->append_metadata( js('form.js', 'pages') )
			->build('admin/form', $this->data);
	}

	/**
	 * Edit an existing page
	 * @access public
	 * @param int $id The ID of the page to edit
	 * @return void
	 */
	public function edit($id = 0)
	{
		// Redirect if no ID has been specified
		if (empty($id))
	    {
			redirect('admin/pages');
	    }
		
	    // Set the page ID and get the current page
	    $this->page_id 	= $id;
	    $page 			= $this->versioning->get($id);
		$revisions		= $this->versioning->get_revisions($id);
	
	    // Got page?
	    if (!$page) 
	    {
			$this->session->set_flashdata('error', lang('pages_page_not_found_error'));
			redirect('admin/pages/create');
	    }
	    
	    // Validate it
		if ($this->form_validation->run())
	    {
			// Set the data for the revision
			$revision_data 			= array('author_id' => $this->user->id, 'owner_id' => $id, 'body' => $_POST['body']);
			
			// Did the user wanted to restore a specific revision?
			if ( $_POST['use_revision_id'] == $page->revision_id )
			{
				$_POST['revision_id'] 	= $this->versioning->create_revision($revision_data);
			}
			// Manually restore a revision
			else
			{
				$_POST['revision_id'] = $_POST['use_revision_id'];
			}
			
			// Run the update code with the POST data	
			$this->pages_m->update($id, $_POST);			
			
			// The slug has changed
			if($this->input->post('slug') != $this->input->post('old_slug'))
			{
				$this->pages_m->reindex_descendants($id);
			}
			
			// Wipe cache for this model as the data has changed
			$this->cache->delete_all('pages_m');			
			
			// Set the flashdata message and redirect the user
			$this->session->set_flashdata('success', sprintf(lang('pages_edit_success'), $this->input->post('title')));
			redirect('admin/pages');
	    }

		// Loop through each validation rule
		foreach($this->validation_rules as $rule)
		{
			if($this->input->post($rule['field']) !== FALSE)
			{
				$page->{$rule['field']} = set_value($rule['field']);
			}
		}

	    // If a parent id was passed, fetch the parent details
	    if($page->parent_id > 0)
	    {
			$parent_page 		= $this->pages_m->get($page->parent_id);
			$parent_page->path 	= $this->pages_m->get_path_by_id($page->parent_id);
	    }
	    
	    // Assign data for display
	    $this->data->page 			=& $page;
		$this->data->revisions		=& $revisions;
	    $this->data->parent_page 	=& $parent_page;
	    
		$page_layouts 				= $this->page_layouts_m->get_all();
		$this->data->page_layouts 	= array_for_select($page_layouts, 'id', 'title');	
		
	    // Load WYSIWYG editor
		$this->template->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )

			// Load form specific JavaScript
			->append_metadata( js('codemirror/codemirror.js') )
			->append_metadata( js('form.js', 'pages') )
	    
			->build('admin/form', $this->data);
	}
    
	/**
	 * Delete an existing page
	 * @access public
	 * @param int $id The ID of the page to delete
	 * @return void
	 */
	public function delete($id = 0)
	{
		// Attention! Error of no selection not handeled yet.
		$ids = ($id) ? array($id) : $this->input->post('action_to');
		
		// Go through the array of slugs to delete
		foreach ($ids as $id)
		{
			if ($id !== 1)
			{
				$deleted_ids = $this->pages_m->delete($id);
				
				// Wipe cache for this model, the content has changd
				$this->cache->delete_all('pages_m');
				$this->cache->delete_all('navigation_m');			
			}
				
			else
			{
				$this->session->set_flashdata('error', lang('pages_delete_home_error'));
			}
		}
		
		// Some pages have been deleted
		if(!empty($deleted_ids))
		{
			// Only deleting one page
			if( count($deleted_ids) == 1 )
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
		
		// Redirect
		redirect('admin/pages');
	}
	
	/**
	 * Show a diff between two revisions
	 * 
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param int $id_1 The ID of the first revision to compare
	 * @param int $id_2 The ID of the second revision to compare
	 * @return void
	 */
	public function compare($id_1, $id_2)
	{
		// Create the diff using mixed mode
		$rev_1 = $this->versioning->get_by_revision($id_1);
		$rev_2 = $this->versioning->get_by_revision($id_2);
		$diff  = $this->versioning->compare_revisions($rev_1->body, $rev_2->body, 'mixed');
		
		// Output the results
		$data['difference'] = $diff;
		$this->load->view('admin/revisions/compare', $data);
	}
	
	/**
	 * Show a preview of a revision
	 *
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param int $id The ID of the revision to preview
	 * @return void
	 */
	public function preview_revision($id)
	{
		// Easy isn't it?
		$data['revision'] = $this->versioning->get_by_revision($id);
		$this->load->view('admin/revisions/preview', $data);
	}
}

