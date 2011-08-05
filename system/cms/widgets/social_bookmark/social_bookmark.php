<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package 		MizuCMS
 * @subpackage 		RSS Feed Widget
 * @author			Phil Sturgeon - MizuCMS Development Team
 * 
 * Show RSS feeds in your site
 */

class Widget_Social_bookmark extends Widgets
{
	public $title		= array(
		'en' => 'Social Bookmark',
		'pt' => 'Social Bookmark',
		'ru' => 'Социальные закладки',
		);
	public $description	= array(
		'en' => 'Configurable social bookmark links from AddThis',
		'pt' => 'Adiciona links de redes sociais usando o AddThis, podendo fazer algumas configurações',
		'ru' => 'Конфигурируемые социальные закладки с сайта AddThis',
	);
	public $author		= 'Phil Sturgeon';
	public $website		= 'http://philsturgeon.co.uk/';
	public $version		= '1.0';
	
	public $fields = array(
		array(
			'field' => 'mode',
			'label' => 'Mode',
			'rules' => 'required'
		)
	);

	public function run($options)
	{
		!empty($options['mode']) OR $options['mode'] = 'default';
		
		return $options;
	}
}