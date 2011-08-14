<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package 		PyroCMS
 * @subpackage 		RSS Feed Widget
 * @author			Phil Sturgeon - PyroCMS Development Team
 * 
 * Show RSS feeds in your site
 */

class Widget_Navigation extends Widgets
{
	public $title		= array(
		'en' => 'Navigation',
		'pt' => 'Navegação',
		'ru' => 'Навигация',
	);
	public $description	= array(
		'en' => 'Display a navigation group with a widget',
		'pt' => 'Exibe um grupo de links de navegação como widget em seu site',
		'ru' => 'Отображает навигационную группу внутри виджета',
	);
	public $author		= 'Phil Sturgeon';
	public $website		= 'http://philsturgeon.co.uk/';
	public $version		= '1.0';
	
	public $fields = array(
		array(
			'field' => 'group',
			'label' => 'Navigation group',
			'rules' => 'required'
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

		$links = $this->pyrocache->model('navigation_m', 'get_link_tree', $options['group'], $this->settings->item('navigation_cache'));

		$widget		=& $options['widget'];
		$title		= isset($widget['title_tag'])	? '<' . $widget['title_tag'] . '>' . $widget['instance_title'] . '</' . $widget['title_tag'] . '>' : '';
		$list_tag	= isset($widget['list_tag'])	? $widget['list_tag']	: 'ul';
		$list_class	= isset($widget['list_class'])	? $widget['list_class']	: 'navigation';
		$list_id	= isset($widget['list_id'])		? $widget['list_id']	: '';
		$list_class = $list_class	? ' class="' . $list_class . '"'	: '';
		$list_id	= $list_id		? ' id="' . $list_id . '"'			: '';

		return array(
			'links'				=> $links,
			'title'				=> $title,
			'list_open_tag'		=> '<' . $list_tag . $list_id . $list_class . '>',
			'list_close_tag'	=> '</' . $list_tag . '>',
			'group'				=> $options['group']
		);
	}
}