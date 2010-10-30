 <?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package 		PyroCMS
 * @subpackage 		Category Menu Widget
 * @author			Stephen Cozart
 * 
 * Show a list of news categories.
 */

class Widget_News_categories extends Widgets
{
	public $title = 'News Categories';
	public $description = 'Show a list of news categories.';
	public $author = 'Stephen Cozart';
	public $website = 'http://github.com/clip/';
	public $version = '1.0';
	
	public function run()
	{
		$this->load->model('news/news_categories_m');
		
		$categories = $this->news_categories_m->order_by('title')->get_all();
		
		return array('categories' => $categories);
	}
	
}