<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* CodeIgniter
*
* An open source application development framework for PHP 4.3.2 or newer
*
* @package        CodeIgniter
* @author        Rick Ellis
* @copyright    Copyright (c) 2006, EllisLab, Inc.
* @license        http://www.codeignitor.com/user_guide/license.html
* @link        http://www.codeigniter.com
* @since        Version 1.0
* @filesource
*/

// ------------------------------------------------------------------------

/**
* CodeIgniter bbCode Helpers
*
* @package        CodeIgniter
* @subpackage    Helpers
* @category    Helpers
* @author        Santoni Jean-André
*/

// ------------------------------------------------------------------------

/**
* Parse bbCode
*
* Takes a string as input and replace bbCode by (x)HTML tags
*
* @access    public
* @param    string    the text to be parsed
* @return    string
*/
function parse($str, $clear = 0, $parse_smileys = FALSE)
{
	$bbcode_to_parse = _get_bbcode_to_parse_array();
	if (FALSE === ($bbcode_to_parse))
	{
		return FALSE;
	}
 
	foreach ($bbcode_to_parse as $key => $val)
    {
        for ($i = 1; $i <= $bbcode_to_parse[$key][2]; $i++) // loop for imbricated tags
        {
            $str = preg_replace($key, $bbcode_to_parse[$key][$clear], $str);
        }
    }

	$str = break_lines($str);
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
* Clear bbCode
*
* Takes a string as input and remove bbCode tags
*
* @access    public
* @param    string    the text to be parsed
* @return    string
*/
function clear_bbcode($str)
{
    return parse_bbcode($str, 1);
}

// ------------------------------------------------------------------------

/**
* Get bbCode Buttons
*
* Returns an array of bbcode buttons that can be clicked to be inserted
* into a form field.
*
* @access    public
* @return    array
*/

function get_buttons($bbcode = NULL)
{
    if ( ! is_array($bbcode))
    {
		$bbcode = _get_bbcode_array();
        if (FALSE === ($bbcode))
        {
            return FALSE;
        }
    }

    foreach ($bbcode as $key => $val)
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
function _get_bbcode_array()
{
	$CI =& get_instance();
    if ( ! $CI->load->config('bbcode', TRUE))
    {
        return FALSE;
    }


    return $CI->config->item('bbcodes', 'bbcode');
}

// ------------------------------------------------------------------------

/**
* Get bbCode Array for parsing
*
* Fetches the config/bbcode.php file
*
* @access    private
* @return    mixed
*/
function _get_bbcode_to_parse_array()
{
	$CI =& get_instance();
    if ( ! $CI->load->config('bbcode', TRUE))
    {
        return FALSE;
    }

    return $CI->config->item('bbcodes_to_parse', 'bbcode');
}
