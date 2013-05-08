<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Navigation Plugin
 *
 * @author     PyroCMS Dev Team
 * @package    PyroCMS\Core\Modules\Navigation\Plugins
 */
class Plugin_Navigation extends Plugin
{

	public $version = '1.0.0';
	public $name = array(
		'en' => 'Navigation',
	);
	public $description = array(
		'en' => 'Build navigation links including links in dropdown menus.',
	);

	/**
	 * Returns a PluginDoc array that PyroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * All options are listed here but refer 
	 * to the Blog plugin for a larger example
	 *
	 * @todo fill the  array with details about this plugin, then uncomment the return value.
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'links' => array(
				'description' => array(
					'en' => 'Output links from a single navigation group. If [group_segment] is used it loads the group specified by that uri segment.'
				),
				'single' => true,
				'double' => true,
				'variables' => 'url|title|total|target|class|children }}{{ /children',
				'attributes' => array(
					'group' => array(
						'type' => 'text',// Can be: slug, number, flag, text, array, any.
						'flags' => '',
						'default' => 'asc',
						'required' => true,
					),
					'group_segment' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
					'top' => array(
						'type' => 'flag',
						'flags' => 'Y|N',
						'default' => 'N',
						'required' => false,
					),
					'separator' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
					'link_class' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
					'more_class' => array(
						'type' => 'text',
						'flags' => '',
						'default' => 'has_children',
						'required' => false,
					),
					'class' => array(
						'type' => 'text',
						'flags' => '',
						'default' => 'current',
						'required' => false,
					),
					'first_class' => array(
						'type' => 'text',
						'flags' => '',
						'default' => 'first',
						'required' => false,
					),
					'last_class' => array(
						'type' => 'text',
						'flags' => '',
						'default' => 'last',
						'required' => false,
					),
					'dropdown_class' => array(
						'type' => 'text',
						'flags' => '',
						'default' => 'dropdown',
						'required' => false,
					),
					'tag' => array(
						'type' => 'text',
						'flags' => '',
						'default' => 'li',
						'required' => false,
					),
					'list_tag' => array(
						'type' => 'text',
						'flags' => '',
						'default' => 'ul',
						'required' => false,
					),
					'wrap' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
					'max_depth' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
					'indent' => array(
						'type' => 'text',
						'flags' => 'Y|N',
						'default' => 'N',
						'required' => false,
					),
				),
			),// end links method
		);
	
		return $info;
	}

	/**
	 * Navigation
	 *
	 * Creates a list of menu items
	 *
	 * Usage:
	 * {{ navigation:links group="header" }}
	 * Optional:  indent="", tag="li", list_tag="ul", top="text", separator="", group_segment="", class="", more_class="", wrap=""
	 *
	 * @param  array
	 * @return  array
	 */
	public function links()
	{
		$group         = $this->attribute('group');
		$group_segment = $this->attribute('group_segment');

		is_numeric($group_segment) and $group = $this->uri->segment($group_segment);

		// We must pass the user group from here so that we can cache the results and still always return the links with the proper permissions
		$params = array(
			$group,
			array(
				'user_group' => ($this->current_user and isset($this->current_user->group)) ? $this->current_user->group : false,
				'front_end'  => true,
				'is_secure'  => IS_SECURE,
			)
		);

		$links = $this->pyrocache->model('navigation_m', 'get_link_tree', $params, config_item('navigation_cache'));

		return $this->_build_links($links, $this->content());
	}


