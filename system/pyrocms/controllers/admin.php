<?php defined('BASEPATH') OR exit('No direct script access allowed');
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
		if (is_dir('./installer'))
		{
			$data->messages['notice'] = lang('cp_delete_installer_message');
		}

		if ($this->settings->ga_email AND $this->settings->ga_password AND $this->settings->ga_profile)
		{
			// Not FALSE? Return it
			if ($cached_response = $this->cache->get('analytics'))
			{
				$data->analytic_visits = $cached_response['analytic_visits'];
				$data->analytic_views = $cached_response['analytic_views'];
			}

			else
			{
				try
				{
					$this->load->library('analytics', array(
						'username' => $this->settings->ga_email,
						'password' => $this->settings->ga_password
					));

					// Set by GA Profile ID if provided, else try and use the current domain
					$this->analytics->setProfileById('ga:'.$this->settings->ga_profile);

					$end_date = date('Y-m-d');
					$start_date = date('Y-m-d', strtotime('-1 month'));

					$this->analytics->setDateRange($start_date, $end_date);

					$visits = $this->analytics->getVisitors();
					$views = $this->analytics->getPageviews();

					/* build tables */
					if (count($visits))
					{
						foreach ($visits as $date => $visit)
						{
							$year = substr($date, 0, 4);
							$month = substr($date, 4, 2);
							$day = substr($date, 6, 2);

							$utc = mktime(date('h') + 1, NULL, NULL, $month, $day, $year) * 1000;

							$flot_datas_visits[] = '[' . $utc . ',' . $visit . ']';
							$flot_datas_views[] = '[' . $utc . ',' . $views[$date] . ']';
						}

						$flot_data_visits = '[' . implode(',', $flot_datas_visits) . ']';
						$flot_data_views = '[' . implode(',', $flot_datas_views) . ']';
					}

					$data->analytic_visits = $flot_data_visits;
					$data->analytic_views = $flot_data_views;

					// Call the model or library with the method provided and the same arguments
					$this->cache->write(array('analytic_visits' => $flot_data_visits, 'analytic_views' => $flot_data_views), 'analytics', 60 * 60 * 6); // 6 hours
				}

				catch (Exception $e)
				{
					$data->messages['notice'] = sprintf(lang('cp_google_analytics_no_connect'), anchor('admin/settings', lang('cp_nav_settings')));
				}
			}
		}

		elseif (empty($data->messages['notice']))
		{
			$data->messages['notice'] = sprintf(lang('cp_google_analytics_missing'), anchor('admin/settings', lang('cp_nav_settings')));
		}

		$this->load->model('comments/comments_m');
		$this->load->model('pages/pages_m');
		$this->load->model('users/users_m');

		$this->lang->load('comments/comments');

		$data->recent_users = $this->users_m->get_recent(5);

		$recent_comments = $this->comments_m->get_recent(5);
		$data->recent_comments = process_comment_items($recent_comments);

		// Dashboard RSS feed (using SimplePie)
		$this->load->library('simplepie');
		$this->simplepie->set_cache_location($this->config->item('simplepie_cache_dir'));
		$this->simplepie->set_feed_url($this->settings->dashboard_rss);
		$this->simplepie->init();
		$this->simplepie->handle_content_type();
		
		$this->template->append_metadata(js('jquery/jquery.flot.js'));

		// Store the feed items
		$data->rss_items = $this->simplepie->get_items(0, $this->settings->dashboard_rss_count);

		$this->template
			->title(lang('cp_admin_home_title'))
			->build('admin/dashboard', $data);
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

	    $this->template
			->set_layout(FALSE)
			->build('admin/login');
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
	
	/**
	 * Display the help string from a module's
	 * details.php file in a modal window
	 *
	 * @author Jerel Unruh - PyroCMS Dev Team
	 */
	
	public function help($slug)
	{
		$this->data->help = $this->module_m->help($slug);

		$this->template
			->set_layout('modal', 'admin')
			->build('admin/partials/help', $this->data);
	}
}