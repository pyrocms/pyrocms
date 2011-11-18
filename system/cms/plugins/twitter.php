<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Global Plugin
 *
 * Make global constants available as tags
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2011, PyroCMS
 *
 */
class Plugin_Twitter extends Plugin
{
	private $feed_url = 'http://api.twitter.com/1/statuses/user_timeline.json?trim_user=1&include_rts=1';
	
	/**
	 * Load a constant
	 *
	 * Magic method to get a constant or global var
	 *
	 * @param	string
	 * @param	string
	 * @return	string
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

/* End of file twitter.php */