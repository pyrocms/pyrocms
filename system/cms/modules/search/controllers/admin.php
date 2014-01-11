<?php

use Pyro\Module\Search\Model\Search;

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
	}

	/**
	 * List all redirects
	 */
	public function results()
	{
		$terms = $this->input->post('terms');
		$terms = explode('|', $terms);
		$results = Search::getResults($terms);

		// Remember which modules have been loaded
		static $modules = array();

		// Loop through found results to find extra information
		foreach ($results as &$row) {

			// We only want to load a lang file once
			if ( ! isset($modules[$row->module])) {
				if ($this->moduleManager->moduleExists($row->module)) {
					$this->lang->load("{$row->module}/{$row->module}");

					$modules[$row->module] = true;
				}
				// If module doesn't exist (for whatever reason) then sssh!
				else {
					$modules[$row->module] = false;
				}
			}

			$row->keywords = explode(',', $row->keywords);
			$row->singular = lang($row->singular) ? lang($row->singular) : $row->singular;
			$row->plural = lang($row->plural) ? lang($row->plural) : $row->plural;
		}

		header('Content-Type: application/json');
		exit(json_encode(array('results' => $results->toArray())));
    }
}
