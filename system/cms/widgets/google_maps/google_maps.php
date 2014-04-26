<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Show a Google Map in your site
 * 
 * @author		Gregory Athons
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Widgets
 */
class Widget_Google_maps extends Widgets
{

	/**
	 * The translations for the widget title
	 *
	 * @var array
	 */
	public $title = array(
		'en' => 'Google Maps',
		'el' => 'Χάρτης Google',
		'nl' => 'Google Maps',
		'br' => 'Google Maps',
		'pt' => 'Google Maps',
		'ru' => 'Карты Google',
		'id' => 'Google Maps',
		'fi' => 'Google Maps',
		'fr' => 'Google Maps',
            'fa' => 'نقشه گوگل',
	);

	/**
	 * The translations for the widget description
	 *
	 * @var array
	 */
	public $description = array(
		'en' => 'Display Google Maps on your site',
		'el' => 'Προβάλετε έναν Χάρτη Google στον ιστότοπό σας',
		'nl' => 'Toon Google Maps in uw site',
		'br' => 'Mostra mapas do Google no seu site',
		'pt' => 'Mostra mapas do Google no seu site',
		'ru' => 'Выводит карты Google на страницах вашего сайта',
		'id' => 'Menampilkan Google Maps di Situs Anda',
		'fi' => 'Näytä Google Maps kartta sivustollasi',
		'fr' => 'Publiez un plan Google Maps sur votre site',
            'fa' => 'نمایش داده نقشه گوگل بر روی سایت ',
	);

	/**
	 * The author of the widget
	 *
	 * @var string
	 */
	public $author = 'Gregory Athons';

	/**
	 * The author's website.
	 * 
	 * @var string 
	 */
	public $website = 'http://www.gregathons.com';

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
			'field' => 'address',
			'label' => 'Address',
			'rules' => 'required'
		),
		array(
			'field' => 'width',
			'label' => 'Width',
			'rules' => 'required'
		),
		array(
			'field' => 'height',
			'label' => 'Height',
			'rules' => 'required'
		),
		array(
			'field' => 'zoom',
			'label' => 'Zoom Level',
			'rules' => 'numeric'
		),
		array(
			'field' => 'description',
			'label' => 'Description'
		)
	);

	/**
	 * The main function of the widget.
	 *
	 * @param array $options The options for displaying an Google Maps widget.
	 * @return array 
	 */
	public function run($options)
	{
		return $options;
	}

}