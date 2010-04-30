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
	}
	
	/**
	 * Index method
	 * @access public
	 * @return void
	 */
	public function index()
	{
 		$this->data->modules = $this->modules_m->get_modules();
			  
		$this->template->build('admin/index', $this->data);
	}

	/**
	 * Install
	 *
	 * Installs a third_party module
	 *
	 * @access	public
	 * @return	void
	 */
	public function install()
	{

	}

	/**
	 * Uninstall
	 *
	 * Uninstalls a third_party module
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

		$path = 'third_party/modules/' . $module_slug;

		if($this->_delete_recursive($path))
		{
			$this->session->set_flashdata('success', lang('modules.uninstall_success'));
			redirect('admin/modules');
		}
		$this->session->set_flashdata('error', lang('modules.uninstall_error'));
		redirect('admin/modules');
	}

	/**
	 * Enable
	 *
	 * Enables a third_party module
	 *
	 * @param	string	$module_slug	The slug of the module to enable
	 * @access	public
	 * @return	void
	 */
	public function enable($module_slug)
	{
		$old_path = 'third_party/modules/' . $module_slug;
		$new_path = 'third_party/modules/' . substr($module_slug, 0, strlen($module_slug) - 9);

		if(is_dir($old_path))
		{
			if(rename($old_path, $new_path))
			{
				$this->session->set_flashdata('success', lang('modules.enable_success'));
				redirect('admin/modules');
			}
		}
		$this->session->set_flashdata('error', lang('modules.enable_error'));
		redirect('admin/modules');
	}

	/**
	 * Disable
	 *
	 * Disables a third_party module
	 *
	 * @param	string	$module_slug	The slug of the module to disable
	 * @access	public
	 * @return	void
	 */
	public function disable($module_slug)
	{
		$old_path = 'third_party/modules/' . $module_slug;
		$new_path = 'third_party/modules/' . $module_slug . '.disabled';

		if(is_dir($old_path))
		{
			if(rename($old_path, $new_path))
			{
				$this->session->set_flashdata('success', lang('modules.disable_success'));
				redirect('admin/modules');
			}
		}
		$this->session->set_flashdata('error', lang('modules.disable_error'));
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
?>