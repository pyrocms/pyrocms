<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Search Plugin
 *
 * Use the search plugin to display search forms and content
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Search\Plugins
 */
class Plugin_Search extends Plugin
{

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
		$action = $this->attribute('action', 'search/results');
		$class = $this->attribute('class', 'search');

		$output	 = form_open($action, 'class="'.$class.'"').PHP_EOL;
		$output .= $this->content();
		$output .= form_close();

		return $output;
	}

	/**
	 * Lists the posts in a specific category.
	 *
	 * @param string $slug The slug of the category.
	 */
	public function results($slug = '')
	{
		$this->load->model('search_index_m');

		$limit = $this->attribute('limit', 5);
		$uri = $this->attribute('uri', 'search/results');
		$segment = $this->attribute('pag_segment', count(explode('/', $uri)) + 1);

		// If it's POST, send it off to return as a GET
		if ($this->input->post('q'))
		{
			redirect($uri.'?q='.$this->input->post('q'));
		}

		$query = $this->input->get('q');
		$filter = $this->input->get('filter');

		$total = $this->search_index_m
			->filter($filter)
			->count($query, $filter);

		$pagination = create_pagination($uri, $total, $limit, $segment);
		
		$results = $this->search_index_m
			->limit($pagination['limit'])
			->filter($this->input->get('filter'))
			->search($query);

		// Remember which modules have been loaded
		static $modules = array();

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