<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package 		PyroCMS
 * @subpackage 		RSS Feed Widget
 * @author			Phil Sturgeon - PyroCMS Development Team
 * 
 * Show RSS feeds in your site
 */

class Widget_Navigation extends Widgets
{
	public $title = 'Navigation';
	public $description = 'Display a navigation group with a widget.';
	public $author = 'Phil Sturgeon';
	public $website = 'http://philsturgeon.co.uk/';
	public $version = '1.0';
	
	public $fields = array(
		array(
			'field'   => 'group',
			'label'   => 'Navigation group',
			'rules'   => 'required'
		)
	);

	public function form()
	{
		$this->load->model('navigation/navigation_m');

		$groups = array();
		foreach($this->navigation_m->get_groups() as $group)
		{
			$groups[$group->abbrev] = $group->title;
		}

		return array(
			'groups' => $groups
		);
	}

	public function run($options)
	{
		$this->load->model('navigation/navigation_m');
		$links = $this->cache->model('navigation_m', 'load_group', $options['group'], $this->settings->item('navigation_cache'));
		return array('links' => $links);
	}
}