<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package 		PyroCMS
 * @subpackage 		RSS Feed Widget
 * @author			Phil Sturgeon - PyroCMS Development Team
 *
 * Show RSS feeds in your site
 */

class Widget_Html extends Widgets
{
	public $title		= 'HTML';
	public $description	= array(
		'en' => 'Create blocks of custom HTML',
		'br' => 'Permite criar blocos de HTML customizados',
		'nl' => 'Maak blokken met maatwerk HTML',
		'ru' => 'Создание HTML-блоков с произвольным содержимым',
	);
	public $author		= 'Phil Sturgeon';
	public $website		= 'http://philsturgeon.co.uk/';
	public $version		= '1.0';
	
	public $fields = array(
		array(
			'field'   => 'html',
			'label'   => 'HTML',
			'rules'   => 'required'
		)
	);

	public function run($options)
	{
		if (empty($options['html']))
		{
			return array('output' => '');
		}
		
		// Store the feed items
		return array('output' => $this->parser->parse_string($options['html'], NULL, TRUE));
	}	
}