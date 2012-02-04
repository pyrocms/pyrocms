<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Twitter Plugin
 *
 * Allows you to show some tweets.
 *
 * @package		Fizl
 * @author		Adam Fairholm (@adamfairholm)
 * @copyright	Copyright (c) 2011-2012, Parse19
 * @license		http://parse19.com/fizl/docs/license.html
 * @link		http://parse19.com/fizl
 */
class Plugin_twitter extends Plugin {

	/**
	 * Get some tweets
	 *
	 * @access	public
	 * @return	array
	 */
	public function twitter()
	{
		// We need a handle
		if ( ! $handle = $this->get_param('name')) return NULL;

		$this->CI = get_instance();
		
		require_once('simple_tweets.php');

		$twitter = new Simple_tweets();
		
		$tweets = $twitter->get_tweets($handle, $this->get_param('number', 1));
		
		if ( ! $tweets) return NULL;
		
		return $tweets;
	}
		
}