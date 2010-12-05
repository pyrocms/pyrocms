<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Navigation Plugin
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2010, PyroCMS
 *
 */
class Plugin_Navigation extends Plugin
{
	/**
	 * News List
	 *
	 * Creates a list of news posts
	 *
	 * Usage:
	 * {pyro:navigation:list group="header"}
	 *
	 * @param	array
	 * @return	array
	 */
	function links()
	{
		$group = $this->attribute('group');
		$tag = $this->attribute('tag', 'li');
		$current_class = $this->attribute('class', 'current');
		$separator = $this->attribute('separator', '');

		$this->load->model('navigation/navigation_m');
		$links = $this->cache->model('navigation_m', 'load_group', array($group), $this->settings->navigation_cache);

		$list = '';
		$array = array();

		if ($links)
		{
			$i = 1;
			foreach ($links as $link)
			{
				if(!empty($link->target)) $attributes['target'] = $link->target;
				$attributes['class']  = $link->class;

				if (current_url() == $link->url)
				{
					$attributes['class'] .= ' '.$current_class;
				}

				// Just return data
				if ($this->content())
				{
					$array[] = $attributes + array('url' => $link->url, 'title' => $link->title);
				}

				else
				{
					$list .= '<'.$tag.'>' . anchor($link->url, $link->title, $attributes). '</'.$tag.'>'.PHP_EOL;
					if ($separator AND count($links) > $i) $list .= $separator;
					$i++;
				}
			}
		}

    	return $this->content() ? $array : $list;
	}
}

/* End of file news.plugin.php */