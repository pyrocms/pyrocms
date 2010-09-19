<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package 		PyroCMS
 * @subpackage 		RSS Feed Widget
 * @author			Phil Sturgeon - PyroCMS Development Team
 * 
 * Show RSS feeds in your site
 */

class Widget_Archive extends Widgets
{
	public $title = 'Archive';
	public $description = 'Display a list of old months with links to articles in those months.';
	public $author = 'Phil Sturgeon';
	public $website = 'http://philsturgeon.co.uk/';
	public $version = '1.0';
	
	public function run($options)
	{
		$this->load->model('news/news_m');
		$this->lang->load('news/news');

		return array(
			'archive_months' => $this->news_m->get_archive_months()
		);
	}
	
}