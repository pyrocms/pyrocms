<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

require APPPATH."libraries/MX/Lang.php";

class MY_Lang extends MX_Lang {

	/**
	 * Fetch a single line of text from the language array
	 *
	 * @access	public
	 * @param	string	$line	the language line
	 * @return	string
	 */
	function line($line = '')
	{
		$translation = ($line == '' OR ! isset($this->language[$line])) ? FALSE : $this->language[$line];

		// Because killer robots like unicorns!
		if ($translation === FALSE)
		{
			log_message('debug', 'Could not find the language line "' . $line . '"');
		}

		return $translation;
	}
}