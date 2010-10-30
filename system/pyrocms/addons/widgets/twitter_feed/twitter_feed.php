<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package 		MizuCMS
 * @subpackage 		Twitter Feed Widget
 * @author			Phil Sturgeon - MizuCMS Development Team
 * 
 * Show Twitter streams in your site
 */

class Widget_Twitter_feed extends Widgets
{
	public $title = 'Twitter Feed';
	public $description = 'Display Twitter feeds on your websites.';
	public $author = 'Phil Sturgeon';
	public $website = 'http://philsturgeon.co.uk/';
	public $version = '1.1';
	
	public $fields = array(
		array(
			'field'   => 'username',
			'label'   => 'Username',
			'rules'   => 'required'
		),
		array(
			'field'   => 'number',
			'label'   => 'Number of tweets',
			'rules'   => 'numeric'
		)
	);

	public function run($options)
	{
		$this->load->library('simplepie');
		$this->simplepie->set_cache_location(APPPATH . 'cache/simplepie/');
		$this->simplepie->set_feed_url('http://twitter.com/statuses/user_timeline/'.$options['username'].'.rss');
		$this->simplepie->init();

		// If no number provided, just get 5
		empty($options['number']) AND $options['number'] = 5;

		$tweets = $this->simplepie->get_items(0, $options['number']);

		$patterns = array(
			// Detect URL's
			'|([a-z]{3,9}://[a-z0-9-_./?&+]*)|i'     => '<a href="$0" target="_blank">$0</a>',

			// Detect Email
			'|[a-z0-9._%+-]+@[a-z0-9.-]+.[a-z]{2,6}|i' => '<a href="mailto:$0">$0</a>',

			// Detect Twitter @usernames
			'|@([a-z0-9-_]+)|i'     => '<a href="http://twitter.com/$1" target="_blank">$0</a>',

			// Detect Twitter #tags
			'|#([a-z0-9-_]+)|i'     => '<a href="http://twitter.com/search?q=%23$1" target="_blank">$0</a>'
		);

		foreach($tweets as &$tweet)
		{
			$tweet->text = str_replace($options['username'].': ', '', $tweet->get_title());
			$tweet->text = preg_replace(array_keys($patterns), array_values($patterns), $tweet->text);
		}

		// Store the feed items
		return array(
			'tweets' => $tweets
		);
	}
	
}