<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Navigation Plugin
 * 
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Navigation\Plugins
 */
class Plugin_Navigation extends Plugin
{
	/**
	 * Navigation
	 *
	 * Creates a list of menu items
	 *
	 * Usage:
	 * {{ navigation:links group="header" }}
	 * Optional:  indent="", tag="li", list_tag="ul", top="text", separator="", group_segment="", class="", more_class="", wrap=""
	 * @param	array
	 * @return	array
	 */
	public function links()
	{
		$group			= $this->attribute('group');
		$group_segment	= $this->attribute('group_segment');

		is_numeric($group_segment) and $group = $this->uri->segment($group_segment);

		// We must pass the user group from here so that we can cache the results and still always return the links with the proper permissions
		$params = array(
			$group,
			array(
				'user_group' => ($this->current_user AND isset($this->current_user->group)) ? $this->current_user->group : false,
				'front_end' => true,
				'is_secure' => IS_SECURE,
			)
		);
		
		$links = $this->pyrocache->model('navigation_m', 'get_link_tree', $params, Settings::get('navigation_cache'));

		return $this->_build_links($links, $this->content());
	}

	private function _build_links($links = array(), $return_arr = true)
	{
		static $current_link	= false;
		static $level		= 0;

		$top			= $this->attribute('top', false);
		$separator		= $this->attribute('separator', '');
															//deprecated
		$link_class		= $this->attribute('link-class', $this->attribute('link_class', ''));
															//deprecated
		$more_class		= $this->attribute('more-class', $this->attribute('more_class', 'has_children'));
		$current_class	= $this->attribute('class', 'current');
		$first_class	= $this->attribute('first-class', 'first');
		$last_class		= $this->attribute('last-class', 'last');
		$output			= $return_arr ? array() : '';
		$wrap			= $this->attribute('wrap');
		$i		= 1;
		$total	= sizeof($links);

		if ( ! $return_arr)
		{
			$tag		= $this->attribute('tag', 'li');
														//deprecated
			$list_tag	= $this->attribute('list-tag', $this->attribute('list_tag', 'ul'));

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
					$indent = false;
					break;
			}

			if ($indent)
			{
				$ident_a = repeater($indent, $level);
				$ident_b = $ident_a . $indent;
				$ident_c = $ident_b . $indent;
			}
		}

		foreach ($links as $link)
		{
			$item		= array();
			$wrapper	= array();

			// attributes of anchor
			$item['url']					= $link['url'];
			$item['title']					= $link['title'];
			if($wrap)
			{
				$item['title']  = '<'.$wrap.'>'.$item['title'].'</'.$wrap.'>';
			}
			
			$item['attributes']['target']	= $link['target'] ? 'target="' . $link['target'] . '"' : null;
			$item['attributes']['class']	= $link_class ? 'class="' . $link_class . '"' : '';

			// attributes of anchor wrapper
			$wrapper['class']		= $link['class'] ? explode(' ', $link['class']) : array();
			$wrapper['children']	= $return_arr ? array() : null;
			$wrapper['separator']	= $separator;

			// is single ?
			if ($total === 1)
			{
				$wrapper['class'][] = 'single';
			}

			// is first ?
			elseif ($i === 1)
			{
				$wrapper['class'][] = $first_class;
			}

			// is last ?
			elseif ($i === $total)
			{
				$wrapper['class'][]		= $last_class;
				$wrapper['separator']	= '';
			}

			// has children ? build children
			if ($link['children'])
			{
				++$level;
				$wrapper['class'][] = $more_class;
				$wrapper['children'] = $this->_build_links($link['children'], $return_arr);
				--$level;
			}

			// is this the link to the page that we're on?
			if (preg_match('@^'.current_url().'/?$@', $link['url']) OR ($link['link_type'] == 'page' AND $link['is_home']) AND site_url() == current_url())
			{
				$current_link = $link['url'];
				$wrapper['class'][] = $current_class;
			}

			// is the link we're currently working with found inside the children html?
			if ( ! in_array($current_class, $wrapper['class']) AND 
				isset($wrapper['children']) AND 
				$current_link AND 
				((is_array($wrapper['children']) AND in_array($current_link, $wrapper['children'])) OR 
				(is_string($wrapper['children']) AND strpos($wrapper['children'], $current_link))))
			{
				// that means that this link is a parent
				$wrapper['class'][] = 'has_' . $current_class;
			}

			++$i;

			if ($return_arr)
			{
				$item['target']		=& $item['attributes']['target'];
				$item['class']		=& $item['attributes']['class'];
				$item['children']	= $wrapper['children'];

				if ($wrapper['class'] && $item['class'])
				{
					$item['class'] = implode(' ', $wrapper['class']) . ' ' . substr($item['class'], 7, -1);
				}
				elseif ($wrapper['class'])
				{
					$item['class'] = implode(' ', $wrapper['class']);
				}

				if ($item['target'])
				{
					$item['target'] = substr($item['target'], 8, -1);
				}

				// assign attributes to level family
				$output[] = $item;
			}
			else
			{
																							//deprecated
				$add_first_tag = $level === 0 && ! in_array($this->attribute('items-only', $this->attribute('items_only', 'true')), array('1','y','yes','true'));

				// render and indent or only render inline?
				if ($indent)
				{
					// remove all empty values so we don't have an empty class attribute
					$classes = implode(' ', array_filter($wrapper['class']));

					$output .= $add_first_tag ? "<{$list_tag}>" . PHP_EOL : '';
					$output .= $ident_b . '<' . $tag . ($classes > '' ? ' class="' . $classes . '">' : '>') . PHP_EOL;
					$output .= $ident_c . ((($level == 0) AND $top == 'text' AND $wrapper['children']) ? $item['title'] : anchor($item['url'], $item['title'], trim(implode(' ', $item['attributes'])))) . PHP_EOL;

					if ($wrapper['children'])
					{
						$output .= $ident_c . "<{$list_tag}>" . PHP_EOL;
						$output .= $ident_c . $indent . str_replace(PHP_EOL, (PHP_EOL . $indent),  trim($ident_c . $wrapper['children'])) . PHP_EOL;
						$output .= $ident_c . "</{$list_tag}>" . PHP_EOL;
					}

					$output .= $wrapper['separator'] ? $ident_c . $wrapper['separator'] . PHP_EOL : '';
					$output .= $ident_b . "</{$tag}>" . PHP_EOL;
					$output .= $add_first_tag ? $ident_a . "</{$list_tag}>" . PHP_EOL : '';
				}
				else
				{
					// remove all empty values so we don't have an empty class attribute
					$classes = implode(' ', array_filter($wrapper['class']));

					$output .= $add_first_tag ? "<{$list_tag}>" : '';
					$output .= '<' . $tag . ($classes > '' ? ' class="' . $classes . '">' : '>');
					$output .= (($level == 0) AND $top == 'text' AND $wrapper['children']) ? $item['title'] : anchor($item['url'], $item['title'], trim(implode(' ', $item['attributes'])));

					if ($wrapper['children'])
					{
						$output .= "<{$list_tag}>";
						$output .= $wrapper['children'];
						$output .= "</{$list_tag}>";
					}

					$output .= $wrapper['separator'];
					$output .= "</{$tag}>";
					$output .= $add_first_tag ? "</{$list_tag}>" : '';
				}
			}
		}

		return $output;
	}
}

/* End of file plugin.php */