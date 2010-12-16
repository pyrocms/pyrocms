<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package 		PyroCMS
 * @subpackage 		RSS Feed Widget
 * @author			Phil Sturgeon - PyroCMS Development Team
 * 
 * Show RSS feeds in your site
 */

class Widget_Rss_feed extends Widgets
{
	public $title = 'RSS Feed';
	public $description = 'Display parsed RSS feeds on your websites.';
	public $author = 'Phil Sturgeon';
	public $website = 'http://philsturgeon.co.uk/';
	public $version = '1.0';
	
	public $fields = array(
		array(
			'field'   => 'feed_url',
			'label'   => 'Feed URL',
			'rules'   => 'required'
		),
		array(
			'field'   => 'number',
			'label'   => 'Number of items',
			'rules'   => 'numeric'
		)
	);

	public function run($options)
	{
		$this->load->library('simplepie');
		$this->simplepie->set_cache_location($this->config->item('simplepie_cache_dir'));
		$this->simplepie->set_feed_url( $options['feed_url'] );
		$this->simplepie->init();
		
		!empty($options['number']) OR $options['number'] = 5;
		
		// Store the feed items
		return array(
			'rss_items' => $this->simplepie->get_items(0, $options['number'])
		);
	}

	public function save($options)
	{
		$this->load->helper('url');
		
		$options['feed_url'] = prep_url($options['feed_url']);
		
		return $options;
	}
}