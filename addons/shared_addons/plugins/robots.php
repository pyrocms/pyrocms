<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Example Plugin
 *
 * Quick plugin to demonstrate how things work
 * 
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Addon\Plugins
 */
class Plugin_Robots extends Plugin
{
	/**
	 * Hello
	 *
	 * Usage:
	 * {{ robots:hello }}
	 *
	 * @return string
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