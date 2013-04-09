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
            'fa' => 'جستجو',
	);

	public $description = array(
		'en' => 'Create a search form and display search results.',
            'fa' => 'ایجاد فرم جستجو و نمایش نتایج',
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
			'form' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Displays the search form. Extra attributes will be used as form attributes. Example: class="search-form".'
				),
				'single' => false,// will it work as a single tag?
				'double' => true,// how about as a double tag?
				'variables' => '',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(
					'action' => array(// this is the order-dir="asc" attribute
						'type' => 'text',// Can be: slug, number, flag, text, array, any.
						'flags' => '',// flags are predefined values like this.
						'default' => 'search/results',// attribute defaults to this if no value is given
						'required' => false,// is this attribute required?
					),
				),
			),// end form method
			'results' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Display search results.'
				),
				'single' => false,// will it work as a single tag?
				'double' => true,// how about as a double tag?
				'variables' => 'total|query|entries }}{{ /entries|pagination',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(
					'limit' => array(// this is the order-dir="asc" attribute
						'type' => 'number',// Can be: slug, number, flag, text, array, any.
						'flags' => '',// flags are predefined values like this.
						'default' => '10',// attribute defaults to this if no value is given
						'required' => false,// is this attribute required?
					),
					'uri' => array(// this is the order-dir="asc" attribute
						'type' => 'text',// Can be: slug, number, flag, text, array, any.
						'flags' => '',// flags are predefined values like this.
						'default' => 'search/results',// attribute defaults to this if no value is given
						'required' => false,// is this attribute required?
					),
					'page_segment' => array(// this is the order-dir="asc" attribute
						'type' => 'text',// Can be: slug, number, flag, text, array, any.
						'flags' => '',// flags are predefined values like this.
						'default' => '',// attribute defaults to this if no value is given
						'required' => false,// is this attribute required?
					),
				),
			),// end results method
		);
	
		return $info;
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

		return form_open($action, $attributes).PHP_EOL
			 . $this->content().PHP_EOL
			 . form_close();
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
		$segment = $this->attribute('page_segment', count(explode('/', $uri)) + 1);

		// If it's POST, send it off to return as a GET
		if ($this->input->post('q'))
		{
			redirect($uri.'?q='.$this->input->post('q'));
		}

		$query  = $this->input->get('q');
		$filter = $this->input->get('filter');

		$total = $this->search_index_m
			->filter($filter)
			->count($query);

		$pagination = create_pagination($uri, $total, $limit, $segment);
		
		$results = $this->search_index_m
			->limit($pagination['limit'], $pagination['offset'])
			->filter($filter)
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