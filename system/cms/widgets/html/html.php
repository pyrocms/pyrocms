<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Show RSS feeds in your site
 * 
 * @author  	Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Widgets
 */
class Widget_Html extends Widgets
{


	/**
	 * The widget title
	 *
	 * @var array
	 */
	public $title = 'HTML';

	/**
	 * The translations for the widget description
	 *
	 * @var array
	 */
	public $description = array(
		'en' => 'Create blocks of custom HTML',
		'el' => 'Δημιουργήστε περιοχές με δικό σας κώδικα HTML',
		'br' => 'Permite criar blocos de HTML customizados',
		'pt' => 'Permite criar blocos de HTML customizados',
		'nl' => 'Maak blokken met maatwerk HTML',
		'ru' => 'Создание HTML-блоков с произвольным содержимым',
		'id' => 'Membuat blok HTML apapun',
		'fi' => 'Luo lohkoja omasta HTML koodista',
		'fr' => 'Créez des blocs HTML personnalisés',
            'fa' => 'ایجاد قسمت ها به صورت اچ تی ام ال',
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
			'field' => 'html',
			'label' => 'HTML',
			'rules' => 'required'
		)
	);

	/**
	 * The main function of the widget.
	 *
	 * @param array $options The options for displaying an HTML widget.
	 * @return array 
	 */
	public function run($options)
	{
		if (empty($options['html']))
		{
			return array('output' => '');
		}

		// Store the feed items
		return array('output' => $this->parser->parse_string($options['html'], null, true));
	}

}