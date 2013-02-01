<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Search Plugin
 *
 * Use the search plugin to display search forms and content
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Search\Plugins
 */
class Plugin_Search extends Plugin
{

	public $version = '1.0.0';
	public $name = array(
		'en' => 'Search',
	);
	public $description = array(
		'en' => 'Create a search form and display search results.',
	);

	/**
	 * Returns a PluginDoc array that PyroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * All options are listed here but refer 
	 * to the Blog plugin for a larger example
	 *
	 * @todo fill the  array with details about this plugin, then uncomment the return value.
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'your_method' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Displays some data from some module.'
				),
				'single' => true,// will it work as a single tag?
				'double' => false,// how about as a double tag?
				'variables' => '',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(
					'order-dir' => array(// this is the order-dir="asc" attribute
						'type' => 'flag',// Can be: slug, number, flag, text, array, any.
						'flags' => 'asc|desc|random',// flags are predefined values like this.
						'default' => 'asc',// attribute defaults to this if no value is given
						'required' => false,// is this attribute required?
					),
					'limit' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '20',
						'required' => false,
					),
				),
			),// end first method
		);
	
		//return $info;
		return array();
	}

	/**
	 * Get the URL of a page
	 *
	 * Attributes:
	 *  - (int) id : The id of the page to get the URL for.
	 *
	 * @return string
	 */
	public function form()
	{
		$attributes = $this->attributes();
		
		// This needs to be by itself
		unset($attributes['action']);

		// Now, did they set a custom action?
		$action = $this->attribute('action', 'search/results');

		$output	 = form_open($action, $attributes).PHP_EOL;
		$output .= $this->content();
		$output .= form_close();

		return $output;
	}

	/**
	 * Lists the posts in a specific category.
	 *
	 * @param string $slug The slug of the category.
	 * @return array
	 */
	public function results($slug = '')
	{
		$this->load->model('search_index_m');

		$limit   = $this->attribute('limit', 10);
		$uri     = $this->attribute('uri', 'search/results');
		$segment = $this->attribute('pag_segment', count(explode('/', $uri)) + 1);

		// If it's POST, send it off to return as a GET
		if ($this->input->post('q'))
		{
			redirect($uri.'?q='.$this->input->post('q'));
		}

		$query  = $this->input->get('q');
		$filter = $this->input->get('filter');

		$total = $this->search_index_m
			->filter($filter)
			->count($query, $filter);

		$pagination = create_pagination($uri, $total, $limit, $segment);
		
		$results = $this->search_index_m
			->limit($pagination['limit'], $pagination['offset'])
			->filter($this->input->get('filter'))
			->search($query);

		// Remember which modules have been loaded
		static $modules = array();

		$count = 1;

		// Loop through found results to find extra information
		foreach ($results as &$row)
		{
			// We only want to load a lang file once
			if ( ! isset($modules[$row->module]))
			{
				if ($this->module_m->exists($row->module))
				{
					$this->lang->load("{$row->module}/{$row->module}");

					$modules[$row->module] = true;
				}
				// If module doesn't exist (for whatever reason) then sssh!
				else
				{
					$modules[$row->module] = false;
				}
			}

			$row->singular = lang($row->entry_key) ? lang($row->entry_key) : $row->entry_key;
			$row->plural = lang($row->entry_plural) ? lang($row->entry_plural) : $row->entry_plural;

			$row->url = site_url($row->uri);

			// Increment our count.
			$row->count = $count;
			$count++;
		}

		return array(
			array(
				'total' => (int) $total,
				'query' => $query,
				'entries' => $results,
				'pagination' => $pagination['links'],
			)
		);
    }

}