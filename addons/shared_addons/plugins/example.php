<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Example Plugin
 *
 * Quick plugin to demonstrate how things work
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Addon\Plugins
 * @copyright	Copyright (c) 2009 - 2010, PyroCMS
 */
class Plugin_Example extends Plugin
{
	public $version = '1.0';

	public $name = array(
		'en'	=> 'Example'
	);

	public $description = array(
		'en'	=> 'Example of PyroCMS plugin structure.'
	);

	/**
	 * Hello
	 *
	 * Usage:
	 * {{ example:hello }}
	 *
	 * @return string
	 */
	function hello()
	{
		$name = $this->attribute('name', 'World');
		
		return 'Hello '.$name.'!';
	}
}

/* End of file example.php */