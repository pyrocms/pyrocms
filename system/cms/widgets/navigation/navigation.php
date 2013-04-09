<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Show RSS feeds in your site
 *
 * @author		Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Widgets
 */
class Widget_Navigation extends Widgets
{

	/**
	 * The translations for the widget title
	 *
	 * @var array
	 */
	public $title = array(
		'en' => 'Navigation',
		'el' => 'Πλοήγηση',
		'nl' => 'Navigatie',
		'br' => 'Navegação',
		'pt' => 'Navegação',
		'ru' => 'Навигация',
		'id' => 'Navigasi',
		'fi' => 'Navigaatio',
		'fr' => 'Navigation',
            'fa' => 'منوها',
	);

	/**
	 * The translations for the widget description
	 *
	 * @var array
	 */
	public $description = array(
		'en' => 'Display a navigation group with a widget',
		'el' => 'Προβάλετε μια ομάδα στοιχείων πλοήγησης στον ιστότοπο',
		'nl' => 'Toon een navigatiegroep met een widget',
		'br' => 'Exibe um grupo de links de navegação como widget em seu site',
		'pt' => 'Exibe um grupo de links de navegação como widget no seu site',
		'ru' => 'Отображает навигационную группу внутри виджета',
		'id' => 'Menampilkan grup navigasi menggunakan widget',
		'fi' => 'Näytä widgetillä navigaatio ryhmä',
		'fr' => 'Affichez un groupe de navigation dans un widget',
            'fa' => 'نمایش گروهی از منوها با استفاده از ویجت',
	);

	/**
	 * The author of the widget
	 *
	 * @var string
	 */
	public $author = 'Phil Sturgeon';

	/**
	 * The author's website.
	 * 
	 * @var string 
	 */
	public $website = 'http://philsturgeon.co.uk/';

	/**
	 * The version of the widget
	 *
	 * @var string
	 */
	public $version = '1.2.0';

	/**
	 * The fields for customizing the options of the widget.
	 *
	 * @var array 
	 */
	public $fields = array(
		array(
			'field' => 'group',
			'label' => 'Navigation group',
			'rules' => 'required'
		)
	);
	/**	
	 * Constructor method
	 */	
	public function __construct()	
	{
		// Load the navigation model from the navigation module.	
		$this->load->model('navigation/navigation_m');
	}
	
	/**
	 * Get the navigation groups.
	 *
	 * @return array The navigation groups
	 */
	public function form()
	{
		// Loop aroung them and add them in an array keyed by their abbreviated 
		// title.
		$groups = array();
		$_groups = $this->navigation_m->get_groups();
		foreach ($_groups as $group)
		{
			$groups[$group->abbrev] = $group->title;
		}

		// Beam them up Scottie
		return array(
			'groups' => $groups
		);
	}

	/**
	 * The main function of the widget.
	 *
	 * @param array $options The options for displaying a Navigation menu.
	 * @return array 
	 */
	public function run($options)
	{
		// We must pass the user group from here so that we can cache the results and still always return the links with the proper permissions
		$params = array(
			$options['group'],
			array(
				'user_group' => ($this->current_user AND isset($this->current_user->group)) ? $this->current_user->group : false,
				'front_end' => true,
				'is_secure' => IS_SECURE,
			)
		);

		// Load the navigation model from the navigation module.
		$this->load->model('navigation/navigation_m');
		
		$links = $this->pyrocache->model('navigation_m', 'get_link_tree', $params, config_item('navigation_cache'));

		// Shorter alias
		$widget = & $options['widget'];

		// The title of the navigation menu
		$title = isset($widget['title_tag']) ? '<'.$widget['title_tag'].'>'.$widget['instance_title'].'</'.$widget['title_tag'].'>' : '';

		// What do we use 'ul' or 'ol'
		$list_tag = isset($widget['list_tag']) ? $widget['list_tag'] : 'ul';

		// Give it another CSS class maybe?
		$list_class = isset($widget['list_class']) ? $widget['list_class'] : 'navigation';
		$list_class = $list_class ? ' class="'.$list_class.'"' : '';

		// Specify an 'id' for it?
		$list_id = isset($widget['list_id']) ? $widget['list_id'] : '';
		$list_id = $list_id ? ' id="'.$list_id.'"' : '';

		return array(
			'links' => $links,
			'title' => $title,
			'list_open_tag' => '<'.$list_tag.$list_id.$list_class.'>',
			'list_close_tag' => '</'.$list_tag.'>',
			'group' => $options['group']
		);
	}

}