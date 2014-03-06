<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Show a list of blog categories.
 *
 * @author        Stephen Cozart
 * @author        PyroCMS Dev Team
 * @package       PyroCMS\Core\Modules\Blog\Widgets
 */
class Widget_Blog_categories extends Widgets
{
	public $author = 'Stephen Cozart';

	public $website = 'http://github.com/clip/';

	public $version = '1.0.0';

	public $title = array(
		'en' => 'Blog Categories',
		'br' => 'Categorias do Blog',
		'pt' => 'Categorias do Blog',
		'el' => 'Κατηγορίες Ιστολογίου',
		'fr' => 'Catégories du Blog',
		'ru' => 'Категории Блога',
		'id' => 'Kateori Blog',
            'fa' => 'مجموعه های بلاگ',
	);

	public $description = array(
		'en' => 'Show a list of blog categories',
		'br' => 'Mostra uma lista de navegação com as categorias do Blog',
		'pt' => 'Mostra uma lista de navegação com as categorias do Blog',
		'el' => 'Προβάλει την λίστα των κατηγοριών του ιστολογίου σας',
		'fr' => 'Permet d\'afficher la liste de Catégories du Blog',
		'ru' => 'Выводит список категорий блога',
		'id' => 'Menampilkan daftar kategori tulisan',
            'fa' => 'نمایش لیستی از مجموعه های بلاگ',
	);

	public function run()
	{
		$this->load->model('blog/blog_categories_m');

		$categories = $this->blog_categories_m->order_by('title')->get_all();

		return array('categories' => $categories);
	}

}
