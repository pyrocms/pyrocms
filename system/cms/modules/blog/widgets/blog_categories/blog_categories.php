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
		'br' => 'Categorias do Blog',
		'ru' => 'Категории Блога',
		'id' => 'Kateori Blog',
	);
	public $description	= array(
		'en' => 'Show a list of blog categories',
		'br' => 'Mostra uma lista de navegação com as categorias do Blog',
		'ru' => 'Выводит список категорий блога',
		'id' => 'Menampilkan daftar kategori tulisan',
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
