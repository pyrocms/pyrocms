<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Plugin Helpers
 *
 * @author   PyroCMS Dev Team
 * @package  PyroCMS\Core\Helpers
 */

/**
 * Converts {{ }} to proper entities to prevent parsing
 * 
 * @param string $string
 * @return string
 */
if ( ! function_exists('no_parse') ) {
	function no_parse($string = '') {
		return str_replace(array('{{','}}'), array('&#123;&#123;','&#125;&#125;'), $string);
	}
}


/**
 * Converts various string bools to a true bool
 * 
 * @param string $value
 * @param bool   $strict  Value has to match a truthy string
 * @return bool
 */
if ( ! function_exists('str_to_bool') ) {
	function str_to_bool($value = '', $strict = false) {
		if ( is_bool($value) ) {
			return $value;
		}
		elseif ( in_array(strtolower($value), array('no', 'n', 'false', '0')) ) {
			$bool = false;
		}
		elseif ($strict) {
			$bool = in_array(strtolower($value), array('yes', 'y', 'true', '1'));
		}
		else {
			$bool = true;
		}
		return $bool;
	}
}

/* EOF */