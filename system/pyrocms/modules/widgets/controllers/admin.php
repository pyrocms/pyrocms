<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin controller for the widgets module.
 *
 * @package 		PyroCMS
 * @subpackage 		Widgets
 * @author			Phil Sturgeon - PyroCMS Development Team
 *
 */
class Admin extends Admin_Controller {

	/**
	 * Constructor method
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->library('widgets');
		$this->lang->load('widgets');

		$this->template
			->set_partial('shortcuts', 'admin/partials/shortcuts')
			->append_metadata(js('widgets.js', 'widgets'))
			->append_metadata(css('widgets.css', 'widgets'));
	}

	/**
	 * Index method, lists all active widgets
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$data = array();

		$data['available_widgets']	= $this->widgets->list_available_widgets();
		$data['widget_areas']		= $this->widgets->list_areas();

		// Go through all widget areas
		foreach ($data['widget_areas'] as &$area)
		{
			$area->widgets = $this->widgets->list_area_instances($area->slug);
		}

		// Create the layout
		$this->template
			->title($this->module_details['name'])
			->build('admin/index', $data);
	}

	/**
	 * Show info about available widgets
	 * @access public
	 * @param str $slug The slug of the widget
	 * @return void
	 */
	public function about_available($slug)
	{
		$widget = $this->widgets->get_widget($slug);

		$this->load->view('admin/about_widget', array(
			'widget'		=> $widget,
			'available'		=> TRUE,
			'form_action'	=> 'admin/widgets/uninstall'
		));
	}

	/**
	 * Show info about uninstalled widgets
	 * @access public
	 * @param str $slug The slug of the widget
	 * @return void
	 */
	public function about_uninstalled($slug)
	{
		$widget = $this->widgets->read_widget($slug);

		$this->load->view('admin/about_widget', array(
			'widget'		=> $widget,
			'available'		=> FALSE,
			'form_action'	=> 'admin/widgets/install'
		));
	}

}
