<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Theme_Admin_theme extends Theme {

    public $name			= 'PyroCMS Admin Theme';
    public $author			= 'PyroCMS Dev Team';
    public $author_website	= 'http://pyrocms.com/';
    public $website			= 'http://pyrocms.com/';
    public $description		= 'Default PyroCMS v1.0 Admin Theme - Vertical navigation, CSS3 styling.';
    public $version			= '1.0';
	public $type			= 'admin';
	public $options 		= array('recent_comments' => 	array('title' 		=> 'Recent Comments',
																'description'   => 'Would you like to display recent comments on the dashboard?',
																'default'       => 'no',
																'type'          => 'radio',
																'options'       => 'yes=Yes|no=No',
																'is_required'   => TRUE),
									'news_feed' => 			array('title' => 'News Feed',
																'description'   => 'Would you like to display the news feed on the dashboard?',
																'default'       => 'yes',
																'type'          => 'radio',
																'options'       => 'yes=Yes|no=No',
																'is_required'   => TRUE),
									'quick_links' => 		array('title' => 'Quick Links',
																'description'   => 'Would you like to display quick links on the dashboard?',
																'default'       => 'yes',
																'type'          => 'radio',
																'options'       => 'yes=Yes|no=No',
																'is_required'   => TRUE),
									'analytics_graph' => 	array('title' => 'Analytics Graph',
																'description'   => 'Would you like to display the graph on the dashboard?',
																'default'       => 'yes',
																'type'          => 'radio',
																'options'       => 'yes=Yes|no=No',
																'is_required'   => TRUE),
								   );
	
	/**
	 * Run() is triggered when the theme is loaded for use
	 *
	 * This should contain the main logic for the theme.
	 *
	 * @access	public
	 * @return	void
	 */
	public function run()
	{
		self::generate_menu();

		// only load these items on the dashboard
		if ($this->module == '')
		{
			// don't bother fetching the data if it's turned off in the theme
			if ($this->theme_options->analytics_graph == 'yes')		self::get_analytics();
			if ($this->theme_options->news_feed == 'yes')			self::get_rss_feed();
			if ($this->theme_options->recent_comments == 'yes')		self::get_recent_comments();
		}
	}
	
	private function generate_menu()
	{
		// Get a list of all modules available to this user/group
		if ($this->user)
		{
			$modules = $this->module_m->get_all(array(
				'is_backend' => TRUE,
				'group' => $this->user->group,
				'lang' => CURRENT_LANGUAGE
			));

			$grouped_modules = array();

			$grouped_menu[] = 'content';

			foreach ($modules as $module)
			{
				if ($module['menu'] != 'content' && $module['menu'] != 'design' && $module['menu'] != 'users' && $module['menu'] != 'utilities' && $module['menu'] != '0')
				{
					$grouped_menu[] = $module['menu'];
				}
			}

			array_push($grouped_menu, 'design', 'users', 'utilities');

			$grouped_menu = array_unique($grouped_menu);

			foreach ($modules as $module)
			{
				$grouped_modules[$module['menu']][$module['name']] = $module;
			}

			// pass them on as template variables
			$this->template->menu_items = $grouped_menu;
			$this->template->modules = $grouped_modules;
		}
	}
	
	public function get_analytics()
	{
		$data = array();
		
		if ($this->settings->ga_email AND $this->settings->ga_password AND $this->settings->ga_profile)
		{
			// Not FALSE? Return it
			if ($cached_response = $this->pyrocache->get('analytics'))
			{
				$data['analytic_visits'] = $cached_response['analytic_visits'];
				$data['analytic_views'] = $cached_response['analytic_views'];
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

					$data['analytic_visits'] = $flot_data_visits;
					$data['analytic_views'] = $flot_data_views;

					// Call the model or library with the method provided and the same arguments
					$this->pyrocache->write(array('analytic_visits' => $flot_data_visits, 'analytic_views' => $flot_data_views), 'analytics', 60 * 60 * 6); // 6 hours
				}

				catch (Exception $e)
				{
					$data['messages']['notice'] = sprintf(lang('cp_google_analytics_no_connect'), anchor('admin/settings', lang('cp_nav_settings')));
				}
			}
		}

		// Only mention this notice if no other notices are set
		elseif (empty($data['messages']['notice']))
		{
			// make sure it only shows on the dashboard and not in modals or login
			if ($this->module == '' AND $this->controller == 'admin' AND $this->method == 'index')
			{
				$data['messages']['notice'] = sprintf(lang('cp_google_analytics_missing'), anchor('admin/settings', lang('cp_nav_settings')));
			}
		}
		
		// make it available in the theme
		$this->template->set($data);
	}
	
	public function get_rss_feed()
	{
		// Dashboard RSS feed (using SimplePie)
		$this->load->library('simplepie');
		$this->simplepie->set_cache_location($this->config->item('simplepie_cache_dir'));
		$this->simplepie->set_feed_url($this->settings->dashboard_rss);
		$this->simplepie->init();
		$this->simplepie->handle_content_type();

		// Store the feed items
		$data['rss_items'] = $this->simplepie->get_items(0, $this->settings->dashboard_rss_count);
		
		// you know
		$this->template->set($data);
	}
	
	public function get_recent_comments()
	{
		$this->load->model('comments/comments_m');
		$this->load->model('users/users_m');

		$this->lang->load('comments/comments');

		$recent_comments = $this->comments_m->get_recent(5);
		$data['recent_comments'] = process_comment_items($recent_comments);
		
		$this->template->set($data);
	}
}

/* End of file theme.php */