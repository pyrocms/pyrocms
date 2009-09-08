<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	function __construct()
	{
  		parent::Admin_Controller();
		$this->load->module_library('users', 'user_lib');
		$this->load->module_language('users', 'user');
		$this->load->module_helper('users', 'user');
 	}

 	// Admin: Control Panel
 	function index()
	{
		// Load stuff
		$this->load->model('modules_m');
 		$this->data->modules = $this->modules_m->getModules();

		/**
		 * @author Yorick Peterse
		 * 
		 * Count certain things and display the results at the dashboar (might need some tweaking) 
		 */
		
		// Don't you love the smell of burning CPUs in the morning ?
		$this->load->module_model('comments','comments_m');
		$this->load->module_model('pages','pages_m');
		$this->load->module_model('news','news_m');
		$this->load->module_model('users','users_m');
		
		// Count comment related stuff
		$this->data->total_comments			= $this->comments_m->countComments();
		$this->data->approved_comments 		= $this->comments_m->countComments(array('is_active' => 1));
		$this->data->pending_comments	 	= $this->comments_m->countComments(array('is_active' => 0));
		
		// Count page related stuff
		$this->data->total_pages			= $this->pages_m->countPages();
		
		// Count the news articles
		$this->data->live_articles			= $this->news_m->countArticles(array('status' => 'live'));
		
		// Count users
		$this->data->total_users			= $this->users_m->countUsers(array('is_active' => 1));
		
		// Dashboard RSS feed (using SimplePie)
		$this->load->library('simplepie');
		$this->simplepie->set_cache_location(APPPATH . 'cache/simplepie/');
		$this->simplepie->set_feed_url( $this->settings->item('dashboard_rss') );
		$this->simplepie->init();
		$this->simplepie->handle_content_type();
		
		// Store the feed items
		$this->data->rss_items     			= $this->simplepie->get_items(0, $this->settings->item('dashboard_rss_count'));

		// Load the layout/view/whatever
		$this->layout->create('admin/cpanel', $this->data);
	}
     
	// Admin: Log in
	function login()
	{
		// Call validation and set rules
		$this->load->library('validation');
	    $rules['email'] = 'required|callback__check_login';
	    $rules['password'] = 'required';
	    $this->validation->set_rules($rules);
	    $this->validation->set_fields();
	        
	    // If the validation worked, or the user is already logged in
	    if ($this->validation->run() or $this->user_lib->logged_in())
	    {
	    	redirect('admin');
		}
				
	    $this->layout->wrapper(FALSE);
	    $this->layout->create('admin/login', $this->data);		
	}
	
	function logout()
	{
		$this->user_lib->logout();
		redirect('admin/login');
	}	
	
	// Callback From: login()
	function _check_login($email)
	{		
   		if ($this->user_lib->login($email, $this->input->post('password')))
	   	{
	     	return TRUE;
	    }
	    else
	    {
	   		$this->validation->set_message('_check_login', $this->lang->line($this->user_lib->error_code));
	    	return FALSE;
	    }
	}    
}
?>