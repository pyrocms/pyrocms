<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Twitter Plugin
 *
 * Provides for displaying twitter feeds.
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Plugins
 */
class Plugin_Twitter extends Plugin
{

	public $version = '1.0.0';
	public $name = array(
		'en' => 'Twitter',
	);
	public $description = array(
		'en' => 'Display a Twitter feed.',
		'el' => 'Προβάλλει μια σειρά από tweets.',
		'fr' => 'Afficher le flux Twitter'
	);

	/**
	 * Returns a PluginDoc array that PyroCMS uses 
	 * to build the reference in the admin panel
	 * 
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'feed' => array(
				'description' => array(
					'en' => 'Allows a Twitter feed to be output anywhere on the site.'
				),
				'single' => false,
				'double' => true,
				'variables' => 'id|created_at|text|source|truncated|in_reply_to_status_id|in_reply_to_user_id|in_reply_to_screen_name|geo|coordinates|place|contributors|retweet_count|favorited|retweeted|timespan',
				'attributes' => array(
					'username' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
					'limit' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '5',
						'required' => false,
					),
				),
			),// end first method
		);
	
		return $info;
	}

	/**
	 * The URL used to retrieve tweets from the Twitter API
	 *
	 * @var string
	 */
	private $feed_url = 'http://api.twitter.com/1/statuses/user_timeline.json?trim_user=1&include_rts=1';

	/**
	 * Load a constant
	 *
	 * Magic method to get a constant or global variable
	 *
	 * <code>
	 *   {{ twitter:feed username="twitterusername" limit="1" }}
	 *      {{ text }}
	 *   {{ /twitter:feed }}
	 * </code>
	 *
	 * @return array The tweet objects in an array.
	 */
	public function feed()
	{
		$username = $this->attribute('username');
		$limit    = $this->attribute('limit', 5);

		if ( ! ($tweets = $this->pyrocache->get('twitter-' . $username)))
		{
			$tweets = json_decode(@file_get_contents($this->feed_url . '&screen_name=' . $username . '&count=' . $limit));

			$this->pyrocache->write($tweets, 'twitter-' . $username, $this->settings->twitter_cache);
		}

		$patterns = array(
			// Detect URL's
			'((https?|ftp|gopher|telnet|file|notes|ms-help):((//)|(\\\\))+[\w\d:#@%/;$()~_?\+-=\\\.&]*)' => '<a href="$0" target="_blank">$0</a>',
			// Detect Email
			'|([a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,6})|i' => '<a href="mailto:$1">$1</a>',
			// Detect Twitter @usernames
			'| @([a-z0-9-_]+)|i' => '<a href="http://twitter.com/$1" target="_blank">$0</a>',
			// Detect Twitter #tags
			'|#([a-z0-9-_]+)|i' => '<a href="http://twitter.com/search?q=%23$1" target="_blank">$0</a>'
		);

		if ( ! $tweets)
		{
			return array();
		}

		foreach ($tweets as &$tweet)
		{
			$tweet->id       = sprintf('%.0f', $tweet->id);
			$tweet->text     = str_replace($username . ': ', '', $tweet->text);
			$tweet->text     = preg_replace(array_keys($patterns), $patterns, $tweet->text);
			$tweet->timespan = strtolower(current(explode(',', timespan(strtotime($tweet->created_at))))) . ' ago';
		}

		return $tweets;
	}

}