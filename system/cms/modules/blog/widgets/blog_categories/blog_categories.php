<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package 		PyroCMS
 * @subpackage 		Category Menu Widget
 * @author			Stephen Cozart
 * 
 * Show a list of blog categories.
 */

class Widget_Blog_categories extends Widgets
{
	public $title		= array(
		'en' => 'Blog Categories',
		'pt' => 'Categorias do Blog',
		'ru' => 'Категории Блога',
	);
	public $description	= array(
		'en' => 'Show a list of blog categories',
		'pt' => 'Mostra uma lista de navegação com as categorias do Blog',
		'ru' => 'Выводит список категорий блога',
	);
	public $author		= 'Stephen Cozart';
	public $website		= 'http://github.com/clip/';
	public $version		= '1.0';
	
	public function run()
	{
		$this->load->model('blog/blog_categories_m');
		
		$categories = $this->blog_categories_m->order_by('title')->get_all();
		
		return array('categories' => $categories);
	}	
}