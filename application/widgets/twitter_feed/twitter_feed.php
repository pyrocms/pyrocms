<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package 		PyroCMS
 * @subpackage 		Twitter Feed Widget
 * @author			Phil Sturgeon - PyroCMS Development Team
 * 
 * Show Twitter feeds in your site
 */

class Twitter_feed extends Widgets
{
	public $title = 'Twitter Feed';
	public $description = 'Display tweets from a user on Twitter.';
	public $author = 'Phil Sturgeon';
	public $version = '1.0';
	
	public function run($options)
	{
		$this->load->library('twitter/twitter');
		$this->lang->load('twitter/twitter');
		
		!empty($options['number']) || $options['number'] = 5;
		!empty($options['username']) || $options['username'] = $this->settings->item('twitter_username');
		
		$tweets = !empty($options['username']) ? $this->twitter->user_timeline($options['username'], $options['number']) : array();
		
		// Store the feed items
		return array(
			'tweets' => $tweets,
			'options' => $options
		);
		
	}
}