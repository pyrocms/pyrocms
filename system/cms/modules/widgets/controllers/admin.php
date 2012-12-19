<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin controller for the widgets module.
 * 
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Widgets\Controllers
 *
 */
class Admin extends Admin_Controller {

	/**
	 * The current active section
	 * @access protected
	 * @var string
	 */
	protected $section = 'instances';

	/**
	 * Constructor method
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->library('widgets');
		$this->lang->load('widgets');

		$this->input->is_ajax_request() AND $this->template->set_layout(false);

		if (in_array($this->method, array('index', 'manage')))
		{
			// requires to install and/or uninstall widgets
			$this->widgets->list_available_widgets();
		}

		$this->template
			->append_js('module::widgets.js')
			->append_css('module::widgets.css');
	}

	/**
	 * Index method, lists all active widgets
	 * 
	 * @return void
	 */
	public function index()
	{
		$data = array();

		// Get Widgets
		$this->db->where('enabled', 1)->order_by('order');
		$data['available_widgets'] = $this->widget_m->get_all();

		// Get Areas
		$this->db->order_by('`title`');

		$data['widget_areas'] = $this->widgets->list_areas();

		// Go through all widget areas
		$slugs = array();

		foreach ($data['widget_areas'] as $key => $area)
		{
			$slugs[$area->id] = $area->slug;

			$data['widget_areas'][$key]->widgets = array();
		}

		if ($data['widget_areas'])
		{
			$data['widget_areas'] = array_combine(array_keys($slugs), $data['widget_areas']);
		}

		$instances = $this->widgets->list_area_instances($slugs);

		foreach ($instances as $instance)
		{
			$data['widget_areas'][$instance->widget_area_id]->widgets[$instance->id] = $instance;
		}

		// Create the layout
		$this->template
			->title($this->module_details['name'])
			->build('admin/index', $data);
	}

	/**
	 * Manage method, lists all widgets to install, uninstall, etc..
	 *
	 * @access	public
	 * @return	void
	 */
	public function manage()
	{
		$data = array();

		$base_where = array('enabled' => 1);

		//capture active
		$base_where['enabled'] = is_int($this->session->flashdata('enabled')) ? $this->session->flashdata('enabled') : $base_where['enabled'];
		$base_where['enabled'] = is_numeric($this->input->post('f_enabled')) ? $this->input->post('f_enabled') : $base_where['enabled'];

		// Create pagination links
		// @todo: fixes pagination and sort compatibility
		//$total_rows = $this->widget_m->count_by($base_where);
		//$data['pagination'] = create_pagination('admin/widgets/manage', $total_rows);

		$data['widgets_active'] = $base_where['enabled'];

		$data['widgets'] = $this->widget_m
			//->limit($data['pagination']['limit'])
			->order_by('`order`')
			->get_many_by($base_where);


		// Create the layout
		$this->template
			->title($this->module_details['name'])
			->set_partial('filters', 'admin/partials/filters')
			->append_js('admin/filter.js')
			->build('admin/manage', $data);
	}

	/**
	 * Enable widget
	 *
	 * @access	public
	 * @param	string	$id			The id of the widget
	 * @param	bool	$redirect	Optional if a redirect should be done
	 * @return	void
	 */
	public function enable($id = '', $redirect = true)
	{
		$id && $this->_do_action($id, 'enable');

		if ($redirect)
		{
			$this->session->set_flashdata('enabled', 0);

			redirect('admin/widgets/manage');
		}
	}

	/**
	 * Disable widget
	 *
	 * @access	public
	 * @param	string	$id			The id of the widget
	 * @param	bool	$redirect	Optional if a redirect should be done
	 * @return	void
	 */
	public function disable($id = '', $redirect = true)
	{
		$id && $this->_do_action($id, 'disable');

		$redirect AND redirect('admin/widgets/manage');
	}

	/**
	 * Do the actual work for enable/disable
	 *
	 * @access	protected
	 * @param	int|array	$ids	Id or array of Ids to process
	 * @param	string		$action	Action to take: maps to model
	 * @return	void
	 */
	protected function _do_action($ids = array(), $action = '')
	{
		$ids		= ( ! is_array($ids)) ? array($ids) : $ids;
		$multiple	= (count($ids) > 1) ? '_mass' : null;
		$status		= 'success';

		foreach ($ids as $id)
		{
			if ( ! $this->widget_m->{$action . '_widget'}($id))
			{
				$status = 'error';
				break;
			}
			else
			{
				// Fire an Event. A widget has been enabled or disabled. 
				switch ($action)
				{
					case 'enable':		
						Events::trigger('widget_enabled', $ids);
						break;
					
					case 'disable':		
						Events::trigger('widget_disabled', $ids);
						break;
				}
			}
		}

		$this->session->set_flashdata( array($status=> lang('widgets:'.$action.'_'.$status.$multiple)));
	}

}
