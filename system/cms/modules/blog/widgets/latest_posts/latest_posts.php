<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Show Latest blog on your site with a teaser from the intro field.
 *
 * Intended for use in cms pages or sidebar. Usage :
 * in a CMS page or sidebar add:
 *
 *     {{ widgets:area slug="name_of_area" }}
 *
 * 'name_of_area' is the name of the widget area you created in the  admin
 * control panel
 *
 * @author Erik Bermen
 * @author  PyroCMS Dev Team
 * @author  Michael Webber
 * @package PyroCMS\Core\Modules\Blog\Widgets
 */
class Widget_Latest_posts extends Widgets
{

	public $author = 'Erik Berman';

	public $website = 'http://www.nukleo.fr';

	public $version = '1.1.1';

	public $title = array(
		'en' => 'Latest posts',
		'br' => 'Artigos recentes do Blog',
		'fa' => 'آخرین ارسال ها',
		'pt' => 'Artigos recentes do Blog',
		'el' => 'Τελευταίες αναρτήσεις ιστολογίου',
		'fr' => 'Derniers articles',
		'ru' => 'Последние записи',
		'id' => 'Post Terbaru',
		
	);

	public $description = array(
		'en' => 'Displays most recent (n) posts with partial content',
		'br' => 'Mostra uma lista de navegação para abrir os últimos artigos publicados no Blog',
		'fa' => 'نمایش آخرین پست های وبلاگ در یک ویجت',
		'pt' => 'Mostra uma lista de navegação para abrir os últimos artigos publicados no Blog',
		'el' => 'Προβάλει τις πιο πρόσφατες αναρτήσεις στο ιστολόγιό σας',
		'fr' => 'Permet d\'afficher la liste des derniers posts du blog dans un Widget',
		'ru' => 'Выводит список последних записей блога внутри виджета',
		'id' => 'Menampilkan posting blog terbaru menggunakan widget',
	);

	// build form fields for the backend
	// MUST match the field name declared in the form.php file
	public $fields = array(
		array(
			'field' => 'limit',
			'label' => 'Number of posts',
		),
		array(
			'field' => 'characters',
			'label' => 'Limit to number of characters',
		)
	);

	public function form($options)
	{
		$options['limit'] = ( ! empty($options['limit'])) ? $options['limit'] : 5;
		$options['characters'] = ( ! empty($options['characters'])) ? $options['characters'] : 150;

		return array(
			'options' => $options
		);
	}

	public function run($options)
	{
		// load the blog module's model
		class_exists('Blog_m') OR $this->load->model('blog/blog_m');

		// sets default number of posts to be shown
		$options['limit'] = ( ! empty($options['limit'])) ? $options['limit'] : 5;
		// sets default number of charaters to be shown
		$options['characters'] = ( ! empty($options['characters'])) ? $options['characters'] : 150;

		// retrieve the records using the blog module's model
		$blog_widget = $this->blog_m
			->limit($options['limit'])
			->get_many_by(array('status' => 'live'));
			
		// If results	
		if (! empty ($blog_widget) )
		{
			// loop through the array
			foreach ($blog_widget as &$post_widget) 
			{
				// limit characters to the user's preference if we have results
				$post_widget->body = substr(strip_tags($post_widget->body), 0, $options['characters']);
			}
		}
		// returns the variables to be used within the widget's view
		return array('blog_widget' => $blog_widget);
	}
}
