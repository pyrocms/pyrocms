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
		$this->load->library('users/ion_auth');
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
 		$this->data->modules = $this->modules_m->get_modules();
		
		$this->load->model('comments/comments_m');
		$this->load->model('pages/pages_m');
		$this->load->model('users/users_m');
		
		$this->lang->load('comments/comments');
		
		$this->data->recent_users = $this->users_m->get_recent(5);
		
		$recent_comments = $this->comments_m->get_recent(5);
		$this->data->recent_comments = process_comment_items($recent_comments);
		
		// Dashboard RSS feed (using SimplePie)
		$this->load->library('simplepie');
		$this->simplepie->set_cache_location(APPPATH . 'cache/simplepie/');
		$this->simplepie->set_feed_url( $this->settings->item('dashboard_rss') );
		$this->simplepie->init();
		$this->simplepie->handle_content_type();
		
		// Store the feed items
		$this->data->rss_items = $this->simplepie->get_items(0, $this->settings->item('dashboard_rss_count'));

		$this->template->set_partial('sidebar', 'admin/partials/sidebar', FALSE);
		
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
	    if ($this->validation->run() or $this->ion_auth->logged_in())
	    {
	    	redirect('admin');
		}
				
	    $this->template->set_layout(FALSE);
	    $this->template->build('admin/login', $this->data);		
	}
	
	function logout()
	{
		$this->ion_auth->logout();
		redirect('admin/login');
	}	
	
	// Callback From: login()
	function _check_login($email)
	{		
   		if ( ! $this->ion_auth->login($email, $this->input->post('password')))
   		{
	   		$this->validation->set_message('_check_login', $this->ion_auth->errors());
	    	return FALSE;
	    }
	    
	    return TRUE;
	}    
}
?>