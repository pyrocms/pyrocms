<?php
/**
 * Modules controller, lists all installed modules
 *
 * @author 		Yorick Peterse - PyroCMS Development Team
 * @package 	PyroCMS
 * @subpackage 	Core modules
 * @category 	Modules
 * @since 		v0.9.7
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

		$this->template->set_partial('shortcuts', 'admin/partials/shortcuts');

		// Check the referrer
		parse_url($this->input->server('HTTP_REFERER'), PHP_URL_HOST) == parse_url(BASE_URL, PHP_URL_HOST) or show_error('Invalid Referrer');

	}

	/**
	 * Index method
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$this->modules_m->import_all();
		$this->cache->delete_all('modules_m');

 		$this->data->modules = $this->modules_m->get_all(NULL, TRUE);

		$this->template
			->title($this->module_data['name'])
			->build('admin/index', $this->data);
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
		if($this->input->post('btnAction') == 'upload')
		{
			$config['upload_path'] 		= APPPATH.'uploads/';
			$config['allowed_types'] 	= 'zip';
			$config['max_size']			= '2048';
			$config['overwrite'] 		= TRUE;

			$this->load->library('upload', $config);

			if ($this->upload->do_upload())
			{
				$upload_data = $this->upload->data();

				// Check if we already have a dir with same name
				if($this->modules_m->exists($upload_data['raw_name']))
				{
					$this->session->set_flashdata('error', sprintf(lang('modules.already_exists_error'), $upload_data['raw_name']));
				}

				else
				{
					// Now try to unzip
					$this->load->library('unzip');
					$this->unzip->allow(array('xml', 'html', 'css', 'js', 'png', 'gif', 'jpeg', 'jpg', 'swf', 'ico', 'php'));

					// Try and extract
					if($this->unzip->extract($upload_data['full_path'], ADDONPATH . 'modules/'))
					{
						if($this->modules_m->install($upload_data['raw_name']))
						{
							$this->session->set_flashdata('success', sprintf(lang('modules.install_success'), $upload_data['raw_name']));
						}
						else
						{

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

			// Clear the cache
			$this->cache->delete_all('modules_m');

			redirect('admin/modules');
		}

		$this->template
			->title($this->module_data['name'],lang('modules.upload_title'))
			->build('admin/upload', $this->data);
	}

	/**
	 * Uninstall
	 *
	 * Uninstalls an addon module
	 *
	 * @param	string	$module_slug	The slug of the module to uninstall
	 * @access	public
	 * @return	void
	 */
	public function uninstall($module_slug = '')
	{

		// Don't allow user to delete the entire module folder
		if($module_slug == '/' || $module_slug == '*' || empty($module_slug))
		{
			show_error(lang('modules.module_not_specified'));
		}

		if($this->modules_m->uninstall($module_slug))
		{
			$this->session->set_flashdata('success', sprintf(lang('modules.uninstall_success'), $module_slug));

			$path = ADDONPATH . 'modules/' . $module_slug;

			if(!$this->_delete_recursive($path))
			{
				$this->session->set_flashdata('notice', sprintf(lang('modules.manually_remove'), $path));
			}

			redirect('admin/modules');
		}
		$this->session->set_flashdata('error', sprintf(lang('modules.uninstall_error'), $module_slug));
		redirect('admin/modules');
	}

	public function reimport()
	{
		$this->modules_m->import_all();
		$this->cache->delete_all('modules_m');
		$this->session->set_flashdata('success', 'All Modules have ben re-imported.');
		redirect('admin/modules');

	}

	/**
	 * Enable
	 *
	 * Enables an addon module
	 *
	 * @param	string	$module_slug	The slug of the module to enable
	 * @access	public
	 * @return	void
	 */
	public function enable($module_slug)
	{
		if($this->modules_m->enable($module_slug))
		{
			// Clear the module cache
			$this->cache->delete_all('modules_m');
			$this->session->set_flashdata('success', sprintf(lang('modules.enable_success'), $module_slug));
		}
		else
		{
			$this->session->set_flashdata('error', sprintf(lang('modules.enable_error'), $module_slug));
		}

		redirect('admin/modules');
	}

	/**
	 * Disable
	 *
	 * Disables an addon module
	 *
	 * @param	string	$module_slug	The slug of the module to disable
	 * @access	public
	 * @return	void
	 */
	public function disable($module_slug)
	{
		if($this->modules_m->disable($module_slug))
		{
			// Clear the module cache
			$this->cache->delete_all('modules_m');
			$this->session->set_flashdata('success', sprintf(lang('modules.disable_success'), $module_slug));
		}
		else
		{
			$this->session->set_flashdata('error', sprintf(lang('modules.disable_error'), $module_slug));
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
        if(is_file($str))
		{
            return @unlink($str);
        }
		elseif(is_dir($str))
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
