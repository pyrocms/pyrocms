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
}

/* End of file theme.php */