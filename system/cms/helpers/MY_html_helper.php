<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PyroCMS Tree Helpers
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Helpers
 */
if (!function_exists('tree_builder'))
{
	/**
	 * Build the html for a tree view
	 *
	 * @param array $items An array of items that may or may not have children (under a key named `children` for each appropriate array entry).
	 * @param array $extra Attributes for the <li /> and the <a /> elements of the tree.
	 *
	 */
	function tree_builder($items, $extra)
	{
		if( is_array($items) )
		{
			foreach ($items as $item)
			{?>
			<li<?php echo _attributes($extra['li'], $item); ?>>
				<div>
					<a<?php echo _attributes($extra['a'], $item); ?>><?php echo $item['title']; ?></a>
				</div>
				<?php if (isset($item['children']) and ! empty($item['children'])): ?>
				<ul>
					<?php tree_builder($item['children'], $extra); ?>
				</ul>
				<?php endif; ?>
			</li>
			<?php }
		}
	}
}

if( ! function_exists('_attributes'))
{
	/**
	 * Allows for dynamic attribute values.
	 *
	 * Note: This function does nothing to protect you from XSS.
	 *
	 * Example:
	 * If this funtion is provided with:
	 * <code>
	 *  $attrs = array( 'id' => 'prefix_:id:' );
	 *  $extra = array( 'id' => 1, 'rel' => 'cool-link' );
	 * </code>
	 * outputs:
	 * <code>
	 *   id="prefix_1"
	 * </code>
	 * Notice two things:
	 *  - The `:id:` part of the `id` key in the $attrs array has been replaced by the value in the $extra array.
	 *  - The `rel` is not in the $attrs array and thus the value from the $extra array is not used.
	 *
	 * @param array $attrs An array with the templates for each of the attribute values, see the function documentation for explanation.
	 * @param array $extra The actual data to put in the respective attributes.
	 * @return string The attributes as a string ready for use in a tag.
	 */
	function _attributes($attrs = array(), $extra = array())
	{
		$out = '';
		foreach($attrs as $key => $value)
		{
			$tmp = $value;

			if( is_array($extra) and preg_match('/:(.+):/U', $value))
			{
				$tmp = preg_replace('/:(.+):/Ue', '$extra[\'$1\']', $tmp);
			}

			$out .= ' '.$key.'="'.$tmp.'"';
		}
		return $out;
	}
}