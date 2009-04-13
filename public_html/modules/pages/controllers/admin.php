<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller {

	// Validation rules to be used for create and edita
	private $rules = array(
        'title' 	=> 'trim|required|max_length[40]',
        'slug' 		=> 'trim|required|alpha_dash|max_length[20]|callback__check_slug',
        'body' 		=> 'trim|required',
        'parent' 	=> 'trim|callback__check_parent',
        'lang' 		=> 'trim|required|min_length[2]|max_length[2]'
	);
	
	// Used to pass page id to edit validation callback
	private $page_id;
	
    function __construct() {
        parent::Admin_Controller();
        $this->load->model('pages_m');
		$this->load->helper('pages');
		
        $this->load->module_model('navigation', 'navigation_m');
    }

    // Admin: List all Pages
    function index() {
    	
    	$this->data->languages =& $this->config->item('supported_languages');
    	
        $this->data->pages = $this->pages_m->getPages(array('lang' => 'all', 'order' => 'title'));
        $this->layout->create('admin/index', $this->data);
    }
    
    // Admin: Create a new Page
    function create() {

        $this->load->library('validation');

        $this->validation->set_rules($this->rules);
        $this->validation->set_fields();
        
        $spaw_cfg = array('name'=>'body', 'content'=>$this->validation->body);
        $this->load->library('spaw', $spaw_cfg);
		// setting directories for a SPAW editor instance:
		$this->spaw->setConfigItem(
			'PG_SPAWFM_DIRECTORIES',
			  array(
			    array(
			      'dir'     => '/uploads/pages/flash/',
			      'caption' => 'Flash movies', 
			      'params'  => array(
			        'allowed_filetypes' => array('flash')
			      )
			    ),
			    array(
			      'dir'     => '/uploads/pages/images/',
			      'caption' => 'Images',
			      'params'  => array(
			        'default_dir' => true, // set directory as default (optional setting)
			        'allowed_filetypes' => array('images')
			      )
			    ),
			  ),
			  SPAW_CFG_TRANSFER_SECURE
		);

		// Validate the page
        if ($this->validation->run())
        {
            if ( $this->pages_m->newPage($_POST) > 0 )
            {
                $this->session->set_flashdata('success', 'The page was created.');
            }
            
            else
            {
            	$this->session->set_flashdata('notice', 'That page has not been created.');
            }
            
            redirect('admin/pages/index');
        }

    	// Get the data back to the form
        foreach(array_keys($this->rules) as $field)
        {
        		$this->data->page->$field = isset($this->validation->$field) ? $this->validation->$field : '';
        }
        
        // Send an array of languages to the view
    	$this->data->languages =& $this->config->item('supported_languages');
    	
		// Get Pages and create pages tree
    	$tree = array();
    	$this->data->pages = $this->pages_m->getPages();
    	foreach(@$this->data->pages AS $data)
    	{
    		$tree[$data->parent][] = $data;
    	}
    	$this->data->pages = $tree;
    	
        $this->layout->create('admin/form', $this->data);
    }

    // Admin: Edit a Page
    function edit($id = 0) {
    	
    	if (empty($id)) redirect('admin/pages/index');
        
    	$this->page_id = $id;
    	
        $this->data->page = $this->pages_m->getPage( array('id' => $id) );
        if (!$this->data->page) 
        {
        	$this->session->set_flashdata('success', 'That page does not exist.');
        	redirect('admin/pages/create');
        }

        // Get Pages and create pages tree
    	$tree = array();
    	$this->data->pages = $this->pages_m->getPages();
    	foreach($this->data->pages AS $data)
    	{
    		$tree[$data->parent][] = $data;
    	}
    	$this->data->pages = $tree;

        $this->load->library('validation');
        $this->validation->set_rules($this->rules);
        $this->validation->set_fields();

        foreach(array_keys($this->rules) as $field) {
        	if(isset($_POST[$field]))
        		$this->data->page->$field = $this->validation->$field;
        }
        
        $spaw_cfg = array('name'=>'body', 'content'=>$this->data->page->body);
        $this->load->library('spaw', $spaw_cfg);
		// setting directories for a SPAW editor instance:
		$this->spaw->setConfigItem(
			'PG_SPAWFM_DIRECTORIES',
			  array(
			    array(
			      'dir'     => '/uploads/pages/flash/',
			      'caption' => 'Flash movies', 
			      'params'  => array(
			        'allowed_filetypes' => array('flash')
			      )
			    ),
			    array(
			      'dir'     => '/uploads/pages/images/',
			      'caption' => 'Images',
			      'params'  => array(
			        'default_dir' => true, // set directory as default (optional setting)
			        'allowed_filetypes' => array('images')
			      )
			    ),
			  ),
			  SPAW_CFG_TRANSFER_SECURE
		);
        
        if ($this->validation->run())
        {
			$this->pages_m->updatePage($id, $_POST);
			$this->session->set_flashdata('success', 'The page was saved.');

			redirect('admin/pages/index');
        }
        
        // Send an array of languages to the view
    	$this->data->languages =& $this->config->item('supported_languages');
    	
        $this->layout->create('admin/form', $this->data);
    }
    
    // Admin: Delete Pages
    function delete($id = 0) {
		
    	// Delete one
		$ids = ($id) ? array($id) : array_keys($this->input->post('delete'));
			
		// Go through the array of slugs to delete
		$page_titles = array();
		foreach ($ids as $id):
			
			// Get the current page so we can grab the id too
			if($page = $this->pages_m->getPage( array('id' => $id) ) )
			{
				if ($page->slug != 'home')
				{
					$this->pages_m->deletePage($id);
					$this->navigation_m->deleteLink(array('page_id' => $id));
					
					$page_titles[] = $page->title;
				}
				
				else
				{
					$this->session->set_flashdata('error', 'You can not delete the home page!');
				}
			}
			
		endforeach;

		// Some pages have been deleted
		if(!empty($page_titles))
		{
			// Only deleting one page
			if( count($page_titles) == 1 )
			{
				$this->session->set_flashdata('success', 'The page "'. $page_titles[0] .'" has been deleted.');
			}
			
			// Deleting multiple pages
			else
			{
				$this->session->set_flashdata('success', 'The pages "'. implode('", "', $page_titles) .'" have been deleted.');
			}
		}
		
		redirect('admin/pages/index');
    }
    
    // Callback: From create()
    function _check_slug($slug) {
        
    	$criteria = array('slug' => $slug, 'lang' => $this->input->post('lang'));
    	
    	$page = $this->pages_m->getPage( $criteria );
    	
    	$languages =& $this->config->item('supported_languages');
    	
    	if ( $page && $page->id != $this->page_id ) {
            $this->validation->set_message('_check_slug', 'A page with the URL "'.$slug.'" already exists in '.$languages[$this->input->post('lang')].'.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

	// Callback: From create() && edit()
    function _check_parent($parent_id)
    {
    	if(empty($parent_id))
    	{
    		return TRUE;
    	} elseif (!$this->pages_m->getPage(array('id'=>$parent_id)) ) {
            $this->validation->set_message('_check_parent', 'The parent page you have selected does not exist.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

?>