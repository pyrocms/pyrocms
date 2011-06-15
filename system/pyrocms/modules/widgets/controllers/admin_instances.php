<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin controller for the widgets module.
 *
 * @package 		PyroCMS
 * @subpackage 		Widgets
 * @author			Marcos Coelho - PyroCMS Development Team
 *
 */
class Admin_instances extends Admin_Controller {

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
	 * @access	public
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->library('widgets');
		$this->lang->load('widgets');

		$this->input->is_ajax_request() AND $this->template->set_layout(FALSE);

		$this->template
			->set_partial('shortcuts', 'admin/partials/shortcuts')
			->append_metadata(js('widgets.js', 'widgets'))
			->append_metadata(css('widgets.css', 'widgets'));
	}

	/**
	 * List all available widgets
	 * @access public
	 * @param str $slug The slug of the widget
	 * @return void
	 */
	public function index()
	{
		$widgets = $this->widgets->list_area_instances($slug);

		$this->load->view('admin/ajax/instance_list', array('widgets' => $widgets));
	}

	/**
	 * Create the form for a new widget instance
	 * @access public
	 * @return void
	 */
	/**
	 * Add a new widget instance
	 * @access public
	 * @return void
	 */
	public function create($slug = '')
	{
		if ( ! ($slug && $widget = $this->widgets->get_widget($slug)))
		{
			// @todo: set error
			return FALSE;
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
				$message = $this->load->view('admin/partials/notices', $data, TRUE);

				return $this->template->build_json(array(
					'status'	=> $status,
					'message'	=> $message,
					'active'	=> (isset($area) && $area ? '#area-' . $area->slug . ' header' : FALSE)
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
	 * @access public
	 * @return void
	 */
	/**
	 * Edit a widget instance
	 * @access public
	 * @return void
	 */
	public function edit($id = 0)
	{
		if ( ! ($id && $widget = $this->widgets->get_instance($id)))
		{
			// @todo: set error
			return FALSE;
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
				$message = $this->load->view('admin/partials/notices', $data, TRUE);

				return $this->template->build_json(array(
					'status'	=> $status,
					'message'	=> $message,
					'active'	=> (isset($area) && $area ? '#area-' . $area->slug . ' header' : FALSE)
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
	 * @access public
	 * @return void
	 */
	public function delete($id = 0)
	{
		if ($this->widgets->delete_instance($id))
		{
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
			$message = $this->load->view('admin/partials/notices', $data, TRUE);

			return $this->template->build_json(array(
				'status'	=> $status,
				'message'	=> $message
			));
		}

		$this->session->set_flashdata($status, $message);
		redirect('admin/widgets');
	}

}