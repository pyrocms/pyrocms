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
		'pt' => 'Feed do Twitter',
		'ru' => 'Лента Twitter\'а',
	);
	public $description	= array(
		'en' => 'Display Twitter feeds on your website',
		'pt' => 'Mostra os últimos tweets de um usuário do Twitter no seu site.',
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

	public function run($options)
	{
		if ( ! $tweets = $this->pyrocache->get('twitter-' . $options['username']))
		{
			$tweets = json_decode(@file_get_contents('http://twitter.com/statuses/user_timeline/' . $options['username'] . '.json'));

			$this->pyrocache->write($tweets, 'twitter-' . $options['username'], $this->settings->twitter_cache);
		}

		// If no number provided, just get 5
		empty($options['number']) AND $options['number'] = 5;

		$tweets = is_array($tweets) ? array_slice($tweets, 0, $options['number']) : array();

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

		foreach ($tweets as &$tweet)
		{
			$tweet->id		= sprintf('%.0f', $tweet->id);
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