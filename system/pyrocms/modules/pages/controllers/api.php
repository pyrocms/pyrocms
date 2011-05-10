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
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

class Api extends REST_Controller
{
	function pages_get()
	{
		$this->load->model('pages_m');
		$results = $this->pages_m->get_all();
		$this->response($results, 200); // 200 being the HTTP response code
	}
}