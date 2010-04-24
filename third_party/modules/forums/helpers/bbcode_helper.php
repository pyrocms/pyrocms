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
* JS Insert bbCode
*
* Generates the javascrip function needed to insert bbcodes into a form field
*
* @access    public
* @param    string    form name
* @param    string    field name
* @return    string
*/

function js_insert_bbcode($form_name = '', $form_field = '')
{
    ?>
    <script type="text/javascript">
    function insert_bbcode(bbopen, bbclose)
    {
        var input = window.document.<?=$form_name.'.'.$form_field; ?>;
        input.focus();

        /* for Internet Explorer )*/
        if(typeof document.selection != 'undefined')
        {
            var range = document.selection.createRange();
            var insText = range.text;
            range.text = bbopen + insText + bbclose;
            range = document.selection.createRange();
            if (insText.length == 0)
            {
                range.move('character', -bbclose.length);
            }
            else
            {
                range.moveStart('character', bbopen.length + insText.length + bbclose.length);
            }
            range.select();
        }

        /* for newer browsers like Firefox */

        else if(typeof input.selectionStart != 'undefined')
        {
            var start = input.selectionStart;
            var end = input.selectionEnd;
            var insText = input.value.substring(start, end);
            input.value = input.value.substr(0, start) + bbopen + insText + bbclose + input.value.substr(end);
            var pos;
            if (insText.length == 0)
            {
                pos = start + bbopen.length;
            }
            else
            {
                pos = start + bbopen.length + insText.length + bbclose.length;
            }
            input.selectionStart = pos;
            input.selectionEnd = pos;
        }

        /* for other browsers like Netscape... */
        else
        {
            var pos;
            var re = new RegExp('^[0-9]{0,3}$');
            while(!re.test(pos))
            {
                pos = prompt("insertion (0.." + input.value.length + "):", "0");
            }
            if(pos > input.value.length)
            {
                pos = input.value.length;
            }
            var insText = prompt("Please tape your text");
            input.value = input.value.substr(0, pos) + bbopen + insText + bbclose + input.value.substr(pos);
        }
    }
    </script>
    <?php
}

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
function parse_bbcode($str, $clear = 0, $bbcode_to_parse = NULL)
{
    if ( ! is_array($bbcode_to_parse))
    {
		$bbcode_to_parse = _get_bbcode_to_parse_array();
        if (FALSE === ($bbcode_to_parse))
        {
            return FALSE;
        }
    }

    foreach ($bbcode_to_parse as $key => $val)
    {
        for ($i = 1; $i <= $bbcode_to_parse[$key][2]; $i++) // loop for imbricated tags
        {
            $str = preg_replace($key, $bbcode_to_parse[$key][$clear], $str);
        }
    }

    return nl2br($str);
}

// ------------------------------------------------------------------------

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

function get_bbcode_buttons($bbcode = NULL)
{
    if ( ! is_array($bbcode))
    {
        if (FALSE === ($bbcode = _get_bbcode_array()))
        {
            return $str;
        }
    }

    foreach ($bbcode as $key => $val)
    {
        $button[] = '<input type="button" class="button" id="'.$key.'" name="'.$key.'" value="'.$key.'" onClick="'.$val.'" />';
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


    return $CI->config->item('bbcode', 'bbcodes');
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
