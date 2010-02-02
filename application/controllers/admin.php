<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @name 		Main admin controller
 * @author 		Phil Sturgeon and Yorick Peterse - PyroCMS Development Team
 * @package 	PyroCMS
 * @subpackage 	Controllers
 */
class Admin extends Admin_Controller
{
	function __construct()
	{
  		parent::Admin_Controller();
		$this->load->library('users/user_lib');
		$this->load->helper('users/user');
 	}

 	// Admin: Control Panel
 	function index()
	{
		if(is_dir('./installer'))
		{
			$this->data->messages['notice'] = lang('delete_installer_message');
		}
		
		// Load stuff
 		$this->data->modules = $this->modules_m->getModules();
		
		// Don't you love the smell of burning CPUs in the morning ?
		$this->load->model('comments/comments_m');
		$this->load->model('pages/pages_m');
		$this->load->model('news/news_m');
		$this->load->model('users/users_m');
		
		// Count comment related stuff
		$this->data->total_comments			= $this->comments_m->count_all();
		$this->data->approved_comments 		= $this->comments_m->count_by('is_active', 1);
		$this->data->pending_comments	 	= $this->comments_m->count_by('is_active', 0);
		
		// Count page related stuff
		$this->data->total_pages			= $this->pages_m->count();
		
		// Count the news articles
		$this->data->live_articles			= $this->news_m->count_by('status', 'live');
		
		// Count users
		$this->data->total_users			= $this->users_m->count_by('is_active', 1);
		
		// Dashboard RSS feed (using SimplePie)
		$this->load->library('simplepie');
		$this->simplepie->set_cache_location(APPPATH . 'cache/simplepie/');
		$this->simplepie->set_feed_url( $this->settings->item('dashboard_rss') );
		$this->simplepie->init();
		$this->simplepie->handle_content_type();
		
		// Store the feed items
		$this->data->rss_items     			= $this->simplepie->get_items(0, $this->settings->item('dashboard_rss_count'));

		$this->template->build('admin/dashboard', $this->data);
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
				
	    $this->template->set_layout(FALSE);
	    $this->template->build('admin/login', $this->data);		
	}
	
	function logout()
	{
		$this->user_lib->logout();
		redirect('admin/login');
	}	
	
	// Callback From: login()
	function _check_login($email)
	{		
   		if ( ! $this->user_lib->login($email, $this->input->post('password')))
   		{
	   		$this->validation->set_message('_check_login', $this->lang->line($this->user_lib->error_code));
	    	return FALSE;
	    }
	    
	    return TRUE;
	}    
}
?>