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
class Twitter extends Plugin {

	/**
	 * Get some tweets
	 */
	public function twitter()
	{
		$this->CI = get_instance();
	
		$this->CI->load->library('Simple_tweets');
		$this->CI->load->library('Parser');
		
		if(!$handle = $this->get_param('name')) return;
		
		// We play our oooown game when it comes
		// to the cache
		$this->CI->simple_tweets->cache_dir = 'cache/simple_tweets/';
		
		$tweets = $this->CI->simple_tweets->get_tweets($handle, $this->get_param('number', 1));
		
		if(!$tweets) return;
		
		return $this->CI->parser->parse_string($this->tag_content, $tweets, TRUE);
	}
		
}

/* End of file format.php */