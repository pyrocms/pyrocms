<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

/**
 * CodeIgniter URL Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Philip Sturgeon
 */

// ------------------------------------------------------------------------

/**
 * Create URL Title - modified version
 *
 * Takes a "title" string as input and creates a
 * human-friendly URL string with either a dash
 * or an underscore as the word separator.
 * 
 * Added support for Cyrillic characters.
 *
 * @access	public
 * @param	string	the string
 * @param	string	the separator: dash, or underscore
 * @return	string
 */
if ( ! function_exists('url_title'))
{
	function url_title($str, $separator = 'dash', $lowercase = FALSE)
    {
        if ($separator == 'dash')
        {
            $search        = '_';
            $replace    = '-';
        }
        else
        {
            $search        = '-';
            $replace    = '_';
        }

        $from = array('ă','á','à','â','ã','ª','Á','À',
          'Â','Ã', 'é','è','ê','É','È','Ê','í','ì','î','Í',
          'Ì','Î','ò','ó','ô', 'õ','º','Ó','Ò','Ô','Õ','ş','Ş'
          ,'ţ','Ţ','ú','ù','û','Ú','Ù','Û','ç','Ç','Ñ','ñ');
        $to = array('a','a','a','a','a','a','A','A',
          'A','A','e','e','e','E','E','E','i','i','i','I','I',
          'I','o','o','o','o','o','O','O','O','O','s','S',
          't','T','u','u','u','U','U','U','c','C','N','n');
        $str = trim(str_replace($from, $to, $str));

        $trans = array(
                        '&\#\d+?;'                => '',
                        '&\S+?;'                => '',
                        '\s+'                    => $replace,
                        '[^a-zАБВГҐДЕЄЁЖЗИІЫЇЙКЛМНОПРСТУФХЦЧШЩэЮЯЬЪабвгґдеєёжзиіыїйклмнопрстуфхцчшщюяьъ0-9\-\._]' => '',
                        $replace.'+'            => $replace,
                        $replace.'$'            => $replace,
                        '^'.$replace            => $replace,
                        '\.+$'                    => ''
                      );

        $str = strip_tags($str);

        foreach ($trans as $key => $val)
        {
            $str = preg_replace("#".$key."#i", $val, $str);
        }

        if ($lowercase === TRUE)
        {
        	if( function_exists('mb_convert_case') )
			{
				$str = mb_convert_case($str, MB_CASE_LOWER, "UTF-8");
			}
			
			else
			{
				$str = strtolower($str);
			}
        }
        
        return trim(stripslashes($str));
    }
}

// ------------------------------------------------------------------------

/**
 * Shorten URL
 *
 * Takes a long url and uses the TinyURL API to
 * return a shortened version.
 * 
 * Added support for Cyrillic characters.
 *
 * @access	public
 * @param	string	long url
 * @return	string  short url
 */
function shorten_url($url = '')
{
	$CI =& get_instance();
	
	$CI->load->library('curl');

	if(!$url)
	{
		$url = site_url($CI->uri->uri_string());
	}
	
	// If no a protocol in URL, assume its a CI link
	elseif(!preg_match('!^\w+://! i', $url))
	{
		$url = site_url($url);
	}

	return $CI->curl->simple_get('http://tinyurl.com/api-create.php?url='.$url);
}

?>