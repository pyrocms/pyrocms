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
	 *
	 * @param	array
	 * @return	array
	 */
	function links()
	{
		$group = $this->attribute('group');
		$group_segment = $this->attribute('group_segment');
		$tag = $this->attribute('tag', 'li');
		$list_tag = $this->attribute('list_tag', 'ul');
		$separator = $this->attribute('separator', '');

		is_numeric($group_segment) ? $group = $this->uri->segment($group_segment) : NULL ;

		$this->load->model('navigation/navigation_m');
		$links = $this->cache->model('navigation_m', 'load_group', array($group), $this->settings->navigation_cache);

		$list = '';
		$array = array();

		if ($links)
		{
			$i = 1;
			$total = count($links);
			foreach ($links as $link)
			{
				$attributes['target'] = ( ! empty($link->target)) ? $link->target : NULL;
				$attributes['class']  = $link->class;

				if (current_url() == $link->url)
				{
					$attributes['class'] .= ' '.$this->attribute('class', 'current');
				}

				if ($i == 1)
				{
					$attributes['class'] .= ' '.$this->attribute('first_class', 'first');
				}

				if ($i == $total)
				{
					$attributes['class'] .= ' '.$this->attribute('last_class', 'last');
				}

				// Just return data
				if ($this->content())
				{
					$array[] = $attributes + array('url' => $link->url, 'title' => $link->title);
				}
		
				// Check for children
				if (!empty($link->children))
				{
					$list .= '<'.$tag.'>' . anchor($link->url, $link->title, $attributes) .  PHP_EOL;
					$list .= '<'.$list_tag.'>' . PHP_EOL;
					
					foreach($link->children as $child)
					{
						$attributes['target'] = ( ! empty($child->target)) ? $child->target : NULL;
						$attributes['class']  = $child->class;
						
						//add second level menu
						$list .= '<'.$tag.'>' . anchor($child->url, $child->title, $attributes) . PHP_EOL;

						if (!empty($child->children))
						{
							$list .= '<'.$list_tag.'>' . PHP_EOL;
							
							foreach($child->children as $infant)
							{
								$attributes['target'] = ( ! empty($infant->target)) ? $infant->target : NULL;
								$attributes['class']  = $infant->class;
				
								//add third level menu
								$list .= '<'.$tag.'>' . anchor($infant->url, $infant->title, $attributes) . PHP_EOL;
								
								//this is just getting weird
								if (!empty($infant->children))
								{
									$list .= '<'.$list_tag.'>' . PHP_EOL;
									
									foreach($infant->children as $item)
									{
										$attributes['target'] = ( ! empty($item->target)) ? $item->target : NULL;
										$attributes['class']  = $item->class;
				
										//add fourth level menu
										$list .= '<'.$tag.'>' . anchor($item->url, $item->title, $attributes). '</'.$tag.'>' . PHP_EOL;
									}
									
									$list .= '</'.$list_tag.'>' . PHP_EOL;
								}
								
								$list .= '</'.$tag.'>' . PHP_EOL;
							}
							
							$list .= '</'.$list_tag.'>' . PHP_EOL;
						}
						
						$list .= '</'.$tag.'>' . PHP_EOL;
					}
					
					$list .= '</'.$list_tag.'>' . PHP_EOL;
					$list .= '</'.$tag.'>' . PHP_EOL;
				}

				else
				{
					//top level menu
					$list .= '<'.$tag.'>' . anchor($link->url, $link->title, $attributes). '</'.$tag.'>' . PHP_EOL;
					if ($separator AND count($links) > $i)
					{
						$list .= $separator;
					}
					++$i;
				}
			}
		}

    	return $this->content() ? $array : $list;
	}
}

/* End of file plugin.php */
