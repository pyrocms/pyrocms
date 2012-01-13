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
	
	public function details_get($id)
	{
		$this->load->model('page_m');
		
		$page = $this->page_m->get($id);
		
		// Grab all the chunks that make up the body
		$page->chunks = $this->db
			->order_by('sort')
			->get_where('page_chunks', array('page_id' => $page->id))
			->result();
		
		$this->response(array(
			'page' => array(
				'id'               => (int) $page->id,
				'slug'             => $page->slug,
				'title'            => $page->title,
				'uri'              => $page->uri,
				'css'              => $page->css,
				'js'               => $page->js,
				'meta_title'       => $page->meta_title,
				'meta_keywords'    => $page->meta_keywords,
				'meta_description' => $page->meta_description,
				'rss_enabled'      => (bool) $page->rss_enabled,
				'comments_enabled' => (bool) $page->comments_enabled,
				'is_home'          => (bool) $page->is_home,
				'status'           => $page->status,
				'chunks'           => $page->chunks,
			),
		));
	}
}