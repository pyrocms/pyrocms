<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin controller for the widgets module.
 *
 * @package 		PyroCMS
 * @subpackage 		Widgets
 * @author			Marcos Coelho - PyroCMS Development Team
 *
 */
class Admin_areas extends Admin_Controller {

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

	public function index()
	{
		//
	}

	/**
	 * Add a new widget area
	 * @access public
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

			if ($this->widgets->add_area($input))
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
			$area->{$rule['field']} = set_value($rule['field']);
		}

		$data['area'] = $area;

		$this->template->build('admin/areas/form', $data);
	}

	/**
	 * Edit widget area
	 * @access public
	 * @return void
	 */
	public function edit($id = 0)
	{
		if ( ! ($id && $area = $this->widgets->get_area($id)))
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

			if ($this->widgets->edit_area($input))
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
			$area->{$rule['field']} = set_value($rule['field'], $area->{$rule['field']});
		}

		$data['area'] = $area;

		$this->template->build('admin/areas/form', $data);
	}

	/**
	 * Delete an existing widget area
	 * @access public
	 * @return void
	 */
	public function delete($id = 0)
	{
		$slug = $this->input->post('area_slug');

		$this->widgets->delete_area($slug);
	}

}