<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package 		PyroCMS
 * @subpackage 		Twitter Feed Widget
 * @author			Phil Sturgeon - PyroCMS Development Team
 *
 * Show Twitter streams in your site
 */
class Widget_Twitter_feed extends Widgets {

	public $title = array(
		'en' => 'Twitter Feed',
		'nl' => 'Twitterfeed',
		'br' => 'Feed do Twitter',
		'ru' => 'Лента Twitter\'а',
	);
	public $description	= array(
		'en' => 'Display Twitter feeds on your website',
		'nl' => 'Toon Twitterfeeds op uw website',
		'br' => 'Mostra os últimos tweets de um usuário do Twitter no seu site.',
		'ru' => 'Выводит ленту новостей Twitter на страницах вашего сайта',
	);
	public $author		= 'Phil Sturgeon';
	public $website		= 'http://philsturgeon.co.uk/';
	public $version		= '1.2';
	
	public $fields = array(
		array(
			'field' => 'username',
			'label' => 'Username',
			'rules' => 'required'
		),
		array(
			'field' => 'number',
			'label' => 'Number of tweets',
			'rules' => 'numeric'
		)
	);
	
	private $feed_url = 'http://api.twitter.com/1/statuses/user_timeline.json?trim_user=1&include_rts=1';

	public function run($options)
	{
		if ( ! $tweets = $this->pyrocache->get('twitter-'.$options['username'].'-'.$options['number']))
		{
			$tweets = json_decode(@file_get_contents($this->feed_url.'&screen_name='.$options['username']. '&count='.$options['number']));

			$this->pyrocache->write($tweets, 'twitter-'.$options['username'].'-'.$options['number'], $this->settings->twitter_cache);
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
			$tweet->text	= str_replace($options['username'] . ': ', '', $tweet->text);
			$tweet->text	= preg_replace(array_keys($patterns), $patterns, $tweet->text);
		}

		// Store the feed items
		return array(
			'username'	=> $options['username'],
			'tweets'	=> $tweets
		);
	}

}