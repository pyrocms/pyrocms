<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PyroCMS Array Helpers
 * 
 * This overrides Codeigniter's helpers/array_helper.php file.
 *
 * @author		Philip Sturgeon
 * @package		PyroCMS\Core\Helpers
 */


if (!function_exists('array_object_merge'))
{
	/**
	 * Merge an array or an object into another object
	 *
	 * @param object $object The object to act as host for the merge.
	 * @param object|array $array The object or the array to merge.
	 */
	function array_object_merge(&$object, $array)
	{
		// Make sure we are dealing with an array.
		is_array($array) OR $array = get_object_vars($array);

		foreach ($array as $key => $value)
		{
			$object->{$key} = $value;
		}
	}

}

if (!function_exists('array_for_select'))
{
	/**
	 * @todo Document this please.
	 *
	 * @return boolean 
	 */
	function array_for_select()
	{
		$args = & func_get_args();

		$return = array();

		switch (count($args))
		{
			case 3:
				foreach ($args[0] as $itteration):
					if (is_object($itteration))
						$itteration = (array) $itteration;
					$return[$itteration[$args[1]]] = $itteration[$args[2]];
				endforeach;
				break;

			case 2:
				foreach ($args[0] as $key => $itteration):
					if (is_object($itteration))
						$itteration = (array) $itteration;
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

}

if (!function_exists('html_to_assoc'))
{
	/**
	 * @todo Document this please.
	 * 
	 * @param array $html_array
	 * @return array 
	 */
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

}

if (!function_exists('html_to_assoc'))
{
	/**
	 * Associative array property
	 *
	 * Reindexes an array using a property of your elements. The elements should 
	 * be a collection of array or objects.
	 *
	 * Note: To give a full result all elements must have the property defined 
	 * in the second parameter of this function.
	 *
	 * @author Marcos Coelho
	 * @param array $arr
	 * @param string $prop Should be a common property with value scalar, as id, slug, order.
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

}