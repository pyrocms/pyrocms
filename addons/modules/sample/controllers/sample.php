<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a sample module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	Sample Module
 */
class Sample extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->model('sample_m');
		$this->lang->load('sample');
		
		$this->template->append_metadata(css('sample.css', 'sample'))
						->append_metadata(js('sample.js', 'sample'));
	}

	/**
	 * All items
	 */
	public function index($offset = '')
	{
		$this->data->items	= $this->sample_m->get_items($limit = 10, $offset);			

		$this->data->pagination = create_pagination('sample', count($this->sample_m->get_items()), $limit);

		$this->template->title($this->module_details['name'], 'the rest of the page title')
						->build('index', $this->data);
	}
}