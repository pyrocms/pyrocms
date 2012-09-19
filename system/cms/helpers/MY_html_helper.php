<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PyroCMS Tree Helpers
 *
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @package PyroCMS\Core\Helpers
 */
if ( ! function_exists('tree_builder'))
{
	/**
	 * Build the html for a tree view
	 *
	 * @param array $items 	An array of items that may or may not have children (under a key named `children` for each appropriate array entry).
	 * @param array $html 	The html string to parse. Example: <li id="{{ id }}"><a href="#">{{ title }}</a>{{ children }}</li>
	 *
	 */
	function tree_builder($items, $html)
	{
		$output = '';

		if( is_array($items) )
		{
			foreach ($items as $item)
			{
				if (isset($item['children']) and ! empty($item['children']))
				{
					// if there are children we build their html and set it up to be parsed as {{ children }}
					$item['children'] = '<ul>'.tree_builder($item['children'], $html).'</ul>';
				}
				else
				{
					$item['children'] = null;
				}

				// now that the children html is sorted we parse the html that they passed
				$output .= ci()->parser->parse_string($html, $item, true);
			}

			return $output;
		}
	}
}