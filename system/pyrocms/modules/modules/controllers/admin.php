<?php
/**
 * Modules controller, lists all installed modules
 *
 * @author 		Phil Sturgeon - PyroCMS Development Team
 * @package 	PyroCMS
 * @subpackage 	Core modules
 * @category 	Modules
 * @since 		v1.0
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
		parent::Admin_Controller();

		$this->lang->load('modules');

		if ($this->settings->addons_upload)
		{
			$this->template->set_partial('shortcuts', 'admin/partials/shortcuts');
		}
	}

	/**
	 * Index method
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$this->module_m->import_unknown();

		$this->template
			->title($this->module_details['name'])
			->set('all_modules', $this->module_m->get_all(NULL, TRUE))
			->build('admin/index');
	}

	/**
	 * Upload
	 *
	 * Uploads an addon module
	 *
	 * @access	public
	 * @return	void
	 */
	public function upload()
	{
		if ( ! $this->settings->addons_upload)
		{
			show_error('Uploading add-ons has been disabled for this site. Please contact your administrator');
		}

		if ($this->input->post('btnAction') == 'upload')
		{
			
			$config['upload_path'] 		= UPLOAD_PATH;
			$config['allowed_types'] 	= 'zip';
			$config['max_size']			= '2048';
			$config['overwrite'] 		= TRUE;

			$this->load->library('upload', $config);

			if ($this->upload->do_upload())
			{
				$upload_data = $this->upload->data();

				// Check if we already have a dir with same name
				if ($this->module_m->exists($upload_data['raw_name']))
				{
					$this->session->set_flashdata('error', sprintf(lang('modules.already_exists_error'), $upload_data['raw_name']));
				}

				else
				{
					// Now try to unzip
					$this->load->library('unzip');
					$this->unzip->allow(array('xml', 'html', 'css', 'js', 'png', 'gif', 'jpeg', 'jpg', 'swf', 'ico', 'php'));

					// Try and extract
					if ( is_string($slug = $this->unzip->extract($upload_data['full_path'], ADDONPATH . 'modules/', TRUE, TRUE)) )
					{
						if ($this->module_m->install($slug, FALSE, TRUE))
						{
							$this->session->set_flashdata('success', sprintf(lang('modules.install_success'), $slug));
						}
						else
						{
							$this->session->set_flashdata('success', sprintf(lang('modules.install_error'), $slug));
						}
					}
					else
					{
						$this->session->set_flashdata('error', $this->unzip->error_string());
					}
				}

				// Delete uploaded file
				@unlink($upload_data['full_path']);

			}

			else
			{
				$this->session->set_flashdata('error', $this->upload->display_errors());
			}

			redirect('admin/modules');
		}

		$this->template
			->title($this->module_details['name'], lang('modules.upload_title'))
			->build('admin/upload', $this->data);
	}
	
	/**
	 * Uninstall
	 *
	 * Uninstalls an addon module
	 *
	 * @param	string	$slug	The slug of the module to uninstall
	 * @access	public
	 * @return	void
	 */
	public function uninstall($slug = '')
	{

		if ($this->module_m->uninstall($slug))
		{
			$this->session->set_flashdata('success', sprintf(lang('modules.uninstall_success'), $slug));

			redirect('admin/modules');
		}

		$this->session->set_flashdata('error', sprintf(lang('modules.uninstall_error'), $slug));
		redirect('admin/modules');
	}

	/**
	 * Delete
	 *
	 * Completely deletes an addon module
	 *
	 * @param	string	$slug	The slug of the module to delete
	 * @access	public
	 * @return	void
	 */
	public function delete($slug = '')
	{
		// Don't allow user to delete the entire module folder
		if ($slug == '/' OR $slug == '*' OR empty($slug))
		{
			show_error(lang('modules.module_not_specified'));
		}

		// lets kill this thing
		if ($this->module_m->uninstall($slug) AND $this->module_m->delete($slug))
		{
			$this->session->set_flashdata('success', sprintf(lang('modules.delete_success'), $slug));

			$path = ADDONPATH . 'modules/' . $slug;
			
			// they can only delete it if it's in the addons folder
			if ( is_dir($path) )
			{
				if (!$this->_delete_recursive($path))
				{
					$this->session->set_flashdata('notice', sprintf(lang('modules.manually_remove'), $path));
				}
			}

			redirect('admin/modules');
		}

		$this->session->set_flashdata('error', sprintf(lang('modules.delete_error'), $slug));
		redirect('admin/modules');
	}

	/**
	 * Enable
	 *
	 * Enables an addon module
	 *
	 * @param	string	$slug	The slug of the module to enable
	 * @access	public
	 * @return	void
	 */
	public function install($slug)
	{
		if ($this->module_m->install($slug))
		{
			// Clear the module cache
			$this->pyrocache->delete_all('module_m');
			$this->session->set_flashdata('success', sprintf(lang('modules.install_success'), $slug));
		}
		else
		{
			$this->session->set_flashdata('error', sprintf(lang('modules.install_error'), $slug));
		}

		redirect('admin/modules');
	}

	/**
	 * Enable
	 *
	 * Enables an addon module
	 *
	 * @param	string	$slug	The slug of the module to enable
	 * @access	public
	 * @return	void
	 */
	public function enable($slug)
	{
		if ($this->module_m->enable($slug))
		{
			// Clear the module cache
			$this->pyrocache->delete_all('module_m');
			$this->session->set_flashdata('success', sprintf(lang('modules.enable_success'), $slug));
		}
		else
		{
			$this->session->set_flashdata('error', sprintf(lang('modules.enable_error'), $slug));
		}

		redirect('admin/modules');
	}

	/**
	 * Disable
	 *
	 * Disables an addon module
	 *
	 * @param	string	$slug	The slug of the module to disable
	 * @access	public
	 * @return	void
	 */
	public function disable($slug)
	{
		if ($this->module_m->disable($slug))
		{
			// Clear the module cache
			$this->pyrocache->delete_all('module_m');
			$this->session->set_flashdata('success', sprintf(lang('modules.disable_success'), $slug));
		}
		else
		{
			$this->session->set_flashdata('error', sprintf(lang('modules.disable_error'), $slug));
		}

		redirect('admin/modules');
	}
	
	/**
	 * Upgrade
	 *
	 * Upgrade an addon module
	 *
	 * @param	string	$slug	The slug of the module to disable
	 * @access	public
	 * @return	void
	 */
	public function upgrade($slug)
	{
		// If upgrade succeeded
		if ($this->module_m->upgrade($slug))
		{
			$this->session->set_flashdata('success', sprintf(lang('modules.upgrade_success'), $slug));
		}
		// If upgrade failed
		else
		{
			$this->session->set_flashdata('error', sprintf(lang('modules.upgrade_error'), $slug));
		}
		
		redirect('admin/modules');
	}

	/**
	 * Delete Recursive
	 *
	 * Recursively delete a folder
	 *
	 * @param	string	$str	The path to delete
	 * @return	bool
	 */
	private function _delete_recursive($str)
	{
        if (is_file($str))
		{
            return @unlink($str);
        }
		elseif (is_dir($str))
		{
            $scan = glob(rtrim($str,'/').'/*');

			foreach($scan as $index => $path)
			{
                $this->_delete_recursive($path);
            }

            return @rmdir($str);
        }
    }
}
