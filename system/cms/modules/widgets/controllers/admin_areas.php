<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin controller for adding and managing widget areas.
 *
 * @author		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Widgets\Controllers
 *
 */
class Admin_areas extends Admin_Controller {

	/**
	 * The current active section
	 * @access protected
	 * @var string
	 */
	protected $section = 'areas';
	
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
	 *
	 * @access    public
	 * @return \Admin_areas
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->library('widgets');
		$this->lang->load('widgets');

		$this->input->is_ajax_request() AND $this->template->set_layout(false);

		$this->template
			->append_js('module::widgets.js')
			->append_css('module::widgets.css');
	}

	public function index()
	{
		$data = array();

		$this->db->order_by('`title`');

		$data['widget_areas'] = $this->widgets->list_areas();

		// Go through all widget areas
		foreach ($data['widget_areas'] as &$area)
		{
			$area->widgets = $this->widgets->list_area_instances($area->slug);
		}

		// Create the layout
		return $this->template
			->title($this->module_details['name'])
			->build('admin/areas/index', $data, $this->method !== 'index');
	}

	/**
	 * Add a new widget area
	 * 
	 * @return void
	 */
	public function create()
	{
		$data = array();

		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->_validation_rules);

		if ($this->form_validation->run())
		{
			$input = array(
				'title'	=> $this->input->post('title'),
				'slug'	=> $this->input->post('slug')
			);

			if ($id = $this->widgets->add_area($input))
			{
				// Fire an event. A widget area has been created. 
				Events::trigger('widget_area_created');
								
				$area		= $this->widgets->get_area($id);
				$status		= 'success';
				$message	= lang('success_label');
			}
			else
			{
				$status		= 'error';
				$message	= lang('error_label');
			}

			if ($this->input->is_ajax_request())
			{
				$data = array();

				$data['messages'][$status] = $message;
				$message = $this->load->view('admin/partials/notices', $data, true);

				return $this->template->build_json(array(
					'status'	=> $status,
					'message'	=> $message,
					'html'		=> ($status === 'success' ? $this->index() : null),
					'active'	=> (isset($area) && $area ? '#area-' . $area->slug . ' header' : false)
				));
			}

			if ($status === 'success')
			{
				$this->session->set_flashdata($status, $message);

				redirect('admin/widgets/areas');
			}

			$data['messages'][$status] = $message;
		}
		elseif (validation_errors())
		{
			if ($this->input->is_ajax_request())
			{
				$status		= 'error';
				$message	= $this->load->view('admin/partials/notices', array(), true);

				return $this->template->build_json(array(
					'status'	=> $status,
					'message'	=> $message
				));
			}
		}

		$area = new stdClass();

		foreach ($this->_validation_rules as $rule)
		{
			$area->{$rule['field']} = set_value($rule['field']);
		}

		$data['area'] = $area;

		$this->template->build('admin/areas/form', $data);
	}

	/**
	 * Edit widget area
	 * 
	 * @return void
	 */
	public function edit($id = 0)
	{
		if ( ! ($id && $area = $this->widgets->get_area($id)))
		{
			// @todo: set error
			return false;
		}

		$data = array();

		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->_validation_rules);

		if ($this->form_validation->run())
		{
			$input = array(
				'id'	=> $area->id,
				'title'	=> $this->input->post('title'),
				'slug'	=> $this->input->post('slug')
			);

			if ($this->widgets->edit_area($input))
			{
				// Fire an event. A widget area has been updated. 
				Events::trigger('widget_area_updated', $id);
				
				$area = $this->widgets->get_area($id);
				$status		= 'success';
				$message	= lang('success_label');
			}
			else
			{
				$status		= 'error';
				$message	= lang('general_error_label');
			}

			if ($this->input->is_ajax_request())
			{
				$data = array();

				$data['messages'][$status] = $message;
				$message = $this->load->view('admin/partials/notices', $data, true);

				return $this->template->build_json(array(
					'status'	=> $status,
					'message'	=> $message,
					'html'		=> ($status === 'success' ? $this->index() : null),
					'active'	=> (isset($area) && $area ? '#area-' . $area->slug . ' header' : false)
				));
			}

			if ($status === 'success')
			{
				$this->session->set_flashdata($status, $message);

				redirect('admim/widgets/areas');
			}

			$data['messages'][$status] = $message;
		}
		elseif (validation_errors())
		{
			if ($this->input->is_ajax_request())
			{
				$status		= 'error';
				$message	= $this->load->view('admin/partials/notices', array(), true);

				return $this->template->build_json(array(
					'status'	=> $status,
					'message'	=> $message
				));
			}
		}

		foreach ($this->_validation_rules as $rule)
		{
			$area->{$rule['field']} = set_value($rule['field'], $area->{$rule['field']});
		}

		$data['area'] = $area;

		$this->template->build('admin/areas/form', $data);
	}

	/**
	 * Delete an existing widget area
	 * 
	 * @return void
	 */
	public function delete($id = 0)
	{
		if ($this->widgets->delete_area($id))
		{
			// Fire an event. A widget area has been deleted. 
			Events::trigger('widget_area_deleted', $id);
				
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
