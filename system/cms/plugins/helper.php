<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Session Plugin
 *
 * Read and write session data
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2011, PyroCMS
 *
 */
class Plugin_Helper extends Plugin
{
	static $_counter_increment = TRUE;

	/**
	 * Data
	 *
	 * Loads a theme partial
	 *
	 * Usage:
	 * {pyro:helper:lang line="foo"}
	 *
	 * @param	array
	 * @return	array
	 */
	public function lang()
	{
		$line = $this->attribute('line');
		return $this->lang->line($line);
	}

	public function date()
	{
        $this->load->helper('date');

		$format		= $this->attribute('format');
		$timestamp	= $this->attribute('timestamp');

		return $timestamp ? format_date($timestamp, $format) : format_date(now(), $format);
	}

	public function gravatar()
	{
		$email		= $this->attribute('email', '');
		$size		= $this->attribute('size', '50');
		$rating		= $this->attribute('rating', 'g');
																	//deprecated
		$url_only	= (bool) in_array($this->attribute('url-only', $this->attribute('url_only', 'false')), array('1', 'y', 'yes', 'true'));

		return gravatar($email, $size, $rating, $url_only);
	}

	public function strip()
	{
		return preg_replace('!\s+!', $this->attribute('replace', ' '), $this->content());
	}
	
	/**
	 * Add counting to tag loops
	 *
	 * Usage:
	 * {pyro:blog:posts}
	 * 		{pyro:helper:count} -- {title}
	 * {/pyro:blog:posts}
	 *
	 * Outputs:
	 * 1 -- This is an example title
	 * 2 -- This is another title
	 *
	 * Another example:
	 * {pyro:blog:posts}
	 * 		{pyro:helper:count mode="subtract" start="10"} -- {title}
	 * {/pyro:blog:posts}
	 *
	 * Outputs:
	 * 10 -- This is an example title
	 * 9  -- This is another title
	 *
	 * You can add a second counter to a page by setting a unique identifier:
	 * {pyro:files:listing folder="foo"}
	 * 		{pyro:helper:count identifier="files" return="false"}
	 * 		{name} -- {slug}
	 * 	{/pyro:files:listing}
	 * 	You have {pyro:helper:show_count identifier="files"} files.
	 *
	 * 	Outputs:
	 * 	Test -- test
	 * 	Second -- second
	 * 	You have 2 files.
	 */
	public function count()
	{
		static $count = array();
		$identifier = $this->attribute('identifier', 'default');

		// Use a default of 1 if they haven't specified one and it's the first iteration
		if ( ! isset($count[$identifier])) $count[$identifier] = $this->attribute('start', 1);

		// lets check to see if they're only wanting to show the count
		if (self::$_counter_increment)
		{
			// count up unless they specify to "subtract"
			$value = ($this->attribute('mode') == 'subtract') ? $count[$identifier]-- : $count[$identifier]++;

			// go ahead and increment but return an empty string
			if (strtolower($this->attribute('return')) === 'false')
			{
				return '';
			}
			return $value;
		}
		return $count[$identifier];
	}
	
	public function show_count()
	{
		self::$_counter_increment = FALSE;

		return self::count();
	}
}

/* End of file theme.php */