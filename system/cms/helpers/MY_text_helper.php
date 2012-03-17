<?php defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 * PyroCMS Text Helpers
 *
 * This overrides Codeigniter's helpers/array_helper.php file.
 * 
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Helpers
 */
if (!function_exists('nl2p'))
{

	/**
	 * Replaces new lines with p HTML element.
	 * 
	 * @param string $str The input string.
	 * @return string The HTML string.
	 */
	function nl2p($str)
	{
		return str_replace('<p></p>', '', '<p>'
						.nl2br(preg_replace('#([\r\n]\s*?[\r\n]){2,}#', '</p>$0<p>', $str))
						.'</p>');
	}

}

if (!function_exists('escape_tags'))
{

	/**
	 * Replaces the < and > with their HTML character code equivalents.
	 *
	 * @param string $string The string with tags.
	 * @return string The string with the tags escaped
	 */
	function escape_tags($string)
	{
		return str_replace(array('{', '}'), array('&#123;', '&#125;'), $string);
	}

}

if (!function_exists('process_data_jmr1'))
{

	// Set PCRE recursion limit to sane value = STACKSIZE / 500 (256KB stack. Win32 Apache or  8MB stack. *nix)
	ini_set('pcre.recursion_limit', (strtolower(substr(PHP_OS, 0, 3)) === 'win' ? '524' : '16777'));

	/**
	 * Proccess data JMR1
	 *
	 * Minifying final HTML output
	 *
	 * @param string $text The HTML output
	 * @return string  The HTML without white spaces or the input text if its is too big to your SO proccess.
	 * @author Alan Moore, ridgerunner
	 * @author Marcos Coelho <marcos@marcoscoelho.com>
	 * @see http://stackoverflow.com/q/5312349
	 */
	function process_data_jmr1($text = '')
	{
		$re = '%                            # Collapse whitespace everywhere but in blacklisted elements.
        (?>                                 # Match all whitespans other than single space.
          [^\S]\s*                          # Either one [\t\r\n\f\v] and zero or more ws,
          |\s{2,}                           # or two or more consecutive-any-whitespace.
        )				                    # Note: The remaining regex consumes no text at all...
        (?=                                 # Ensure we are not in a blacklist tag.
          [^<]*+                            # Either zero or more non-"<" {normal*}
          (?:                               # Begin {(special normal*)*} construct
            <                               # or a < starting a non-blacklist tag.
            (?!/?(?:textarea|pre|script)\b)
            [^<]*+                          # more non-"<" {normal*}
          )*+                               # Finish "unrolling-the-loop"
          (?:                               # Begin alternation group.
            <                               # Either a blacklist start tag.
            (?>textarea|pre|script)\b
            |\z                             # or end of file.
          )                                 # End alternation group.
        )                                   # If we made it here, we are not in a blacklist tag.
        %Six';

		if (($data = preg_replace($re, ' ', $text)) === NULL)
		{
			log_message('error', 'PCRE Error! Output of the page "'.uri_string().'" is too big.');

			return $text;
		}

		return $data;
	}

}