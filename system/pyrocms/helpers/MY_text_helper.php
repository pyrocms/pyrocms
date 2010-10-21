<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

/**
 * CodeIgniter Text Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Rick Ellis
 * @link		http://www.codeigniter.com/user_guide/helpers/text_helper.html
 */

// ------------------------------------------------------------------------

function nl2p($str)
{
  return str_replace('<p></p>', '', '<p>'
        . nl2br(preg_replace('#([\r\n]\s*?[\r\n]){2,}#', '</p>$0<p>', $str))
        . '</p>');
}

/**
 * Returns a string with all spaces converted to underscores (by default), accented
 * characters converted to non-accented characters, and non word characters removed.
 *
 * @param string $string the string you want to slug
 * @param string $replacement will replace keys in map
 * @return string
 * @access public
 */
function convert_accented_characters($string, $replacement = '-')
{
  $string = strtolower($string);
  
  $foreign_characters = array(
  '/ä|æ|ǽ/' => 'ae',
  '/ö|œ/' => 'oe',
  '/ü/' => 'ue',
  '/Ä/' => 'Ae',
  '/Ü/' => 'Ue',
  '/Ö/' => 'Oe',
  '/À|Á|Â|Ã|Ä|Å|Ǻ|Ā|Ă|Ą|Ǎ/' => 'A',
  '/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª/' => 'a',
  '/Ç|Ć|Ĉ|Ċ|Č/' => 'C',
  '/ç|ć|ĉ|ċ|č/' => 'c',
  '/Ð|Ď|Đ/' => 'D',
  '/ð|ď|đ/' => 'd',
  '/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě/' => 'E',
  '/è|é|ê|ë|ē|ĕ|ė|ę|ě/' => 'e',
  '/Ĝ|Ğ|Ġ|Ģ/' => 'G',
  '/ĝ|ğ|ġ|ģ/' => 'g',
  '/Ĥ|Ħ/' => 'H',
  '/ĥ|ħ/' => 'h',
  '/Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Ǐ|Į|İ/' => 'I',
  '/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı/' => 'i',
  '/Ĵ/' => 'J',
  '/ĵ/' => 'j',
  '/Ķ/' => 'K',
  '/ķ/' => 'k',
  '/Ĺ|Ļ|Ľ|Ŀ|Ł/' => 'L',
  '/ĺ|ļ|ľ|ŀ|ł/' => 'l',
  '/Ñ|Ń|Ņ|Ň/' => 'N',
  '/ñ|ń|ņ|ň|ŉ/' => 'n',
  '/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ/' => 'O',
  '/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º/' => 'o',
  '/Ŕ|Ŗ|Ř/' => 'R',
  '/ŕ|ŗ|ř/' => 'r',
  '/Ś|Ŝ|Ş|Š/' => 'S',
  '/ś|ŝ|ş|š|ſ/' => 's',
  '/Ţ|Ť|Ŧ/' => 'T',
  '/ţ|ť|ŧ/' => 't',
  '/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ/' => 'U',
  '/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ/' => 'u',
  '/Ý|Ÿ|Ŷ/' => 'Y',
  '/ý|ÿ|ŷ/' => 'y',
  '/Ŵ/' => 'W',
  '/ŵ/' => 'w',
  '/Ź|Ż|Ž/' => 'Z',
  '/ź|ż|ž/' => 'z',
  '/Æ|Ǽ/' => 'AE',
  '/ß/'=> 'ss',
  '/Ĳ/' => 'IJ',
  '/ĳ/' => 'ij',
  '/Œ/' => 'OE',
  '/ƒ/' => 'f'
  );
  
  if (is_array($replacement))
  {
    $map = $replacement;
    $replacement = '_';
  }
  
  $quotedReplacement = preg_quote($replacement, '/');
  
  $merge = array(
                '/[^\s\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => ' ',
                '/\\s+/' => $replacement,
                sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement) => '',
                );
  
  $map = $foreign_characters + $merge;
  return preg_replace(array_keys($map), array_values($map), $string);
}
?>