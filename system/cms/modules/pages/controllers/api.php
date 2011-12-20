<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
*/

class Api extends REST_Controller
{
	public function index_get()
	{
		$this->load->model('page_m');
		
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
}