<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a sample module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	Sample Module
 */
class Admin extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();

		// Load all the required classes
		$this->load->model('sample_m');
		$this->load->library('form_validation');
		$this->lang->load('sample');

		// Set the validation rules
		$this->item_validation_rules = array(
			array(
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'trim|max_length[255]|required'
			),
			array(
				'field' => 'slug',
				'label' => 'Slug',
				'rules' => 'trim|max_length[255]|required'
			)
		);

		$this->template->set_partial('shortcuts', 'admin/partials/shortcuts')
						->append_metadata(js('admin.js', 'sample'))
						->append_metadata(css('admin.css', 'sample'));
	}

	/**
	 * List all items
	 */
	public function index()
	{
		$items = $this->sample_m->get_items();

		// Load the view
		$this->data->items =& $items;
		$this->template->title($this->module_details['name'])
						->build('admin/items', $this->data);
	}

	public function create_item()
	{
		// Set the validation rules
		$this->form_validation->set_rules($this->item_validation_rules);

		if($this->form_validation->run())
		{
			// Create the item
			if($this->sample_m->create_item($_POST))
			{
				// All good...
				$this->session->set_flashdata('success', lang('sample.success'));
				redirect('admin/sample');
			}
			// Something went wrong..
			else
			{
				$this->session->set_flashdata('error', lang('sample.error'));
				redirect('admin/sample/create_item');
			}
		}

		// Load the view
		$this->template->title($this->module_details['name'], lang('sample.new_item'))
						->build('admin/create_item', $this->data);
	}
}
