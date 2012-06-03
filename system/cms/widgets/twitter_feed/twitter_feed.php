<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Show Twitter streams in your site
 * 
 * @author		Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Widgets
 */
class Widget_Twitter_feed extends Widgets
{

	/**
	 * The translations for the widget title
	 *
	 * @var array
	 */
	public $title = array(
		'en' => 'Twitter Feed',
		'el' => 'Ροή Twitter',
		'nl' => 'Twitterfeed',
		'br' => 'Feed do Twitter',
		'pt' => 'Feed do Twitter',
		'ru' => 'Лента Twitter\'а',
		'id' => 'Twitter Feed',
		'fi' => 'Twitter Syöte'
	);

	/**
	 * The translations for the widget description
	 *
	 * @var array
	 */
	public $description = array(
		'en' => 'Display Twitter feeds on your website',
		'el' => 'Προβολή των τελευταίων tweets από το Twitter',
		'nl' => 'Toon Twitterfeeds op uw website',
		'br' => 'Mostra os últimos tweets de um usuário do Twitter no seu site.',
		'pt' => 'Mostra os últimos tweets de um utilizador do Twitter no seu site.',
		'ru' => 'Выводит ленту новостей Twitter на страницах вашего сайта',
		'id' => 'Menampilkan koleksi Tweet di situs Anda',
		'fi' => 'Näytä Twitter syöte sivustollasi',
	);

	/**
	 * The author of the widget
	 *
	 * @var string
	 */
	public $author = 'Phil Sturgeon';

	/**
	 * The author's website.
	 * 
	 * @var string 
	 */
	public $website = 'http://philsturgeon.co.uk/';

	/**
	 * The version of the widget
	 *
	 * @var string
	 */
	public $version = '1.2';

	/**
	 * The fields for customizing the options of the widget.
	 *
	 * @var array 
	 */
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

	/**
	 * The URL used to get statuses from the Twitter API
	 *
	 * @var string
	 */
	private $feed_url = 'http://api.twitter.com/1/statuses/user_timeline.json?trim_user=1&include_rts=1';

	/**
	 * The main function of the widget.
	 *
	 * @param array $options The options for the twitter username and the number of tweets to display
	 * @return array 
	 */
	public function run($options)
	{
		if (!$tweets = $this->pyrocache->get('twitter-'.$options['username'].'-'.$options['number']))
		{
			$tweets = json_decode(@file_get_contents($this->feed_url.'&screen_name='.$options['username'].'&count='.$options['number']));

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

		if ($tweets)
		{
			foreach ($tweets as &$tweet)
			{
				$tweet->text = str_replace($options['username'].': ', '', $tweet->text);
				$tweet->text = preg_replace(array_keys($patterns), $patterns, $tweet->text);
			}
		}

		// Store the feed items
		return array(
			'username' => $options['username'],
			'tweets' => $tweets ? $tweets : array(),
		);
	}

}