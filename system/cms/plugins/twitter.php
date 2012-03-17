<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Twitter Plugin
 *
 * Provides for displaying twitter feeds.
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Plugins
 */
class Plugin_Twitter extends Plugin
{
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
	 * Usage:
	 *   {{ twitter:feed username="twitterusername" limit="5" }}
	 * 
	 * @return array The tweet objects in an array.
	 */
	function feed()
	{
		$username = $this->attribute('username');
		$limit = $this->attribute('limit', 5);
		
		if ( ! ($tweets = $this->pyrocache->get('twitter-' . $username)))
		{
			$tweets = json_decode(@file_get_contents($this->feed_url.'&screen_name='.$username. '&count='.$limit));

			$this->pyrocache->write($tweets, 'twitter-' . $username, $this->settings->twitter_cache);
		}
		
		$patterns = array(
			// Detect URL's
			'((https?|ftp|gopher|telnet|file|notes|ms-help):((//)|(\\\\))+[\w\d:#@%/;$()~_?\+-=\\\.&]*)' => '<a href="$0" target="_blank">$0</a>',
			// Detect Email
			'|[a-z0-9._%+-]+@[a-z0-9.-]+.[a-z]{2,6}|i' => '<a href="mailto:$0">$0</a>',
			// Detect Twitter @usernames
			'|@([a-z0-9-_]+)|i' => '<a href="http://twitter.com/$1" target="_blank">$0</a>',
			// Detect Twitter #tags
			'|#([a-z0-9-_]+)|i' => '<a href="http://twitter.com/search?q=%23$1" target="_blank">$0</a>'
		);

		if ( ! $tweets)
		{
			return array();
		}
		
		foreach ($tweets as &$tweet)
		{
			$tweet->id		= sprintf('%.0f', $tweet->id);
			$tweet->text	= str_replace($username.': ', '', $tweet->text);
			$tweet->text	= preg_replace(array_keys($patterns), $patterns, $tweet->text);
			$tweet->timespan = strtolower(current(explode(',', timespan(strtotime($tweet->created_at))))).' ago';
		}
		
		return $tweets;
	}
}