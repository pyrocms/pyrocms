<?php

use Pyro\Module\Addons\AbstractTheme;
use Pyro\Module\Comments\Model\Comment;

class Theme_Pyrocms extends AbstractTheme
{
    public $name			= 'PyroCMS - Admin Theme';
    public $author			= 'PyroCMS Dev Team';
    public $author_website	= 'http://pyrocms.com/';
    public $website			= 'http://pyrocms.com/';
    public $description		= 'PyroCMS admin theme. HTML5 and CSS3 styling.';
    public $version			= '1.0.0';
	public $type			= 'admin';
	public $options 		= array(
		'pyrocms_recent_comments' => array(
			'title' 		=> 'Recent Comments',
			'description'   => 'Would you like to display recent comments on the dashboard?',
			'default'       => 'yes',
			'type'          => 'radio',
			'options'       => 'yes=Yes|no=No',
			'is_required'   => true
		),

		'pyrocms_news_feed' => 	array(
			'title' 		=> 'News Feed',
			'description'   => 'Would you like to display the news feed on the dashboard?',
			'default'       => 'yes',
			'type'          => 'radio',
			'options'       => 'yes=Yes|no=No',
			'is_required'   => true
		),

		'pyrocms_quick_links' => array(
			'title' 		=> 'Quick Links',
			'description'   => 'Would you like to display quick links on the dashboard?',
			'default'       => 'yes',
			'type'          => 'radio',
			'options'       => 'yes=Yes|no=No',
			'is_required'   => true
		),

		'pyrocms_analytics_graph' => array(
			'title' 		=> 'Analytics Graph',
			'description'   => 'Would you like to display the graph on the dashboard?',
			'default'       => 'yes',
			'type'          => 'radio',
			'options'       => 'yes=Yes|no=No',
			'is_required'   => true
		),
	);

	/**
	 * Run() is triggered when the theme is loaded for use
	 *
	 * This should contain the main logic for the theme.
	 *
	 * @return	void
	 */
	public function run()
	{
		// only load these items on the dashboard
        if (!$this->module && $this->method !== 'login' && $this->method !== 'help') {

			// don't bother fetching the data if it's turned off in the theme
			if ($opt = (object)$this->theme->model->getOptionValues()) {

				if (isset($opt->pyrocms_analytics_graph) and $opt->pyrocms_analytics_graph == 'yes')	{ 
					self::getAnalytics();
				}
				if (isset($opt->pyrocms_news_feed) and $opt->pyrocms_news_feed == 'yes') { 
					self::getRssFeed();
				}
				if (isset($opt->pyrocms_recent_comments) and $opt->pyrocms_recent_comments == 'yes')	{ 
					self::getRecentComments();
				}
			}
		}
	}

	/**
	 * Generate Menu
	 *
	 * Get a list of all modules available to this user/group
	 *
	 * @return	void
	 */
	private function generate_menu()
	{
		if (! $this->current_user) {
			return;
		}

		$modules = $this->module_m->get_all(array(
			'is_backend' => true,
			'group' => $this->current_user->group,
			'lang' => CURRENT_LANGUAGE
		));

		$grouped_modules = array();

		$grouped_menu[] = 'content';

		foreach ($modules as $module) {
			if ($module['menu'] != 'content' && $module['menu'] != 'design' && $module['menu'] != 'users' && $module['menu'] != 'utilities' && $module['menu'] != '0') {
				$grouped_menu[] = $module['menu'];
			}
		}

		array_push($grouped_menu, 'design', 'users', 'utilities');

		$grouped_menu = array_unique($grouped_menu);

		foreach ($modules as $module) {
			$grouped_modules[$module['menu']][$module['name']] = $module;
		}

		// pass them on as template variables
		$this->template->menu_items = $grouped_menu;
		$this->template->modules = $grouped_modules;
	}

	/**
	 * Get Analytics
	 *
	 * Fetch Google Analytics information for the dashboard graph
	 *
	 * @return	void
	 */
	public function getAnalytics()
	{
		if ( ! (Settings::get('ga_email') and Settings::get('ga_password') and Settings::get('ga_profile'))) {
			return;
		}

		// Not false? Return it
		if ($cached_response = $this->cache->get('analytics')) {
			$data['analytic_visits'] = $cached_response['analytic_visits'];
			$data['analytic_views'] = $cached_response['analytic_views'];
		} else {
			try {
				$this->load->library('analytics', array(
					'username' => Settings::get('ga_email'),
					'password' => Settings::get('ga_password'),
				));

				// Set by GA Profile ID if provided, else try and use the current domain
				$this->analytics->setProfileById('ga:'.Settings::get('ga_profile'));

				$end_date = date('Y-m-d');
				$start_date = date('Y-m-d', strtotime('-1 month'));

				$this->analytics->setDateRange($start_date, $end_date);

				$visits = $this->analytics->getVisitors();
				$views = $this->analytics->getPageviews();

				/* build tables */
				if (count($visits)) {
					foreach ($visits as $date => $visit) {
						$year = substr($date, 0, 4);
						$month = substr($date, 4, 2);
						$day = substr($date, 6, 2);

						$utc = mktime(date('h') + 1, null, null, $month, $day, $year) * 1000;

						$flot_datas_visits[] = '[' . $utc . ',' . $visit . ']';
						$flot_datas_views[] = '[' . $utc . ',' . $views[$date] . ']';
					}

					$flot_data_visits = '[' . implode(',', $flot_datas_visits) . ']';
					$flot_data_views = '[' . implode(',', $flot_datas_views) . ']';
				}

				$data['analytic_visits'] = $flot_data_visits;
				$data['analytic_views'] = $flot_data_views;

				// Call the model or library with the method provided and the same arguments
				$this->cache->put('analytics', array('analytic_visits' => $flot_data_visits, 'analytic_views' => $flot_data_views), 60 * 60 * 6); // 6 hours
			} catch (Exception $e) {
				$data['messages']['notice'] = sprintf(lang('cp_google_analytics_no_connect'), anchor('admin/settings', lang('cp_nav_settings')));
			}
		}

		// make it available in the theme
		$this->template->set($data);
	}

	/**
	 * Get RSS Feed
	 *
	 * Fetch articles for whatever RSS feed is in settings
	 */
	public function getRssFeed()
	{
		// Dashboard RSS feed (using SimplePie)
		$pie = new SimplePie;
        $pie->set_cache_location(APPPATH.'cache'.DIRECTORY_SEPARATOR.SITE_REF.DIRECTORY_SEPARATOR.'simplepie');
		$pie->set_feed_url(Settings::get('dashboard_rss'));
		$pie->init();
		$pie->handle_content_type();

		$this->template->rss_items = $pie->get_items(0, Settings::get('dashboard_rss_count'));
	}

	/**
	 * Get Recent Comments
	 *
	 * Fetch recent comments and work out what they attach to.
	 */
	public function getRecentComments()
	{
		$this->load->library('comments/comments');
		$this->lang->load('comments/comments');

		$recent_comments = Comment::findRecent(5);

		$this->template->recent_comments = $this->comments->process($recent_comments);
	}
}

/* End of file theme.php */