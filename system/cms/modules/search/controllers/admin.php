<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin controller for the search module
 *
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Search\Controllers
 */
class Admin extends Admin_Controller
{
	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->model('search_index_m');
	}

	/**
	 * List all redirects
	 */
	public function ajax_autocomplete()
	{
		$query = $this->input->get('term');

		$results = $this->search_index_m
			->limit(8)
			->search($query);

		// Remember which modules have been loaded
		static $modules = array();

		$output = array();

		// Loop through found results to find extra information
		foreach ($results as $row)
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

			$output[] = array(
				'title' => $row->title,
				'keywords' => (string) $row->keywords,
				'url' => site_url($row->cp_edit_uri),
				'singular' => lang($row->entry_key) ? lang($row->entry_key) : $row->entry_key,
			);
		}

		header('Content-Type: application/json');
		exit(json_encode(array('results' => $output)));
    }
}