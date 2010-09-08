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
		if(CMS_VERSION !== $this->settings->version)
		{
			$this->data->messages['notice'] = sprintf(lang('cp_upgrade_message'), CMS_VERSION, $this->settings->version, site_url('upgrade'));
		}

		else if(is_dir('./installer'))
		{
			$this->data->messages['notice'] = lang('cp_delete_installer_message');
		}

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
		$this->simplepie->set_feed_url($this->settings->dashboard_rss);
		$this->simplepie->init();
		$this->simplepie->handle_content_type();
		
		// Dashboard Analytics
		//$this->load->library('analytics');
		// Just use dummy data for now - we need more settings to make this work...
		// Note: Data will need to be in javascript timestamps (multiply unix timestamp by 1000)
		$times = array(
			time() - (7*24*60*60*5*1000),
			time() - (7*24*60*60*4*1000),
			time() - (7*24*60*60*3*1000),
			time() - (7*24*60*60*2*1000),
			time() - (7*24*60*60*1000)
		);
		$this->data->ga_visits = '[['. $times[0] .', 300], ['. $times[1] .', 800], ['. $times[2] .', 500], ['. $times[3] .', 800], ['. $times[4] .', 1300]]';
		
		$this->template->append_metadata(js('jquery/jquery.flot.js'));

		// Store the feed items
		$this->data->rss_items = $this->simplepie->get_items(0, $this->settings->dashboard_rss_count);

		$this->template->set_partial('sidebar', 'admin/partials/sidebar', FALSE);
		$this->template
			->title(lang('cp_admin_home_title'))
			->build('admin/dashboard', $this->data);
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
		$this->load->language('users/user');
		$this->ion_auth->logout();
		$this->session->set_flashdata('success', lang('user_logged_out'));
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
