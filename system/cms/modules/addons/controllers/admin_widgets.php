<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Admin controller for the widgets module.
 *
 * @package   PyroCMS\Core\Modules\Addons\Controllers
 * @author    PyroCMS Dev Team
 * @copyright Copyright (c) 2012, PyroCMS LLC
 */
class Admin_Widgets extends Admin_Controller
{
	/**
	 * The current active section
	 *
	 * @var string
	 */
	protected $section = 'widgets';

	/**
	 * Every time this controller is called it should:
	 * - load the widgets library
	 * - load the widgets and addons language files
	 * - remove the view layout if the request is an AJAX request
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->library('widgets');
		$this->lang->load('addons');
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
	 * Index method, lists both enabled and disabled widgets
	 */
	public function index()
	{
		$data = array();

		$base_where = array('enabled' => 1);

		//capture active
		$base_where['enabled'] = is_int($this->session->flashdata('enabled')) ? $this->session->flashdata('enabled') : $base_where['enabled'];
		$base_where['enabled'] = is_numeric($this->input->post('f_enabled')) ? $this->input->post('f_enabled') : $base_where['enabled'];

		$data['widgets_active'] = $base_where['enabled'];

		$data['widgets'] = $this->widget_m
			->order_by('`order`, enabled')->get_all();

		// Create the layout
		$this->template
			->title($this->module_details['name'])
			->build('admin/widgets/index', $data);
	}

	/**
	 * Enable widget
	 *
	 * @param string $id       The id of the widget
	 * @param bool   $redirect Optional if a redirect should be done
	 */
	public function enable($id = '', $redirect = true)
	{
		$id && $this->_do_action($id, 'enable');

		if ($redirect)
		{
			$this->session->set_flashdata('enabled', 0);

			redirect('admin/addons/widgets');
		}
	}

	/**
	 * Disable widget
	 *
	 * @param string $id       The id of the widget
	 * @param bool   $redirect Optional if a redirect should be done
	 */
	public function disable($id = '', $redirect = true)
	{
		$id && $this->_do_action($id, 'disable');
		// todo: Shouldn't there be a: $this->session->flashdata('disabled',0); as in the enable() above?
		$redirect AND redirect('admin/addons/widgets');
	}

	/**
	 * Do the actual work for enable/disable
	 *
	 * @param int|array $ids    Id or array of Ids to process
	 * @param string    $action Action to take: maps to model
	 */
	protected function _do_action($ids = array(), $action = '')
	{
		$ids = ( ! is_array($ids)) ? array($ids) : $ids;
		$multiple = (count($ids) > 1) ? '_mass' : null;
		$status = 'success';

		foreach ($ids as $id)
		{
			if ( ! $this->widget_m->{$action.'_widget'}($id))
			{
				$status = 'error';
				break;
			}

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

		$this->session->set_flashdata(array($status => lang('widgets:'.$action.'_'.$status.$multiple)));
	}

}
