<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package 		MizuCMS
 * @subpackage 		Login Widget
 * @author			Phil Sturgeon - MizuCMS Development Team
 * 
 * Show RSS feeds in your site
 */

class Widget_Login extends Widgets
{
	public $title = 'Login';
	public $description = 'Display a simple login form anywhere.';
	public $author = 'Phil Sturgeon';
	public $website = 'http://philsturgeon.co.uk/';
	public $version = '1.0';

	public function run()
	{
		return !$this->ion_auth->logged_in();
	}

}