<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package 		PyroCMS
 * @subpackage 		Simple Blog Search Widget
 * @author			Michael Kyle Martin
 *
 */

class Widget_Blog_search extends Widgets
{
	public $title		= array(
		'en' => 'Blog Search',
	);
	public $description	= array(
		'en' => 'Simple widget for implementing frontend blog searches.',
	);
	public $author		= 'Michael Kyle Martin';
	public $website		= 'http://potionsfactory.com/';
	public $version		= '1.0';
	
	public function run($options)
	{
		/* No need to run options */
	}	
}
