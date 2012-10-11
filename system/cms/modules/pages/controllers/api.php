<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		PyroCMS\Core\Modules\Pages\Controllers
*/

class Api extends API_Controller
{
	public function index_get()
	{
		$this->load->model('page_m');
		
		if ( ! ($order_by = $this->input->get('order-by')))
		{
			$order_by = 'title';
		}
		
		if ( ! ($order_dir = $this->input->get('order-dir')))
		{
			$order_dir = 'asc';
		}
		
		$this->page_m->order_by($order_by, $order_dir);
		
		if ($this->input->get('status'))
		{
			$results = $this->page_m->get_many_by('status', $this->input->get('status'));
		}
		
		else
		{
			$results = $this->page_m->get_all();
		}
		
		$pages = array();
		$count = 0;
		
		foreach ($results as $page)
		{
			$pages[] = array(
				'id' => (int) $page->id,
				'title' => $page->title,
				'uri' => $page->uri,
				'status' => $page->status,
			);
			
			++$count;
		}
		
		$this->response(array(
			'pages' => $pages,
			'count' => $count,
		));
	}

	/**
	 * Get data for a page.
	 *
	 * @param int $id The page id.
	 */
	public function details_get($id)
	{
		$this->load->model('page_m');

		// Get the page along with its chunks.
		$page = $this->page_m->get($id);

		if ( $page and ! empty($page))
		{
			// We only require certain columns.
			$fields = array(
				'id', 'slug', 'title', 'uri', 'css', 'js', 'meta_title',
				'meta_keywords', 'meta_description', 'rss_enabled',
				'comments_enabled', 'is_home', 'status', 'chunks'
			);

			// Just so that we do not redeclare it for every loop.
			$page_keys = array_keys($page);

			foreach ($page_keys as $key)
			{
				// If the key is not something we are interested in including in our response.
				if ( ! in_array($key, $fields))
				{
					// unset it.
					unset($page[$key]);
				}
			}

			$page->meta_keywords = Keywords::get_string($page->meta_keywords);
		}
		// Sent the response out.
		$this->response(array('page' => $page));
	}
}