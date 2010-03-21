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
 		$this->data->modules = $this->modules_m->getModules();
		
		$this->load->model('comments/comments_m');
		$this->load->model('pages/pages_m');
		$this->load->model('users/users_m');
		
		$this->lang->load('comments/comments');
		
		$this->data->recent_users		= $this->users_m->get_recent(5);
		$this->data->recent_comments	= $this->comments_m->get_recent(5);
		
		foreach($this->data->recent_comments as &$comment)
		{
			// work out who did the commenting
			if($comment->user_id > 0)
			{
				$comment->name = anchor('admin/users/edit/' . $comment->user_id, $comment->name);
			}
			
			// What did they comment on
			switch($comment->module)
			{
				case 'news':
					$this->load->model('news/news_m');
					$article = $this->news_m->get($comment->module_id);
					$comment->item = anchor('admin/news/preview/' . $article->id, $article->title, 'class="modal-large"');
				break;
				
				case 'photos':
					$this->load->model('photos/photo_albums_m');
					$album = $this->photo_albums_m->get($comment->module_id);
					$comment->item = anchor('photos/' . $album->slug, $album->title, 'class="modal-large iframe"');
				break;
			
				default:
					$comment->item = $comment->module .' #'. $comment->module_id;
				break;
			}
			
			// Link to the comment
			if( strlen($comment->comment) > 30 )
			{
				$comment->comment = character_limiter($comment->comment, 30);
			}
		}
		
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
	   		$this->validation->set_message('_check_login', $this->lang->line($this->user_lib->error_code));
	    	return FALSE;
	    }
	    
	    return TRUE;
	}    
}
?>