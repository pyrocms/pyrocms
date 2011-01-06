<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Example Plugin
 *
 * Quick plugin to demonstrate how things work
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2009 - 2010, PyroCMS
 *
 */
class Plugin_Example extends Plugin
{
	/**
	 * Hello
	 *
	 * Usage:
	 * {pyro:example:hello}
	 *
	 * @param	array
	 * @return	array
	 */
	function hello()
	{
		$name = $this->attribute('name', 'World');
		
		return 'Hello '.$name.'!';
	}
}

/* End of file example.php */