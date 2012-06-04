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

		$uri = $this->attribute('uri', 'search/results');
		$segment = $this->attribute('pag_segment', count(explode('/', $uri)));

		// If it's POST, send it off to return as a GET
		if ($this->input->post('q'))
		{
			redirect($uri.'?q='.$this->input->post('q'));
		}

		$query = $this->input->get('q');
		$total = $this->search_index_m->count($query);

		$pagination = create_pagination($uri, $total, NULL, $segment);
		
		$results = $this->search_index_m
			->limit($pagination['limit'])
			->search($query);

		return array(
			array(
				'total' => $total,
				'entries' => $results,
				'pagination' => $pagination['links'],
			)
		);
    }

}