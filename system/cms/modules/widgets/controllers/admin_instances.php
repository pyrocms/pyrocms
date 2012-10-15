<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin controller for widgets instances.
 *
 * @author		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Widgets\Controllers
 *
 */
class Admin_instances extends Admin_Controller {

	/**
	 * The current active section
	 * @access protected
	 * @var string
	 */
	protected $section = 'instances';
	
	/**
	 * Array that contains the validation rules
	 *
	 * @access	protected
	 * @var		array
	 */
	protected $_validation_rules = array(
		array(
			'field' => 'title',
			'label' => 'lang:widgets.widget_area_title',
			'rules' => 'trim|required|max_length[100]'
		),
		array(
			'field' => 'slug',
			'label' => 'lang:widgets.widget_area_slug',
			'rules' => 'trim|required|alpha_dash|max_length[100]'
		)
	);

	/**
	 * Constructor method
	 * @access    public
	 * @return \Admin_instances
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->library('widgets');
		$this->lang->load('widgets');

		$this->input->is_ajax_request() AND $this->template->set_layout(false);

		$this->template
			->set_partial('shortcuts', 'admin/partials/shortcuts')
			->append_js('module::widgets.js')
			->append_css('module::widgets.css');
	}

	/**
	 * List all available widgets
	 * 
	 * @param str $slug The slug of the widget
	 * @return void
	 */
	public function index($slug = '')
	{
		$widgets = $this->widgets->list_area_instances($slug);

		$this->load->view('admin/ajax/instance_list', array('widgets' => $widgets));
	}

	/**
	 * Create the form for a new widget instance
	 * 
	 * @return void
	 */
	public function create($slug = '')
	{
		if ( ! ($slug && $widget = $this->widgets->get_widget($slug)))
		{
			// @todo: set error
			return false;
		}

		$data = array();

		if ($input = $this->input->post())
		{
			$title 			= $input['title'];
			$widget_id 		= $input['widget_id'];
			$widget_area_id = $input['widget_area_id'];

			unset($input['title'], $input['widget_id'], $input['widget_area_id']);

			$result = $this->widgets->add_instance($title, $widget_id, $widget_area_id, $input);

			if ($result['status'] === 'success')
			{
				// Fire an event. A widget instance has been created. pass the widget id 
				Events::trigger('widget_instance_created', $widget_id);
				
				$status		= 'success';
				$message	= lang('success_label');

				$area = $this->widgets->get_area($widget_area_id);
			}
			else
			{
				$status		= 'error';
				$message	= $result['error'];
			}

			if ($this->input->is_ajax_request())
			{
				$data = array();

				$status === 'success' AND $data['messages'][$status] = $message;
				$message = $this->load->view('admin/partials/notices', $data, true);

				return $this->template->build_json(array(
					'status'	=> $status,
					'message'	=> $message,
					'active'	=> (isset($area) && $area ? '#area-' . $area->slug . ' header' : false)
				));
			}

			if ($status === 'success')
			{
				$this->session->set_flashdata($status, $message);
				redirect('admins/widgets');
				return;
			}

			$data['messages'][$status] = $message;
		}

		$data['widget']	= $widget;
		$data['form']	= $this->widgets->render_backend($widget->slug, isset($widget->options) ? $widget->options : array());

		$this->template->build('admin/instances/form', $data);
	}

	/**
	 * Create the form for editing a widget instance
	 * 
	 * @return void
	 */
	public function edit($id = 0)
	{
		if ( ! ($id && $widget = $this->widgets->get_instance($id)))
		{
			// @todo: set error
			return false;
		}

		$data = array();

		if ($input = $this->input->post())
		{
			$title			= $input['title'];
			$widget_id		= $input['widget_id'];
			$widget_area_id	= $input['widget_area_id'];
			$instance_id	= $input['widget_instance_id'];

			unset($input['title'], $input['widget_id'], $input['widget_area_id'], $input['widget_instance_id']);

			$result = $this->widgets->edit_instance($instance_id, $title, $widget_area_id, $input);

			if ($result['status'] === 'success')
			{
				// Fire an event. A widget instance has been updated pass the widget instance id.
				Events::trigger('widget_instance_updated', $instance_id);
				
				$status		= 'success';
				$message	= lang('success_label');

				$area = $this->widgets->get_area($widget_area_id);
			}
			else
			{
				$status		= 'error';
				$message	= $result['error'];
			}

			if ($this->input->is_ajax_request())
			{
				$data = array();

				$status === 'success' AND $data['messages'][$status] = $message;
				$message = $this->load->view('admin/partials/notices', $data, true);

				return $this->template->build_json(array(
					'status'	=> $status,
					'message'	=> $message,
					'active'	=> (isset($area) && $area ? '#area-' . $area->slug . ' header' : false)
				));
			}

			if ($status === 'success')
			{
				$this->session->set_flashdata($status, $message);
				redirect('admins/widgets');
				return;
			}

			$data['messages'][$status] = $message;
		}

		$this->db->order_by('`title`');

		$data['widget_areas'] = $this->widgets->list_areas();
		$data['widget_areas'] = array_for_select($data['widget_areas'], 'id', 'title');

		$data['widget']	= $widget;
		$data['form']	= $this->widgets->render_backend($widget->slug, isset($widget->options) ? $widget->options : array());

		$this->template->build('admin/instances/form', $data);
	}

	/**
	 * Delete a widget instance
	 * 
	 * @return void
	 */
	public function delete($id = 0)
	{
		if ($this->widgets->delete_instance($id))
		{
			// Fire an event. A widget instance has been deleted. 
			Events::trigger('widget_instance_deleted', $id);
				
			$status = 'success';
			$message = lang('success_label');
		}
		else
		{
			$status = 'error';
			$message = lang('general_error_label');
		}

		if ($this->input->is_ajax_request())
		{
			$data = array();

			$data['messages'][$status] = $message;
			$message = $this->load->view('admin/partials/notices', $data, true);

			return $this->template->build_json(array(
				'status'	=> $status,
				'message'	=> $message
			));
		}

		$this->session->set_flashdata($status, $message);
		redirect('admin/widgets');
	}

}