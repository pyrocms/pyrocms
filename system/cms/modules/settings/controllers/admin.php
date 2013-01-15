<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin controller for the settings module
 *
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Settings\Controllers
 */
class Admin extends Admin_Controller {

	/**
	 * Validation array
	 * 
	 * @var array
	 */
	private $validation_rules = array();

	/**
	 * Constructor method
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->model('settings_m');
		$this->load->library('settings');
		$this->load->library('form_validation');
		$this->lang->load('settings');
		$this->template->append_js('module::settings.js');
		$this->template->append_css('module::settings.css');
	}

	/**
	 * Index method, lists all generic settings
	 *
	 * @return void
	 */
	public function index()
	{
		$setting_language = array();
		$setting_sections = array();
		$settings = $this->settings_m->get_many_by(array('is_gui' => 1));

		// Loop through each setting
		foreach ($settings as $key => $setting)
		{
			$setting->form_control = $this->settings->form_control($setting);

			if (empty($setting->module))
			{
				$setting->module = 'general';
			}

			$setting_language[$setting->module] = array();

			// Get Section name from native translation, third party translation or only use module name
			if ( ! isset($setting_sections[$setting->module]))
			{
				$section_name = lang('settings:section_'.$setting->module);

				if ($this->module_m->exists($setting->module))
				{
					list($path, $_langfile) = Modules::find('settings_lang', $setting->module, 'language/'.config_item('language').'/');

					if ($path !== false)
					{
						$setting_language[$setting->module] = $this->lang->load($setting->module.'/settings', '', true);

						if (empty($section_name) && isset($setting_language[$setting->module]['settings:section_'.$setting->module]))
						{
							$section_name = $setting_language[$setting->module]['settings:section_'.$setting->module];
						}
					}
				}

				if (empty($section_name))
				{
					$section_name = ucfirst(strtr($setting->module, '_', ' '));
				}

				$setting_sections[$setting->module] = $section_name;
			}

			// Get Setting title and description translations as Section name
			foreach (array(
				'title' => 'settings:'.$setting->slug,
				'description' => 'settings:'.$setting->slug.'_desc'
			) as $key => $name)
			{
				${$key} = lang($name);

				if (empty(${$key}))
				{
					if (isset($setting_language[$setting->module][$name]))
					{
						${$key} = $setting_language[$setting->module][$name];
					}
					else
					{
						${$key} = $setting->{$key};
					}
				}

				$setting->{$key} = ${$key};
			}

			$settings[$setting->module][] = $setting;

			unset($settings[$key]);
		}

		// Render the layout
		$this->template
			->title($this->module_details['name'])
			->build('admin/index', compact('setting_sections', 'settings'));
	}

	/**
	 * Edit an existing settings item
	 *
	 * @return void
	 */
	public function edit()
	{
		if (PYRO_DEMO)
		{
			$this->session->set_flashdata('notice', lang('global:demo_restrictions'));
			redirect('admin/settings');
		}
		
		$settings = $this->settings_m->get_many_by(array('is_gui'=>1));

		// Create dynamic validation rules
		foreach ($settings as $setting)
		{
			$this->validation_rules[] = array(
				'field' => $setting->slug.(in_array($setting->type, array('select-multiple', 'checkbox')) ? '[]' : ''),
				'label' => 'lang:settings:'.$setting->slug,
				'rules' => 'trim'.($setting->is_required ? '|required' : '').($setting->type !== 'textarea' ? '|max_length[255]' : '')
			);
		}

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);

		// Got valid data?
		if ($this->form_validation->run())
		{
			$settings_stored = array();
			
			// Loop through again now we know it worked
			foreach ($settings as $setting)
			{
				$new_value = $this->input->post($setting->slug, false);

				// Store arrays as CSV
				if (is_array($new_value))
				{
					$new_value = implode(',', $new_value);
				}

				// Only update passwords if not placeholder value
				if ($setting->type === 'password' and $new_value === 'XXXXXXXXXXXX')
				{
					continue;
				}

				// Dont update if its the same value
				if ($new_value != $setting->value)
				{
					Settings::set($setting->slug, $new_value);

					$settings_stored[$setting->slug] = $new_value;
				}
			}
			
			// Fire an event. Yay! We know when settings are updated. 
			Events::trigger('settings_updated', $settings_stored);

			// Success...
			$this->session->set_flashdata('success', lang('settings:save_success'));
		}
		elseif (validation_errors())
		{
			$this->session->set_flashdata('error', validation_errors());
		}

		redirect('admin/settings');
	}

	/**
	 * Sort settings items
	 *
	 * @return void
	 */
	public function ajax_update_order()
	{
		$slugs = explode(',', $this->input->post('order'));

		$i = 1000;
		foreach ($slugs as $slug)
		{
			$this->settings_m->update($slug, array(
				'order' => $i--,
			));
		}
	}
}

/* End of file admin.php */