	/**
	 * Builds the Page Tree into HTML
	 * 
	 * @param array $links      Page Tree array from `navigation_m->get_link_tree`
	 * @param bool  $return_arr Return as an Array instead of HTML
	 * @return array|string
	 */
	private function _build_links($links = array(), $return_arr = true)
	{
		static $current_link = false;
		static $level = 0;

		$top            = $this->attribute('top', false);
		$separator      = $this->attribute('separator', '');
		$link_class     = $this->attribute('link_class', '');
		$more_class     = $this->attribute('more_class', 'has_children');
		$current_class  = $this->attribute('class', 'current');
		$first_class    = $this->attribute('first_class', 'first');
		$last_class     = $this->attribute('last_class', 'last');
		$parent_class 	= $this->attribute('parent_class', 'parent');
		$dropdown_class = $this->attribute('dropdown_class', 'dropdown');
		$output         = $return_arr ? array() : '';
		$wrap           = $this->attribute('wrap');
		$max_depth      = $this->attribute('max_depth');
		$i              = 1;
		$total          = sizeof($links);

		if ( ! $return_arr )
		{
			$tag      = $this->attribute('tag', 'li');
			$list_tag = $this->attribute('list_tag', 'ul');

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

			if ( $indent )
			{
				$ident_a = repeater($indent, $level);
				$ident_b = $ident_a . $indent;
				$ident_c = $ident_b . $indent;
			}
		}

		foreach ($links as $link)
		{
			$item    = array();
			$wrapper = array();

			// attributes of anchor
			$item['url']   = $link['url'];
			$item['title'] = $link['title'];
			$item['total'] = $total;

			if ( $wrap )
			{
				$item['title'] = '<' . $wrap . '>' . $item['title'] . '</' . $wrap . '>';
			}

			$item['attributes']['target'] = $link['target'] ? 'target="' . $link['target'] . '"' : null;
			$item['attributes']['class']  = $link_class ? 'class="' . $link_class . '"' : '';

			// attributes of anchor wrapper
			$wrapper['class']     = $link['class'] ? explode(' ', $link['class']) : array();
			$wrapper['children']  = $return_arr ? array() : null;
			$wrapper['separator'] = $separator;

			// is single ?
			if ( $total === 1 )
			{
				$wrapper['class'][] = 'single';
			}

			// is first ?
			elseif ( $i === 1 )
			{
				$wrapper['class'][] = $first_class;
			}

			// is last ?
			elseif ( $i === $total )
			{
				$wrapper['class'][]   = $last_class;
				$wrapper['separator'] = '';
			}

			// has children ? build children
			if ( $link['children'] )
			{
				++$level;

				if ( ! $max_depth or $level < $max_depth )
				{
					$wrapper['class'][]  = $more_class;
					$wrapper['children'] = $this->_build_links($link['children'], $return_arr);
				}

				--$level;
			}

			// is this the link to the page that we're on?
			if ( preg_match('@^' . current_url() . '/?$@', $link['url']) or ($link['link_type'] == 'page' and $link['is_home']) and site_url() == current_url() )
			{
				$current_link       = $link['url'];
				$wrapper['class'][] = $current_class;
			}

			// Is this page a parent of the current page?
			// Get the URI and compare
			$uri_segments = explode('/', str_replace(site_url(), '', $link['url']));

			foreach ($uri_segments as $k => $seg)
			{
				if ( ! $seg)
				{
					unset($uri_segments[$k]);
				}
			}

			$short_segments 
				= array_slice($this->uri->segment_array(), 0, count($uri_segments));

			if ( ! array_diff($short_segments, $uri_segments))
			{
				$wrapper['class'][] = $parent_class;
			}

			// is the link we're currently working with found inside the children html?
			if ( ! in_array($current_class, $wrapper['class']) and
				isset($wrapper['children']) and
				$current_link and
				((is_array($wrapper['children']) and in_array_r($current_link, $wrapper['children'])) or
				(is_string($wrapper['children']) and strpos($wrapper['children'], $current_link)))
			)
			{
				// that means that this link is a parent
				$wrapper['class'][] = 'has_' . $current_class;
			}
			// if we are viewing something in a module (such as a blog post) that doesn't have a link then mark the link
			// to the module root with .has_current but not if it will already have .current
			elseif ($link['module_name'] === $this->module and ! preg_match('@^' . current_url() . '/?$@', $link['url']))
			{
				$wrapper['class'][] = 'has_' . $current_class;
			}

			++$i;

			if ( $return_arr )
			{
				$item['target']   =& $item['attributes']['target'];
				$item['class']    =& $item['attributes']['class'];
				$item['children'] = $wrapper['children'];

				if ( $wrapper['class'] && $item['class'] )
				{
					$item['class'] = implode(' ', $wrapper['class']) . ' ' . substr($item['class'], 7, -1);
				}
				elseif ( $wrapper['class'] )
				{
					$item['class'] = implode(' ', $wrapper['class']);
				}

				if ( $item['target'] )
				{
					$item['target'] = substr($item['target'], 8, -1);
				}

				// assign attributes to level family
				$output[] = $item;
			}
			else
			{
				$add_first_tag = $level === 0 && ! in_array($this->attribute('items_only', 'true'), array('1', 'y', 'yes', 'true'));

				// render and indent or only render inline?
				if ( $indent )
				{
					// remove all empty values so we don't have an empty class attribute
					$classes = implode(' ', array_filter($wrapper['class']));

					$output .= $add_first_tag ? "<{$list_tag}>" . PHP_EOL : '';
					$output .= $ident_b . '<' . $tag . ($classes > '' ? ' class="' . $classes . '">' : '>') . PHP_EOL;
					$output .= $ident_c . ((($level == 0) and $top == 'text' and $wrapper['children']) ? $item['title'] : anchor($item['url'], $item['title'], trim(implode(' ', $item['attributes'])))) . PHP_EOL;

					if ( $wrapper['children'] )
					{
						$output .= $ident_c . "<{$list_tag}>" . PHP_EOL;
						$output .= $ident_c . $indent . str_replace(PHP_EOL, (PHP_EOL . $indent), trim($ident_c . $wrapper['children'])) . PHP_EOL;
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
					$output .= (($level == 0) and $top == 'text' and $wrapper['children']) ? $item['title'] : anchor($item['url'], $item['title'], trim(implode(' ', $item['attributes'])));

					if ( $wrapper['children'] )
					{
						$output .= '<'.$list_tag.' class="'.$dropdown_class.'">';
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
