<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package 		PyroCMS
 * @subpackage 		RSS Feed Widget
 * @author			Phil Sturgeon - PyroCMS Development Team
 *
 * Show RSS feeds in your site
 */
class Widget_Rss_feed extends Widgets {

	public $title = array(
		'en' => 'RSS Feed',
		'el' => 'Τροφοδοσία RSS',
		'nl' => 'RSS Feed',
		'br' => 'Feed RSS',
		'ru' => 'Лента новостей RSS',
		'id' => 'RSS Feed',
	);
	public $description = array(
		'en' => 'Display parsed RSS feeds on your websites',
		'el' => 'Προβάλετε τα περιεχόμενα μιας τροφοδοσίας RSS',
		'nl' => 'Toon RSS feeds op uw website',
		'br' => 'Interpreta e exibe qualquer feed RSS no seu site',
		'ru' => 'Выводит обработанную ленту новостей на вашем сайте',
		'id' => 'Menampilkan kutipan RSS feed di situs Anda',
	);
	public $author	= 'Phil Sturgeon';
	public $website	= 'http://philsturgeon.co.uk/';
	public $version	= '1.2';
	public $fields	= array(
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

	public function run($options)
	{
		$this->load->library('simplepie');
		$this->simplepie->set_cache_location($this->config->item('simplepie_cache_dir'));
		$this->simplepie->set_feed_url($options['feed_url']);
		$this->simplepie->init();

		empty($options['number']) AND $options['number'] = 5;

		// Store the feed items
		return array(
			'rss_items' => $this->simplepie->get_items(0, $options['number'])
		);
	}

	public function save($options)
	{
		return $options;
	}

}
