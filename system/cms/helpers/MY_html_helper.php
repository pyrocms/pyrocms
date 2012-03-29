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
	 * The second parameter can have
	 *
	 * @param array $items An array of items that may or may not have children.
	 * @param array $extra Attributes for the <li /> and the <a /> elements of the tree.
	 *
	 * @internal param array $item An item that may or may not have children.
	 * @internal param $options
	 *
	 * @internal param string $id_prefix A prefix for the <li /> id attribute.
	 * @internal param string $group_id The
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
	 * <code>
	 *  $attrs = array( 'id' => 'prefix_:id:' );
	 *  $extra = array( 'id' => 1, 'rel' => 'cool-link' );
	 * </code>
	 * outputs:
	 * <code> id="prefix_1" rel="cool-link"</code>
	 *
	 * @param array $attrs
	 * @param array $extra
	 * @return string The attributes
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