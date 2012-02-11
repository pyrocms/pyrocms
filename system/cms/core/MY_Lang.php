<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

require APPPATH."libraries/MX/Lang.php";

/**
 * General Language library class for using in PyroCMS
 * 
 * @package PyroCMS\Core\Libraries
 */
class MY_Lang extends MX_Lang {

	/**
	 * Fetch a single line of text from the language array
	 *
	 * @param string $line the language line
	 * @return string
	 */
	public function line($line = '')
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