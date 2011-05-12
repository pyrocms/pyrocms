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

		$this->is_ajax() AND $this->template->set_layout(FALSE);

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
			}
			else
			{
				$status		= 'error';
				$message	= $result['error'];
			}

			if ($this->is_ajax())
			{
				$data = array();

				$status === 'success' AND $data['messages'][$status] = $message;
				$message = $this->load->view('admin/partials/notices', $data, TRUE);

				return print( json_encode((object) array(
					'status'	=> $status,
					'message'	=> $message
				)) );
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
		if ( ! ($id && $instance = $this->widgets->get_instance($id)))
		{
			// todo: set errors
			return FALSE;
		}

		$data = array();

		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->_validation_rules);

		if ($this->form_validation->run())
		{
			$input = array(
				'title'	=> $this->input->post('title'),
				'slug'	=> $this->input->post('slug')
			);

			if ($this->widgets->edit_instance($input))
			{
				$status		= 'success';
				$message	= lang('success_label');
			}
			else
			{
				$status		= 'error';
				$message	= lang('error_label');
			}

			if ($this->is_ajax())
			{
				$data = array();

				$data['messages'][$status] = $message;
				$message = $this->load->view('admin/partials/notices', $data, TRUE);

				return print( json_encode((object) array(
					'status'	=> $status,
					'message'	=> $message
				)) );
			}

			if ($status === 'success')
			{
				$this->session->set_flashdata($status, $message);

				redirect('admim/widgets');
				return;
			}

			$data['messages'][$status] = $message;
		}
		elseif (validation_errors())
		{
			if ($this->is_ajax())
			{
				$status		= 'error';
				$message	= $this->load->view('admin/partials/notices', array(), TRUE);

				return print( json_encode((object) array(
					'status'	=> $status,
					'message'	=> $message
				)) );
			}
		}

		foreach ($this->_validation_rules as $rule)
		{
			$instance->{$rule['field']} = set_value($rule['field'], $instance->{$rule['field']});
		}

		$data['area'] = $instance;

		$this->template->build('admin/areas/form', $data);
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

		if ($this->is_ajax())
		{
			$data = array();

			$data['messages'][$status] = $message;
			$message = $this->load->view('admin/partials/notices', $data, TRUE);

			return print( json_encode((object) array(
				'status'	=> $status,
				'message'	=> $message
			)) );
		}

		$this->session->set_flashdata($status, $message);
		redirect('admin/widgets');
	}

}