<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin controller for the settings module
 *
 * @author 		Phil Sturgeon - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Settings module
 * @category	Modules
 */
class Admin extends Admin_Controller
{
	/**
	 * Validation array
	 * @access private
	 * @var array
	 */
	private $validation_rules = array();

	/**
	 * Constructor method
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		// Call the parent's constructor method
		parent::Admin_Controller();
		$this->load->model('settings_m');
		$this->load->library('settings');
		$this->load->library('form_validation');
		$this->lang->load('settings');
	}

	/**
	 * Index method, lists all generic settings
	 *
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$this->data->settings 	= array();
		if($settings = $this->settings_m->get_settings( array('is_gui' => 1 )) )
		{
			// Loop through each setting
			foreach($settings as $setting)
			{
				$setting->form_control 							= $this->settings->form_control($setting);
				if($setting->module == '') $setting->module 	= 'general';
				$this->data->settings[$setting->module][] 		= $setting;
				$this->data->setting_sections[$setting->module] = ucfirst($setting->module);
			}
		}

		// Render the layout
		$this->template
			->title($this->module_details['name'])
			->build('admin/index', $this->data);
	}

	/**
	 * Edit an existing settings item
	 *
	 * @access public
	 * @return void
	 */
	public function edit()
	{
		$all_settings 	= $this->settings_m->get_settings(array('is_gui'=>1));
		$settings_array = array();

		// Create dynamic validation rules
		foreach($all_settings as $setting)
		{
			$this->validation_rules			.= array('field' => $setting->slug, 'label' => $setting->slug, 'rules' => 'trim' . ($setting->is_required ? '|required' : ''));
			$settings_array[$setting->slug]	 = $setting->value;
		}

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);

		// Got valid data?
		if ($this->form_validation->run())
		{
			// Loop through again now we know it worked
			foreach($settings_array as $slug => $value)
			{
				// Dont update if its the same value
				if($this->input->post($slug, FALSE) != $slug)
				{
					$this->settings->set_item($slug, $this->input->post($slug, FALSE));
				}
			}

			// Success...
			$this->session->set_flashdata('success', $this->lang->line('settings_save_success'));
		}
		else
		{
			$this->session->set_flashdata('error', $this->form_validation->error_string);
		}

		// Redirect user back to index page or the module/section settings they are editing
		redirect('admin/settings');
	}
}
?>
