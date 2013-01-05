<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Integration Plugin
 *
 * Attaches a Google Analytics tracking piece of code.
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Plugins
 */
class Plugin_Integration extends Plugin
{

	public $version = '1.0.0';
	public $name = array(
		'en' => 'Integration',
	);
	public $description = array(
		'en' => 'Google analytics tracking code and data.',
		'el' => 'Συνεργασία με Google Analytics;',
		'fr' => 'Intégration du code de suivi Google Analytics.',
		'it' => 'Codice di tracciamento Google Analytics'
	);

	/**
	 * Returns a PluginDoc array that PyroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * All options are listed here but refer 
	 * to the Blog plugin for a larger example
	 *
	 * @todo fill the  array with details about this plugin, then uncomment the return value.
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'your_method' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Displays some data from some module.'
				),
				'single' => true,// will it work as a single tag?
				'double' => false,// how about as a double tag?
				'variables' => '',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(
					'order-dir' => array(// this is the order-dir="asc" attribute
						'type' => 'flag',// Can be: slug, number, flag, text, array, any.
						'flags' => 'asc|desc|random',// flags are predefined values like this.
						'default' => 'asc',// attribute defaults to this if no value is given
						'required' => false,// is this attribute required?
					),
					'limit' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '20',
						'required' => false,
					),
				),
			),// end first method
		);
	
		//return $info;
		return array();
	}

	/**
	 * Partial
	 *
	 * Loads Google Analytic
	 *
	 * Usage:
	 *
	 *     {{ integration:analytics }}
	 *
	 * @return string The analytics partial view.
	 */
	public function analytics()
	{
		return $this->load->view('fragments/google_analytics', null, true);
	}

	/**
	 * Visitors
	 *
	 * Uses Google Analytics data to show page views and visitors for a given time period
	 *
	 * Usage:
	 *
	 *     {{ integration:visitors }}
	 *
	 * @return array The number of page views and visitors.
	 */
	public function visitors()
	{
		$data    = array(
			'visits' => 0,
			'views'  => 0
		);
		$start   = $this->attribute('start', '2010-01-01');
		$end     = $this->attribute('end', date('Y-m-d'));
		$refresh = $this->attribute('refresh', 24); // refresh the cache every n hours

		if (Settings::get('ga_email') and Settings::get('ga_password') and Settings::get('ga_profile'))
		{
			// do we have it? Return it
			if ($cached_response = $this->pyrocache->get('analytics_plugin'))
			{
				return $cached_response;
			}

			try
			{
				$this->load->library('analytics', array(
					'username' => Settings::get('ga_email'),
					'password' => Settings::get('ga_password')
				));

				// Set by GA Profile ID if provided, else try and use the current domain
				$this->analytics->setProfileById('ga:' . Settings::get('ga_profile'));

				$this->analytics->setDateRange($start, $end);

				$visits = $this->analytics->getVisitors();
				$views = $this->analytics->getPageviews();

				if ($visits)
				{
					foreach ($visits as $visit)
					{
						if ($visit > 0)
						{
							$data['visits'] += $visit;
						}
					}
				}

				if ($views)
				{
					foreach ($views as $view)
					{
						if ($view > 0)
						{
							$data['views'] += $view;
						}
					}
				}

				// Call the model or library with the method provided and the same arguments
				$this->pyrocache->write($data, 'analytics_plugin', 60 * 60 * (int) $refresh); // 24 hours
			}
			catch (Exception $e)
			{
				log_message('error', 'Could not connect to Google Analytics. Called from the analytics plugin');
			}
		}

		return $data;
	}

}