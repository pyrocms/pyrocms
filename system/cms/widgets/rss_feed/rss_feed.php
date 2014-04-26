<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Show RSS feeds in your site
 * 
 * @author		Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Widgets
 */
class Widget_Rss_feed extends Widgets
{

	/**
	 * The translations for the widget title
	 *
	 * @var array
	 */
	public $title = array(
		'en' => 'RSS Feed',
		'el' => 'Τροφοδοσία RSS',
		'nl' => 'RSS Feed',
		'br' => 'Feed RSS',
		'pt' => 'Feed RSS',
		'ru' => 'Лента новостей RSS',
		'id' => 'RSS Feed',
		'fi' => 'RSS Syöte',
		'fr' => 'Flux RSS',
            'fa' => 'خبر خوان RSS',
	);

	/**
	 * The translations for the widget description
	 *
	 * @var array
	 */
	public $description = array(
		'en' => 'Display parsed RSS feeds on your websites',
		'el' => 'Προβάλετε τα περιεχόμενα μιας τροφοδοσίας RSS',
		'nl' => 'Toon RSS feeds op uw website',
		'br' => 'Interpreta e exibe qualquer feed RSS no seu site',
		'pt' => 'Interpreta e exibe qualquer feed RSS no seu site',
		'ru' => 'Выводит обработанную ленту новостей на вашем сайте',
		'id' => 'Menampilkan kutipan RSS feed di situs Anda',
		'fi' => 'Näytä purettu RSS syöte sivustollasi',
		'fr' => 'Affichez un flux RSS sur votre site web',
            'fa' => 'نمایش خوراک های RSS در سایت',
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
	public $version = '1.2.0';

	/**
	 * The fields for customizing the options of the widget.
	 *
	 * @var array 
	 */
	public $fields = array(
		array(
			'field' => 'feed_url',
			'label' => 'Feed URL',
			'rules' => 'prep_url|required'
		),
		array(
			'field' => 'number',
			'label' => 'Number of items',
			'rules' => 'numeric'
		)
	);

	/**
	 * The main function of the widget.
	 *
	 * @param array $options The options for displaying the RSS Feed.
	 * @return array 
	 */
	public function run($options)
	{
		// Load the simplepie library
		$this->load->library('simplepie');
		// Set some options and the feed url from the options provided
		$this->simplepie->set_cache_location($this->config->item('simplepie_cache_dir'));
		$this->simplepie->set_feed_url($options['feed_url']);
		// Fire it up
		$this->simplepie->init();

		// Default the number of rss items to 5
		empty($options['number']) AND $options['number'] = 5;

		// Store the feed items
		return array(
			'rss_items' => $this->simplepie->get_items(0, $options['number'])
		);
	}

	/**
	 * @todo What does this do ?
	 *
	 * @param array $options
	 * @return array 
	 */
	public function save($options)
	{
		return $options;
	}

}