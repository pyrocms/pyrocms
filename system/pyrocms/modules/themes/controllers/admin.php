<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin controller for the themes module
 *
 * @author 		Phil Sturgeon - PyroCMS Dev Team
 * @author		Jerel Unruh - PyroCMS Development Team
 * @package 	PyroCMS
 * @subpackage 	Themes module
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
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		// Call the parent's constructor
		parent::__construct();
		$this->load->model('themes_m');
		$this->lang->load('themes');
		$this->load->library('form_validation');

		$this->template
			->set_partial('shortcuts', 'admin/partials/shortcuts')
			->append_metadata(css('themes.css', 'themes'))
			->append_metadata(js('admin.js', 'themes'));
	}

	/**
	 * List all themes
	 *
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$themes = $this->themes_m->get_all();
		
		$data = array();
		
		foreach ($themes AS $theme)
		{
			if ( ! isset($theme->type) OR $theme->type != 'admin')
			{
				if ($theme->slug == $this->settings->default_theme)
				{
					$theme->is_default = TRUE;
				}
				
				$data['themes'][] = $theme;
			}
		}

		// Render the view
		$this->template
			->title($this->module_details['name'])
			->build('admin/index', $data);
	}
	
	/**
	 * Save the option settings
	 *
	 * @param 	string	$slug	The theme slug
	 * @access public
	 * @return void
	 */
	public function options($slug = '')
	{
		if ($this->input->post('btnAction') == 're-index')
		{
			$this->themes_m->delete_options($this->input->post('slug'));
			
			// now re-index all themes that don't have saved options
			if ($this->themes_m->get_all())
			{
				// Success...
				$data = array();
				$data['messages']['success'] = lang('themes.re-index_success');
				$message = $this->load->view('admin/partials/notices', $data, TRUE);

				return $this->template->build_json(array(
					'status'	=> 'success',
					'message'	=> $message
				));
			}
		}
		
		$all_options 	= $this->themes_m->get_options_by(array('theme'=> $slug));
		$options_array 	= array();

		if ($all_options)
		{
			// Create dynamic validation rules
			foreach($all_options as $option)
			{
				$this->validation_rules[] = array(
					'field' => $option->slug . (in_array($option->type, array('select-multiple', 'checkbox')) ? '[]' : ''),
					'label' => $option->title,
					'rules' => 'trim' . ($option->is_required ? '|required' : '') . '|max_length[255]'
				);
	
				$options_array[$option->slug] = $option->value;
			}

			// Set the validation rules
			$this->form_validation->set_rules($this->validation_rules);
	
			// Got valid data?
			if ($this->form_validation->run())
			{
				// Loop through again now we know it worked
				foreach($options_array as $option_slug => $stored_value)
				{
					$input_value = $this->input->post($option_slug, FALSE);
	
					if (is_array($input_value))
					{
						$input_value = implode(',', $input_value);
					}
	
					// Dont update if its the same value
					if ($input_value !== $stored_value)
					{
						$this->themes_m->update_options($option_slug, array('value' => $input_value));
					}
				}
	
				// Success...
				$data = array();
				$data['messages']['success'] = lang('themes.save_success');
				$message = $this->load->view('admin/partials/notices', $data, TRUE);

				return $this->template->build_json(array(
					'status'	=> 'success',
					'message'	=> $message
				));

			}
			elseif (validation_errors())
			{
				$data = array();
				$message = $this->load->view('admin/partials/notices', $data, TRUE);

				return $this->template->build_json(array(
					'status'	=> 'error',
					'message'	=> $message
				));
			}
		}
		
		$this->data->slug			= $slug;
		$this->data->options_array 	= $all_options;
		$this->data->controller		= &$this;

		$this->template->set_layout('modal', 'admin')
			->build('admin/options', $this->data);
	}

	/**
	 * Set the default theme to theme X
	 *
	 * @access public
	 * @return void
	 */
	public function set_default()
	{
		// Store the theme name
		$theme = $this->input->post('theme');

		// Set the theme
		if ($this->themes_m->set_default($this->input->post()))
		{
			$this->session->set_flashdata('success', sprintf(lang('themes.set_default_success'), $theme));
		}

		else
		{
			$this->session->set_flashdata('error', sprintf( lang('themes.set_default_error'), $theme));
		}

		if ($this->input->post('method') == 'admin_themes')
		{
			redirect('admin/themes/admin_themes');
		}
		
		redirect('admin/themes');
	}

	/**
	 * Upload a theme to the server
	 *
	 * @access public
	 * @return void
	 */
	public function upload()
	{
		if ( ! $this->settings->addons_upload)
		{
			show_error('Uploading add-ons has been disabled for this site. Please contact your administrator');
		}

		if($this->input->post('btnAction') == 'upload')
		{
			$config['upload_path'] 		= FCPATH.UPLOAD_PATH;
			$config['allowed_types'] 	= 'zip';
			$config['max_size']			= '2048';
			$config['overwrite'] 		= TRUE;

			$this->load->library('upload', $config);

			if ($this->upload->do_upload())
			{
				$upload_data = $this->upload->data();

				// Check if we already have a dir with same name
				if($this->template->theme_exists($upload_data['raw_name']))
				{
					$this->session->set_flashdata('error', lang('themes.already_exists_error'));
				}

				else
				{
					// Now try to unzip
					$this->load->library('unzip');
					$this->unzip->allow(array('xml', 'html', 'css', 'js', 'png', 'gif', 'jpeg', 'jpg', 'swf', 'ico', 'php', 'txt', 'eot', 'svg', 'ttf', 'woff')); // TODO DEPRECATE php

					// Try and extract
					$this->unzip->extract($upload_data['full_path'], ADDONPATH . 'themes/' )
						? $this->session->set_flashdata('success', lang('themes.upload_success'))
						: $this->session->set_flashdata('error', $this->unzip->error_string());
				}

				// Delete uploaded file
				@unlink($upload_data['full_path']);
			}

			else
			{
				$this->session->set_flashdata('error', $this->upload->display_errors());
			}

			redirect('admin/themes');
		}

		$this->template
			->title($this->module_details['name'], lang('themes.upload_title'))
			->build('admin/upload', $this->data);
	}

	/**
	 * Delete an existing theme
	 *
	 * @access public
	 * @param string $theme_name The name of the theme to delete
	 * @return void
	 */
	public function delete($theme_name = '')
	{
		$this->load->helper('file');
		$name_array = $theme_name ? array($theme_name) : $this->input->post('action_to');

		// Delete multiple
		if ( ! empty($name_array))
		{
			$deleted = 0;
			$to_delete = 0;
			foreach ($name_array as $theme_name)
			{
				$theme_name = urldecode($theme_name);
				$to_delete++;

				if($this->settings->default_theme == $theme_name)
				{
					$this->session->set_flashdata('error', lang('themes.default_delete_error'));
				}

				else
				{
					$theme_dir = ADDONPATH.'themes/'.$theme_name;

					if( is_really_writable($theme_dir) )
					{
						delete_files($theme_dir, TRUE);

						if(@rmdir($theme_dir))
						{
							$deleted++;
						}
					}

					else
					{
						$this->session->set_flashdata('error', sprintf(lang('themes.delete_error'), $theme_dir) );
					}
				}
			}

			if( $deleted == $to_delete)
			{
				$this->session->set_flashdata('success', sprintf(lang('themes.mass_delete_success'), $deleted, $to_delete) );
			}
		}

		else
		{
			$this->session->set_flashdata('error', lang('themes.delete_select_error'));
		}

		redirect('admin/themes');
	}
	
	/**
	 * Form Control
	 *
	 * Returns the form control for the theme option
	 *
	 * @param	object	$option
	 * @return	string
	 */
	public function form_control(&$option)
	{
		if ($option->options)
		{
			if (substr($option->options, 0, 5) == 'func:')
			{
				if (is_callable($func = substr($option->options, 5)))
				{
					$option->options = call_user_func($func);
				}
				else
				{
					$option->options = array('=' . lang('select.none'));
				}
			}

			if (is_string($option->options))
			{
				$option->options = explode('|', $option->options);
			}
		}

		switch ($option->type)
		{
			default:
			case 'text':
				$form_control = form_input(array(
					'id'	=> $option->slug,
					'name'	=> $option->slug,
					'value'	=> $option->value,
					'class'	=> 'text width-20'
				));
				break;

			case 'textarea':
				$form_control = form_textarea(array(
					'id'	=> $option->slug,
					'name'	=> $option->slug,
					'value'	=> $option->value,
					'class'	=> 'width-20'
				));
				break;

			case 'password':
				$form_control = form_password(array(
					'id'	=> $option->slug,
					'name'	=> $option->slug,
					'value'	=> $option->value,
					'class'	=> 'text width-20',
					'autocomplete' => 'off',
				));
				break;

			case 'select':
				$form_control = form_dropdown($option->slug, $this->_format_options($option->options), $option->value, 'class="width-20"');
				break;

			case 'select-multiple':
				$options = $this->_format_options($option->options);
				$size = sizeof($options) > 10 ? ' size="10"' : '';
				$form_control = form_multiselect($option->slug . '[]', $options, explode(',', $option->value), 'class="width-20"' . $size);
				break;

			case 'checkbox':

				$form_control = '';
				$stored_values = is_string($option->value) ? explode(',', $option->value) : $option->value;

				foreach ($this->_format_options($option->options) as $value => $label)
				{
					if (is_array($stored_values))
					{
						$checked = in_array($value, $stored_values);
					}
					else
					{
						$checked = FALSE;
					}

					$form_control .= '<label>';
					$form_control .= '' . form_checkbox(array(
						'id'		=> $option->slug . '_' . $value,
						'name'		=> $option->slug . '[]',
						'checked'	=> $checked,
						'value'		=> $value
					));
					$form_control .= ' ' . $label . '</label>';
				}
				break;

			case 'radio':

				$form_control = '';
				foreach ($this->_format_options($option->options) as $value => $label)
				{
					$form_control .= '' . form_radio(array(
						'id'		=> $option->slug,
						'name'		=> $option->slug,
						'checked'	=> $option->value == $value,
						'value'		=> $value
					)) . ' ' . $label . '';
				}
				break;
		}

		return $form_control;
	}
	
	/**
	 * Format Options
	 *
	 * Formats the options for a theme option into an associative array.
	 *
	 * @param	array	$options
	 * @return	array
	 */
	private function _format_options($options = array())
	{
		$select_array = array();

		foreach ($options as $option)
		{
			list($value, $name) = explode('=', $option);

			$select_array[$value] = $name;
		}

		return $select_array;
	}
}