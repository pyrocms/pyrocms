<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package 		PyroCMS
 * @subpackage 		RSS Feed Widget
 * @author			Phil Sturgeon - PyroCMS Development Team
 * 
 * Show RSS feeds in your site
 */

class Widget_Archive extends Widgets
{
	public $title		= array(
		'en' => 'Archive',
		'pt' => 'Arquivo do Blog',
		'ru' => 'Архив',
	);
	public $description	= array(
		'en' => 'Display a list of old months with links to posts in those months',
		'pt' => 'Mostra uma lista navegação cronológica contendo o índice dos artigos publicados mensalmente',
		'ru' => 'Выводит список по месяцам со ссылками на записи в этих месяцах',
	);
	public $author		= 'Phil Sturgeon';
	public $website		= 'http://philsturgeon.co.uk/';
	public $version		= '1.0';
	
	public function run($options)
	{
		$this->load->model('blog/blog_m');
		$this->lang->load('blog/blog');

		return array(
			'archive_months' => $this->blog_m->get_archive_months()
		);
	}	
}