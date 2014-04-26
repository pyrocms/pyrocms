<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Show RSS feeds in your site
 * 
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Widgets
 */
class Widget_Social_bookmark extends Widgets
{

	/**
	 * The translations for the widget title
	 *
	 * @var array
	 */
	public $title = array(
		'en' => 'Social Bookmark',
		'el' => 'Κοινωνική δικτύωση',
		'nl' => 'Sociale Bladwijzers',
		'br' => 'Social Bookmark',
		'pt' => 'Social Bookmark',
		'ru' => 'Социальные закладки',
		'id' => 'Social Bookmark',
		'fi' => 'Sosiaalinen kirjanmerkki',
		'fr' => 'Liens sociaux',
            'fa' => 'بوکمارک های شبکه های اجتماعی',
	);

	/**
	 * The translations for the widget description
	 *
	 * @var array
	 */
	public $description = array(
		'en' => 'Configurable social bookmark links from AddThis',
		'el' => 'Παραμετροποιήσιμα στοιχεία κοινωνικής δικτυώσης από το AddThis',
		'nl' => 'Voeg sociale bladwijzers toe vanuit AddThis',
		'br' => 'Adiciona links de redes sociais usando o AddThis, podendo fazer algumas configurações',
		'pt' => 'Adiciona links de redes sociais usando o AddThis, podendo fazer algumas configurações',
		'ru' => 'Конфигурируемые социальные закладки с сайта AddThis',
		'id' => 'Tautan social bookmark yang dapat dikonfigurasi dari AddThis',
		'fi' => 'Konfiguroitava sosiaalinen kirjanmerkki linkit AddThis:stä',
		'fr' => 'Liens sociaux personnalisables avec AddThis',
            'fa' => 'تنظیم و نمایش لینک های شبکه های اجتماعی',
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
	public $version = '1.0.0';

	/**
	 * The fields for customizing the options of the widget.
	 *
	 * @var array 
	 */
	public $fields = array(
		array(
			'field' => 'mode',
			'label' => 'Mode',
			'rules' => 'required'
		)
	);

	/**
	 * The main function of the widget.
	 *
	 * @param array $options The options for the AddThis widget.
	 * @return array 
	 */
	public function run($options)
	{
		!empty($options['mode']) OR $options['mode'] = 'default';

		return $options;
	}

}