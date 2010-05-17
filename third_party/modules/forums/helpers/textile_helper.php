<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/***
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 0.9.9.1
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Parse Textile
 *
 * Takes a string as input and parse the Textile
 *
 * @param	string	$str			The string to be parsed
 * @param	bool	$parse_smileys	Parse the smileys or not
 * @return	string
 */
function parse($str, $clear = 0, $parse_smileys = FALSE)
{
	$ci =& get_instance();
	if(!class_exists('Textile'))
	{
		$ci->load->library('Textile');
	}
	$str = htmlspecialchars_decode($str);
	$str = $ci->textile->TextileThis($str);

    if($parse_smileys)
	{
		// All this funky code applys smileys to anything OUTSIDE code blocks
		preg_match_all('/<code>.*?<\/code>/s', $str, $code_blocks, PREG_PATTERN_ORDER);
		$block_num = 0;
		foreach ($code_blocks[0] as $block)
		{
			$str = str_replace($block, "{block_$block_num}", $str);
			$block_num++;
		}
		$str = parse_smileys($str, image_url("smileys/"));

		$block_num = 0;
		foreach ($code_blocks[0] as $block)
		{
			$str = str_replace("{block_$block_num}", $block, $str);
			$block_num++;
		}
	}
	$str = preg_replace ( '/<code>*\s*/s', '<code>', $str);
    return preg_replace ( '/\s*<\/code>/s', '</code>', $str);
}

// ------------------------------------------------------------------------

function break_lines($string)
{
    if(strpos($string, "<code>") === FALSE)
    {
        return nl2br($string);
    }

    $lines = explode("\n", $string);
    $output = "";
    $in_code = FALSE;

    foreach($lines as $line)
    {
        if(strpos($line, "<code>") !== FALSE)
        {
            $in_code = TRUE;
        }
        elseif(strpos($line, "</code>") !== FALSE)
        {
            $in_code = FALSE;
        }

		if($in_code)
        {
            $output .= $line . "\n";
        }
        else
        {
            $output .= $line . "<br />";
        }
    }

    return $output;
}
/**
* Get bbCode Buttons
*
* Returns an array of bbcode buttons that can be clicked to be inserted
* into a form field.
*
* @access    public
* @return    array
*/

function get_buttons()
{
	$codes = _get_code_array();

	foreach ($codes as $key => $val)
    {
        $button[] = '<a href="#" id="'.$key.'" onclick="'.$val.'">' . $key . '</a>';
    }

    return $button;
}

// ------------------------------------------------------------------------

/**
* Get bbCode Array
*
* Fetches the config/bbcode.php file
*
* @access    private
* @return    mixed
*/
function _get_code_array()
{
	$CI =& get_instance();
    if ( ! $CI->load->config('textile', TRUE))
    {
        return FALSE;
    }

	return $CI->config->item('textile_buttons', 'textile');
}
