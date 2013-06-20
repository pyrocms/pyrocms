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

	public function feed()
	{
		// Variables
		$options  = array(
			'screen_name' => $this->attribute('username', $this->settings->twitter_username),
			'count'       => $this->attribute('count', $this->settings->twitter_feed_count),
		);

		// Regex replacements
		$patterns = array(
			'((https?|ftp|gopher|telnet|file|notes|ms-help):((//)|(\\\\))+[\w\d:#@%/;$()~_?\+-=\\\.&]*)' => '<a href="$0" target="_blank">$0</a>', // Detect URL's
			'|([a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,6})|i' => '<a href="mailto:$1">$1</a>', // Detect Email
			'| @([a-z0-9-_]+)|i' => '<a href="http://twitter.com/$1" target="_blank">$0</a>', // Detect Twitter @usernames
			'|#([a-z0-9-_]+)|i' => '<a href="http://twitter.com/search?q=%23$1" target="_blank">$0</a>' // Detect Twitter #tags
		);

		// Load tweets
		if ( ! ( $tweets = $this->pyrocache->get('twitter-'.$options['screen_name']) ) ) {
			$tweets = $this->_request($options);
			$this->pyrocache->write($tweets, 'twitter-'.$options['screen_name'], $this->settings->twitter_cache);
		}
	
		// Check data
		if ( ! $tweets ) { return array(); }
		
		// Loop and format
		foreach ( $tweets as &$tweet ) {
			$tweet->id		 = sprintf('%.0f', $tweet->id);
			$tweet->text	 = str_replace($username.': ', '', $tweet->text);
			$tweet->text	 = preg_replace(array_keys($patterns), $patterns, $tweet->text);
			$tweet->timespan = strtolower(current(explode(',', timespan(strtotime($tweet->created_at))))).' ago';
		}
		
		return $tweets;
	}

	private function _request($extra = array())
	{
		// Variables
		$host   = 'api.twitter.com';
		$method = 'GET';
		$path   = '/1.1/statuses/user_timeline.json';
		$oauth  = array(
			'oauth_consumer_key'     => $this->settings->twitter_consumer_key,
			'oauth_token'            => $this->settings->twitter_oauth_access_token,
			'oauth_nonce'            => (string)mt_rand(),
			'oauth_timestamp'        => time(),
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_version'          => '1.0'
		);

		// Encode and merge perams
		$oauth  = array_map("rawurlencode", $oauth);
		$extra  = array_map("rawurlencode", $extra);
		$params = array_merge($oauth, $extra);

		// Sort the params
		asort($params);
		ksort($params);

		// Build request headers
		$query = urldecode(http_build_query($params, '', '&'));
		$url   = 'https://'.$host.$path;
		$base  = $method.'&'.rawurlencode($url).'&'.rawurlencode($query);
		$key   = rawurlencode($this->settings->twitter_consumer_secret).'&'.rawurlencode($this->settings->twitter_oauth_token_secret);
		$sign  = rawurlencode(base64_encode(hash_hmac('sha1', $base, $key, true)));

		// Build and format URL
		$url .= '?'.http_build_query($extra);
		$url  = str_replace('&amp;', '&', $url);

		// Assign the signature
		$oauth['oauth_signature'] = $sign;
		ksort($oauth);

		// Twitter demo does this, so just incase
		function add_quotes($str) { return '"'.$str.'"'; }
		$oauth = array_map("add_quotes", $oauth);

		// Setup CURL
		$feed = curl_init();
		curl_setopt_array($feed, array(
			CURLOPT_HTTPHEADER     => array('Authorization: OAuth '.urldecode(http_build_query($oauth, '', ', '))),
			CURLOPT_HEADER         => false,
			CURLOPT_URL            => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false
		));

		// Make request
		$json = curl_exec($feed);
		curl_close($feed);

		// Decode and return
		return json_decode($json);
	}

}
