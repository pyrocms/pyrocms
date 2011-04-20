<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Navigation Plugin
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2011, PyroCMS
 *
 */
class Plugin_Navigation extends Plugin
{
	/**
	 * Navigation
	 *
	 * Creates a list of menu items
	 *
	 * Usage:
	 * {pyro:navigation:links group="header"}
	 * Optional:  indent="", tag="li", list_tag="ul", separator="", group_segment="", class=""
	 * @param	array
	 * @return	array
	 */
	function links()
	{
		$group			= $this->attribute('group');
		$group_segment	= $this->attribute('group_segment');

		is_numeric($group_segment) ? $group = $this->uri->segment($group_segment) : NULL;

		$this->load->model('navigation/navigation_m');
		$links = $this->pyrocache->model('navigation_m', 'load_group', array($group), $this->settings->navigation_cache);

		return $this->_build_links($links, $this->content());
	}

	private function _build_links($links = array(), $return_arr = TRUE, $depth = 0)
	{
		static $is_current	= FALSE;
		static $level		= 0;

		$separator	= $this->attribute('separator', '');
		$classnames	= $this->attribute('class', '');
		$array		= array();

		$i		= 1;
		$total	= sizeof($links);

		foreach ($links as $link)
		{
			$attr = array();

			// attributes of anchor
			$attr['anchor']['url']		= $link->url;
			$attr['anchor']['title']	= $link->title;
			$attr['anchor']['attributes']['target']	= $link->target ? 'target="' . $link->target . '"' : NULL;
			$attr['anchor']['attributes']['class']	= $classnames ? 'class="' . $classnames. '"' : NULL;

			// attributes of anchor wrapper
			$attr['item']['class']		= $link->class ? explode(' ', $link->class) : array();
			$attr['item']['children']	= $return_arr ? array() : '';
			$attr['item']['separator']	= $separator;
			$attr['item']['level']		= $level;

			// is single ?
			if ($total === 1)
			{
				$attr['item']['class'][] = 'single';
			}

			// is first ?
			elseif ($i === 1)
			{
				$attr['item']['class'][] = 'first';
			}

			// is last ?
			elseif ($i === $total)
			{
				$attr['item']['class'][]	= 'last';
				$attr['item']['separator']	= '';
			}

			// is comum ?
			else
			{
				$attr['item']['class'][] = ''; // 'comum' ? lol
			}

			// has children ? build children
			if ($link->has_kids)
			{
				++$level;
				$attr['item']['children'] = $this->_build_links($link->children, $return_arr, $depth+1);
				--$level;
			}

			// is current ?
			if (current_url() === $link->url)
			{
				$is_current = TRUE;
				$attr['item']['class'][] = 'current';
			}

			// has children as current ?
			if ($is_current && $level === 0)
			{
				if ( ! in_array('current', $attr['item']['class']))
				{
					$attr['item']['class'][] = 'has_current';
				}

				// we've got the expected result, stop check if has current children
				$is_current = FALSE;
			}

			// assign attributes to depth family
			$array[] = $attr;

			++$i;
		}

		if ($return_arr)
		{
			foreach ($array as &$link)
			{
				$item = $link['item'];
				$link = $link['anchor'];
				$link['target'] =& $link['attributes']['target'];
				$link['class']	=& $link['attributes']['class'];
	
				if ($item['class'] && $link['class'])
				{
					$link['class'] = 'class="' . implode(' ', $item['class']) . ' ' . substr($link['class'], 7);
				}
				elseif ($item['class'])
				{
					$link['class'] = 'class="' . implode(' ', $item['class']) . '"';
				}
			}
			return $array;
		}

		$tag		= $this->attribute('tag', 'li');
		$list_tag	= $this->attribute('list_tag', 'ul');

		switch ($this->attribute('indent'))
		{
			case 't':
			case 'tab':
			case '	':
				$indent = "\t";
				break;
			case 's':
			case 'space':
			case ' ':
				$indent = "    ";
				break;
			default:
				$indent = FALSE;
				break;
		}

		// render and indent or only render inline?
		if ($indent)
		{
			$ident_a = repeater($indent, $level);
			$ident_b = $ident_a . $indent;
			$ident_c = $ident_b . $indent;

			$html = $level > 0 ? "<{$list_tag}>" . PHP_EOL : '';
			foreach ($array as $link)
			{
				$html .= $ident_b . '<' . $tag . ' class="' . implode(' ', $link['item']['class']) . '">' . PHP_EOL;
				$html .= $ident_c . anchor($link['anchor']['url'], $link['anchor']['title'], trim(implode(' ', $link['anchor']['attributes']))) . PHP_EOL;

				if ($link['item']['children'])
				{
					$html .= $ident_c . str_replace(PHP_EOL, (PHP_EOL . $indent),  trim($link['item']['children'])) . PHP_EOL;
				}

				if ($link['item']['separator'])
				{
					$html .= $ident_c . $link['item']['separator'] . PHP_EOL;
				}

				$html .= $ident_b . "</{$tag}>" . PHP_EOL;
			}
			$html .= $level > 0 ? $ident_a . "</{$list_tag}>" . PHP_EOL : '';
		}
		else
		{
			$html = $level > 0 ? "<{$list_tag}>" : '';
			foreach ($array as $link)
			{
				$html .= '<' . $tag . ' class="' . implode(' ', $link['item']['class']) . '">';
				$html .= anchor($link['anchor']['url'], $link['anchor']['title'], trim(implode(' ', $link['anchor']['attributes'])));
				$html .= $link['item']['children'];
				$html .= $link['item']['separator'];
				$html .= "</{$tag}>";
			}
			$html .= $level > 0 ? "</{$list_tag}>" : '';
		}

		return $html;
	}
}

/* End of file plugin.php */
