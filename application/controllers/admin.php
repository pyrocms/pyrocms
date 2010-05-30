<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @name 		Main admin controller
 * @author 		Phil Sturgeon and Yorick Peterse - PyroCMS Development Team
 * @package 	PyroCMS
 * @subpackage 	Controllers
 */
class Admin extends Admin_Controller
{
	/**
	 * Validation rules
	 * 
	 * @var array
	 */
	private $validation_rules = array();
	
	/**
	 * Constructor method
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		// Call the parent's controller
  		parent::Admin_Controller();
		$this->load->helper('users/user');
		$this->lang->load('main');
		
		// Set the validation rules
		$this->validation_rules = array(
			array(
				'field' => 'email',
				'label'	=> lang('email_label'),
				'rules' => 'required|callback__check_login'
			),
			array(
				'field' => 'password',
				'label'	=> lang('password_label'),
				'rules' => 'required'
			)
		);
		
		// Call validation and set rules
		$this->load->library('form_validation');
	    $this->form_validation->set_rules($this->validation_rules);
 	}

 	/**
 	 * Show the control panel
	 *
	 * @access public
	 * @return void
 	 */
 	public function index()
	{
		if(CMS_VERSION !== $this->settings->item('version'))
		{
			$this->data->messages['notice'] = sprintf(lang('cp_upgrade_message'), CMS_VERSION, $this->settings->item('version'), site_url('upgrade'));
		}
		
		else if(is_dir('./installer'))
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
     
	/**
	 * Log in
	 *
	 * @access public
	 * @return void
	 */
	public function login()
	{	        
	    // If the validation worked, or the user is already logged in
	    if ($this->form_validation->run() or $this->ion_auth->logged_in())
	    {
	    	redirect('admin');
		}
				
	    $this->template->set_layout(FALSE);
	    $this->template->build('admin/login', $this->data);		
	}
	
	/**
	 * Logout
	 * 
	 * @access public
	 * @return void
	 */
	public function logout()
	{
		$this->ion_auth->logout();
		redirect('admin/login');
	}	
	
	/**
	 * Callback From: login()
	 *
	 * @access public
	 * @param string $email The Email address to validate
	 * @return bool
	 */
	public function _check_login($email)
	{		
   		if ( ! $this->ion_auth->login($email, $this->input->post('password')))
   		{
	   		$this->form_validation->set_message('_check_login', $this->ion_auth->errors());
	    	return FALSE;
	    }
	    
	    return TRUE;
	}    
}
?>