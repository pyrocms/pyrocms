<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Show a login box in your widget areas
 *
 * @package 		PyroCMS
 * @subpackage 		Widgets
 * @author			PyroCMS Development Team
 * @copyright		PyroCMS Development Team
 * @license			http://pyrocms.com/legal/license
 * @since			1.0
 */

class Widget_Login extends Widgets
{
	/**
	 * @var  string  Name of the widget in an array, with lang code as the key.
	 */
	public $title		= array(
		'en' => 'Login',
		'nl' => 'Login',
		'br' => 'Login',
		'ru' => 'Вход на сайт',
	);
	
	/**
	 * @var  array  Description of the widget in an array, with lang code as the key.
	 */
	public $description	= array(
		'en' => 'Display a simple login form anywhere',
		'br' => 'Permite colocar um formulário de login em qualquer lugar do seu site',
		'nl' => 'Toon overal een simpele loginbox',
		'ru' => 'Выводит простую форму для входа на сайт',
	);
	
	/**
	 * @var  string  Name of the Widget author
	 */
	public $author		= 'Phil Sturgeon';
	
	/**
	 * @var  string  Widget authors website
	 */
	public $website		= 'http://philsturgeon.co.uk/';
	
	/**
	 * @var  string  Widget version
	 */
	public $version		= '1.0';

	/**
	 * Runs code and logic required to display the widget.
	 *
	 * @access	public
	 * @return	void
	 */
	public function run()
	{
		return !$this->ion_auth->logged_in();
	}
}