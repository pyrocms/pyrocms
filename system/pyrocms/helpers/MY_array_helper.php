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

function array_object_merge(&$object, $array)
{
	is_array($array) OR $array = get_object_vars($array);
	
	foreach ($array as $key => $value)
	{
        $object->{$key} = $value;
	}
}

function array_for_select()
{
	$args =& func_get_args();

	$return = array();
	
	switch(count($args))
	{
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
	}
    
    return $return;
}

function html_to_assoc($html_array)
{
	$keys = array_keys($html_array);

	if (!isset($keys[0]))
	{
		return array();
	}

	$total = count(current($html_array));

	$array = array();

	for ($i = 0; $i < $total; $i++)
	{
		foreach ($keys as $key)
		{
			$array[$i][$key] = $html_array[$key][$i];
		}
	}

	return $array;
}

/**
 * Associative array property
 * 
 * Reindexes an array using a property of your elements. The elements should be a collection of
 * array or objects.
 * 
 * Obs.: To give a full result all elements must have the property defined in second param of
 * this function.
 * 
 * @author Marcos Coelho - PyroCMS development team
 * @access public
 * @param array $arr
 * @param string $prop Should be a commum property with value scalar, as id, slug, order..
 * @return array
 */
function assoc_array_prop(array &$arr = NULL, $prop = 'id')
{
	$newarr = array();

	foreach ($arr as $old_index => $element)
	{
		if (is_array($element))
		{
			if (isset($element[$prop]) && is_scalar($element[$prop]))
			{
				$newarr[$element[$prop]] = $element;
			}
		}
		elseif (is_object($element))
		{
			if (isset($element->{$prop}) && is_scalar($element->{$prop}))
			{
				$newarr[$element->{$prop}] = $element;
			}
		}
	}

	return $arr = $newarr;
}