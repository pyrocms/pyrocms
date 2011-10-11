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
class Plugin_Robots extends Plugin
{
	/**
	 * Hello
	 *
	 * Usage:
	 * {pyro:robots:hello}
	 *
	 * @param	array
	 * @return	array
	 */
	function hello()
	{
		$speech = trim($this->attribute('say', 'I am programmed for good... on week days. Bleep Blurp.'));

		$robot = '
	                    "'.$speech.'"
	          _____     /
	         /_____\\
	    ____[\\\'---\'/]____
	   /\\ #\\ \\_____/ /# /\\
	  /  \\# \\_.---._/ #/  \\
	 /   /|\\  |   |  /|\\   \\
	/___/ | | |   | | | \\___\\
	|  |  | | |---| | |  |  |
	|__|  \\_| |_#_| |_/  |__|
	//\\\\  <\\ _//^\\\\_ />  //\\\\
	\\||/  |\\//// \\\\\\\\/|  \\||/
	      |   |   |   |
	      |---|   |---|
	      |---|   |---|
	      |   |   |   |
	      |___|   |___|
	      /   \\   /   \\
	     |_____| |_____|
	     |HHHHH| |HHHHH|
		';
		return "<pre style=\"font-family: 'Courier New';\">$robot</pre>";
	}
}

/* End of file theme.php */