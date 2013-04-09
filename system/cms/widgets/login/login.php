<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Show a login box in your widget areas
 * 
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Widgets
 */
class Widget_Login extends Widgets
{

	/**
	 * The translations for the widget title
	 *
	 * @var array
	 */
	public $title = array(
		'en' => 'Login',
		'el' => 'Σύνδεση',
		'nl' => 'Login',
		'br' => 'Login',
		'pt' => 'Login',
		'ru' => 'Вход на сайт',
		'id' => 'Login',
		'fi' => 'Kirjautuminen',
		'fr' => 'Connexion',
            'fa' => 'لاگین',
	);

	/**
	 * The translations for the widget description
	 *
	 * @var array
	 */
	public $description = array(
		'en' => 'Display a simple login form anywhere',
		'el' => 'Προβάλετε μια απλή φόρμα σύνδεσης χρήστη οπουδήποτε',
		'br' => 'Permite colocar um formulário de login em qualquer lugar do seu site',
		'pt' => 'Permite colocar um formulário de login em qualquer lugar do seu site',
		'nl' => 'Toon overal een simpele loginbox',
		'ru' => 'Выводит простую форму для входа на сайт',
		'id' => 'Menampilkan form login sederhana',
		'fi' => 'Näytä yksinkertainen kirjautumislomake missä vain',
		'fr' => 'Affichez un formulaire de connexion où vous souhaitez',
            'fa' => 'نمایش یک لاگین ساده در هر قسمتی از سایت',
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
	 * Runs code and logic required to display the widget.
	 */
	public function run()
	{
		return !$this->ion_auth->logged_in();
	}

}