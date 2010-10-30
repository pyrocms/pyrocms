<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin controller for the themes module
 *
 * @author 		Phil Sturgeon - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Themes module
 * @category	Modules
 */
class Admin extends Admin_Controller
{
	/**
	 * Constructor method
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		// Call the parent's constructor
		parent::Admin_Controller();
		$this->load->model('themes_m');
		$this->lang->load('themes');
	}

	/**
	 * List all themes
	 *
	 * @access public
	 * @return void
	 */
	public function index()
	{
		// Get the required data
		$this->template->append_metadata( css('themes.css', 'themes') );
		$this->data->themes = $this->themes_m->get_all();

		$this->template->set_partial('shortcuts', 'admin/partials/shortcuts');

		// Render the view
		$this->template
			->title($this->module_details['name'])
			->build('admin/index', $this->data);
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
		if($this->themes_m->set_default($theme) )
		{
			$this->session->set_flashdata('success', sprintf( lang('themes.set_default_success'), $theme));
		}

		else
		{
			$this->session->set_flashdata('error', sprintf( lang('themes.set_default_error'), $theme));
		}

		// Redirect the user
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
		if($this->input->post('btnAction') == 'upload')
		{
			$config['upload_path'] 		= FCPATH.'uploads/';
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
					$this->unzip->allow(array('xml', 'html', 'css', 'js', 'png', 'gif', 'jpeg', 'jpg', 'swf', 'ico', 'php')); // TODO DEPRECATE php

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
	public function delete($theme_name = "")
	{
		$this->load->helper('file');
		$name_array = $theme_name != "" ? array($theme_name) : $this->input->post('action_to');

		// Delete multiple
		if(!empty($name_array))
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
				$this->session->set_flashdata('success', sprintf(lang('themes.mass_delete_success'), $delete, $to_delete) );
			}
		}

		else
		{
			$this->session->set_flashdata('error', lang('themes.delete_select_error'));
		}

		redirect('admin/themes');
	}

}
