<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

/**
 * CodeIgniter Array Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Philip Sturgeon
 * @link		http://www.codeigniter.com/user_guide/helpers/text_helper.html
 */

// ------------------------------------------------------------------------

function array_object_merge(&$object, $array) {
    if(!is_array($array)) {
    	$array = get_object_vars($array);
    }
	
	foreach ($array as $key => $value):
        $object->{$key} = $value;
    endforeach;
}

function array_for_select() {
	
	$args = func_get_args();

	$return = array();
	
	switch(count($args)):
		
		case 3:
			foreach ($args[0] as $itteration):
				if(is_object($itteration)) $itteration = (array) $itteration;
		        $return[$itteration[$args[1]]] = $itteration[$args[2]];
		    endforeach;
		break;
		
		case 2:
			foreach ($args[0] as $key => $itteration):
				if(is_object($itteration)) $itteration = (array) $itteration;
		        $return[$key] = $itteration[$args[1]];
		    endforeach;
		break;
		
		case 1:
			foreach ($args[0] as $itteration):
		        $return[$itteration] = $itteration;
		    endforeach;
		break;
		
		default:
			return FALSE;
		break;
	
	endswitch;
    
    return $return;
}

?>