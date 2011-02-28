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
	public $description = 'Display a list of old months with links to posts in those months.';
	public $author = 'Phil Sturgeon';
	public $website = 'http://philsturgeon.co.uk/';
	public $version = '1.0';
	
	public function run($options)
	{
		$this->load->model('blog/blog_m');
		$this->lang->load('blog/blog');

		return array(
			'archive_months' => $this->blog_m->get_archive_months()
		);
	}
	
}